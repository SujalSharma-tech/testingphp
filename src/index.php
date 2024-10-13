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
    // $db_name = "mysql:hostname=localhost;dbname=testing";
    // $username = "root";
    // $password = "";
    $db_name = "mysql:hostname=baoujjgsjzuqlvv6pv3a-mysql.services.clever-cloud.com;dbname=baoujjgsjzuqlvv6pv3a";
    $username = "ukmwxvkswbgi855r";
    $password = "E8AEDEOIVkTIQ8jhuJxf";

    // $conn = new PDO($db_name, $username, $password);
    // $conn2 =
    $mysqli = new mysqli("baoujjgsjzuqlvv6pv3a-mysql.services.clever-cloud.com", "ukmwxvkswbgi855r", "E8AEDEOIVkTIQ8jhuJxf", "baoujjgsjzuqlvv6pv3a");
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    } else {
        echo "Connected";
    }

    // $sql0 = $mysqli->query("INSERT INTO Students (Id, Name, Age, City) VALUES (2,'Aman',20,'Phg')");
    $first_name = "Sujal";
    $last_name = "Sharma";
    $email = "sharmasujal995@example.com";
    $password = "hashed_password";
    $phone_number = "8474726477";
    $is_verified = 1;
    $is_landlord = 0;
    $stmt = $mysqli->prepare("INSERT INTO users (first_name, last_name, email, password, phone_number, is_verified, is_landlord) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $first_name, $last_name, $email, $password, $phone_number, $is_verified, $is_landlord);
    $stmt->execute();

    $sql1 = $mysqli->query("SELECT * FROM users");

    // print_r($sql1->fetch_all(MYSQLI_ASSOC));


    while ($row = $sql1->fetch_all(MYSQLI_ASSOC)) {
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
