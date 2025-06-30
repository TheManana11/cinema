<?php

require("../connection/connection.php");

$sql = "ALTER TABLE movies ADD genre ENUM('Drama','Comedy', 'Horror', 'Science Fiction (Sci-Fi), Fantasy', 'Action', 'Romance', 'Mystery') DEFAULT 'Action'";

$query = $conn->prepare($sql);
$query->execute();

$conn->close();