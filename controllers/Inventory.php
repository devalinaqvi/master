<?php

if(#_SESSION['role'] != 'admin') {
    header('Location: /');
    exit();
}
include '../classes/Database.php';
function fetchInventory()
{
    try {
        $pdo = Database::getInstance()->getConnection();

        $stmt = $pdo->query("SELECT * FROM inventory");

        $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');

        if($inventory) {
            echo json_encode([
                'status' => 'success',
                'data' => $inventory
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No inventory data found'
            ]);
        }
    } catch(PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}