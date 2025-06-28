<?php

require("../connection/connection.php");

$sql = "CREATE TABLE movies (
                             id INT(11) AUTO_INCREMENT PRIMARY KEY,
                             name VARCHAR(255) NOT NULL,
                             description TEXT NOT NULL,
                             price DOUBLE NOT NULL,
                             rating ENUM ('1', '2', '3', '4', '5') NOT NULL,
                             release_date Date NOT NULL   
)";

$query = $conn->prepare($sql);
$query->execute();

$conn->close();