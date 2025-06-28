<?php

require("../connection/connection.php");

$sql = "ALTER TABLE movies ADD image VARCHAR(255) NOT NULL";

$query = $conn->prepare($sql);
$query->execute();

$conn->close();