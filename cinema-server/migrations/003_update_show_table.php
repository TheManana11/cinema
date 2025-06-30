<?php

require("../connection/connection.php");

$sql = "ALTER TABLE shows ADD CONSTRAINT unique_time_hall UNIQUE (start_time, hall) ";

$query = $conn->prepare($sql);
$query->execute();

$conn->close();