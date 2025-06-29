<?php

require("../connection/connection.php");

$sql = "CREATE TABLE shows (
                             id INT(11) AUTO_INCREMENT PRIMARY KEY,
                             movie_id INT(11) NOT NULL,
                             start_time DATETIME NOT NULL,
                             hall VARCHAR(255) NOT NULL,
                             FOREIGN KEY (movie_id) REFERENCEs movies(id) ON DELETE CASCADE  
)";

$query = $conn->prepare($sql);
$query->execute();

$conn->close();