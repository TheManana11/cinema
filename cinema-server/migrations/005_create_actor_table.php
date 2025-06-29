<?php

require("../connection/connection.php");

$sql = "CREATE TABLE actors (
                             id INT(11) AUTO_INCREMENT PRIMARY KEY,
                             name VARCHAR(255) NOT NULL,
                             age INT(11) NOT NULL
)";

$query = $conn->prepare($sql);
$query->execute();

$conn->close();