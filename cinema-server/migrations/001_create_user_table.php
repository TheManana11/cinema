<?php

require("../connection/connection.php");

$sql_query = "CREATE TABLE users (
                                  id INT(11) AUTO_INCREMENT PRIMARY KEY,
                                  first_name VARCHAR(255) NOT NULL,
                                  last_name VARCHAR(255) NOT NULL,
                                  email VARCHAR(25) NOT NULL UNIQUE,
                                  phone_number VARCHAR(255) NOT NULL,
                                  password VARCHAR(255) NOT NULL,
                                  user_type ENUM('user', 'admin') NOT NULL DEFAULT 'user'
                                  )";

$stmt = $conn->prepare($sql_query);
$stmt->execute();

$conn->close();



