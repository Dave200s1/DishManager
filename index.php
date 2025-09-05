<?php
header("Content-Type: application/json");


// Datei für die persistenten Daten
//$menuFile = __DIR__ . "/menu.json"; Old
require_once __DIR__ . "/database.php"; //Datenbank inkludieren

// Menü  initialisieren
/*
if (file_exists($menuFile)) {
    $menu = json_decode(file_get_contents($menuFile), true);
} else {
    $menu = [
        ["id" => 1, "name" => "Pizza Margarita", "price" => 8.99],
        ["id" => 2, "name" => "Spagetti-Bolonese", "price" => 18.99],
        ["id" => 3, "name" => "Tiramisu", "price" => 4.99],
        ["id" => 4, "name" => "Wein", "price" => 6.99],
    ];
    file_put_contents($menuFile, json_encode($menu, JSON_PRETTY_PRINT));
}
*/
// Routing
$route  = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$method = $_SERVER['REQUEST_METHOD'];

// Prüfen, ob die Ressource "menu" angefragt wurde
if (!isset($route[1]) || $route[1] != "menu") {
    http_response_code(404);
    echo json_encode(["error" => "Not found"]);
    exit;
}

$id = $route[2] ?? null;

// CRUD-Methoden
switch ($method) {
    case 'GET':
        if($id){
            $stmt = $connection->prepare("SELECT * FROM menu WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $item = $result->fetch_assoc();

            if ($item) {
                echo json_encode($item);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Item not found"]);
            }
        }else {
            $result = $connection->query("SELECT * FROM menu");
            $menu = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($menu);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data["name"]) || !isset($data["price"])) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid input"]);
            exit;
        }

        $stmt = $connection->prepare("INSERT INTO menu (name, price) VALUES (?, ?)");
        $stmt->bind_param("sd", $data["name"], $data["price"]);
        $stmt->execute();

        $newId = $connection->insert_id;
        http_response_code(201);
        echo json_encode([
            "id" => $newId,
            "name" => $data["name"],
            "price" => $data["price"]
        ]);
        break;

    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Missing ID"]);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        //$found = false;
        $stmt = $connection->prepare("UPDATE menu SET name = ?, price = ? WHERE id = ?");
        $stmt->bind_param(
            "sdi",
            $data["name"] ?? '',
            $data["price"] ?? 0,
            $id
        );
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["message" => "Item updated"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Item not found"]);
        }
        break;


    case 'DELETE':
        if ($id) {
                http_response_code(400);
                echo json_encode(["error" => "Missing ID"]);
                exit;
        }

            $stmt = $connection->prepare("DELETE FROM menu WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo json_encode(["message" => "Item deleted"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Item not found"]);
            }
            break;

    
    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
}