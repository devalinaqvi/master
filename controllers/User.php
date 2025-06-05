<?php
include '../classes/Database.php';

function fetchData()
{
    try {
        $pdo = Database::getInstance()->getConnection();

        // print_r($pdo);

        $stmt = $pdo->query("SELECT * FROM users");

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');


        if($users) {

            echo json_encode([
                'status' => 'success',
                'data' => $users
            ]);

            /*
            foreach($users as $user) {
                echo "ID: " . $user['id'] . "<br>";
                echo "Name: " . $user['username'] . "<br>";
                echo "Email: " . $user['email'] . "<br>";
            }
            */

    } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }
    catch(PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
        // echo "Database Error: " . $e->getMessage();
    }
}

$data = fetchData();

print_r($data);