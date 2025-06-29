<?php

require("../connection/connection.php");

$sql = "ALTER TABLE shows ADD CONSTRAINT unique_movies UNIQUE (movie_id, start_time, hall) ";

$query = $conn->prepare($sql);
$query->execute();

$conn->close();