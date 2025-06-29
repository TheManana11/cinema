<?php

require("../connection/connection.php");

$sql = "CREATE TABLE seats (
                             id INT(11) AUTO_INCREMENT PRIMARY KEY,
                             show_id INT(11) NOT NULL,
                             row CHAR(1) NOT NULL,
                             number int(11) NOT NULL,
                             is_booked BOOLEAN DEFAULT FALSE,
                             UNIQUE(show_id, row, number),

                             FOREIGN KEY (show_id) REFERENCES shows(id) ON DELETE CASCADE           
)";

$query = $conn->prepare($sql);
$query->execute();

$conn->close();