<?php

require_once("../connection/connection.php"); 

$users = [
    ["first_name" => "Layla", "last_name" => "Khaled", "email" => "layla1@example.com", "phone_number" => "70000001", "password" => "pass1"],
    ["first_name" => "Rami", "last_name" => "Saleh", "email" => "rami2@example.com", "phone_number" => "70000002", "password" => "pass2"],
    ["first_name" => "Nour", "last_name" => "Hassan", "email" => "nour3@example.com", "phone_number" => "70000003", "password" => "pass3"],
    ["first_name" => "Maya", "last_name" => "Zein", "email" => "maya4@example.com", "phone_number" => "70000004", "password" => "pass4"],
    ["first_name" => "Tariq", "last_name" => "Haddad", "email" => "tariq5@example.com", "phone_number" => "70000005", "password" => "pass5"],
    ["first_name" => "Lina", "last_name" => "Barakat", "email" => "lina6@example.com", "phone_number" => "70000006", "password" => "pass6"],
    ["first_name" => "Khaled", "last_name" => "Jaber", "email" => "khaled7@example.com", "phone_number" => "70000007", "password" => "pass7"],
    ["first_name" => "Dina", "last_name" => "Sami", "email" => "dina8@example.com", "phone_number" => "70000008", "password" => "pass8"],
    ["first_name" => "Omar", "last_name" => "Ahmad", "email" => "omar9@example.com", "phone_number" => "70000009", "password" => "pass9"],
    ["first_name" => "Sara", "last_name" => "Najjar", "email" => "sara10@example.com", "phone_number" => "70000010", "password" => "pass10"]
];

foreach ($users as $user) {
    $hashedPassword = password_hash($user["password"], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("
        INSERT INTO users (first_name, last_name, email, phone_number, password)
        VALUES (?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "sssss",
        $user["first_name"],
        $user["last_name"],
        $user["email"],
        $user["phone_number"],
        $hashedPassword
    );

    if ($stmt->execute()) {
        echo "Inserted user: {$user['email']}<br>";
    } else {
        echo "Error inserting user {$user['email']}: " . $stmt->error . "<br>";
    }

    $stmt->close();
}

$conn->close();
