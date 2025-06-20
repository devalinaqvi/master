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

function addInventory($data)
{
    try {
        $pdo = Database::getInstance()->getConnection();

        $stmt = $pdo->prepare("INSERT INTO inventory (name, quantity, price) VALUES (:name, :quantity, :price)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':quantity', $data['quantity']);
        $stmt->bindParam(':price', $data['price']);

        if($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Inventory item added successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to add inventory item'
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

function updateInventory($id, $data)
{
    try {
        $pdo = Database::getInstance()->getConnection();

        $stmt = $pdo->prepare("UPDATE inventory SET name = :name, quantity = :quantity, price = :price WHERE id = :id");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':quantity', $data['quantity']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':id', $id);

        if($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Inventory item updated successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update inventory item'
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