<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once('./vendor/autoload.php');
header('Content-Type: application/json');
$secretKey = 'your-secret-key';


function generateToken($email, $password)
{
    global $secretKey;


    $issuedAt = time();
    $expirationTime = $issuedAt + 3600;
    $payload = array(
        'iat' => $issuedAt,
        'exp' => $expirationTime,
        'data' => array(
            'email' => $email,
            'password' => $password
        )
    );

    $jwt = JWT::encode($payload, $secretKey, 'HS256');

    return $jwt;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $expirationTime = time() + 3600;
    $data = json_decode(file_get_contents("php://input"), true);
    $email = htmlspecialchars($data['email']);
    $password = htmlspecialchars($data['password']);

    $token = generateToken($email, $password);
    setcookie("token", $token, $expirationTime, "/", "localhost", true, true);

    $db_name = "mysql:hostname=mysql_db;dbname=example";
    $username = "root";
    $password = "";

    $conn = new PDO($db_name, $username, $password);

    $sql1 = $conn->query("SELECT * FROM Students");
    $sql2 = $conn->query("SELECT * FROM Students");

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }


    echo json_encode([
        'token' => $token,
        'message' => 'Data received successfully!'
    ]);
} else if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_COOKIE['token'])) {
        $token = $_COOKIE['token'];
        global $secretKey;
        try {
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

            $email = $decoded->data->email;
            $password = $decoded->data->password;

            echo json_encode([
                'email' => $email,
                'password' => $password
            ]);
        } catch (Exception $e) {
            echo 'Token is invalid or expired: ', $e->getMessage();
        }
    } else {
        echo json_encode([
            'message' => 'Token not found!'
        ]);
    }
} else {
    echo json_encode([
        'message' => 'Data not received!'
    ]);
}





// $db_name = "mysql:hostname=localhost;dbname=testing";
// $username = "root";
// $password = "";

// $conn = new PDO($db_name, $username, $password);

// $sql1 = $conn->query("SELECT * FROM Students");
// $sql2 = $conn->query("SELECT * FROM Students");

// while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
//     echo "<pre>";
//     print_r($row);
//     echo "</pre>";
// }
