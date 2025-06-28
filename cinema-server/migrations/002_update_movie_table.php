<?php

require("../connection/connection.php");

$sql = "ALTER TABLE movies ADD duration TIME, ADD language VARCHAR(255)";

$query = $conn->prepare($sql);
$query->execute();

$conn->close();