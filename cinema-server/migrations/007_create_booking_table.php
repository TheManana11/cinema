<?php

require("../connection/connection.php");

$sql = "CREATE TABLE bookings (
                             id INT(11) AUTO_INCREMENT PRIMARY KEY,
                             user_id INT(11) NOT NULL,
                             movie_id INT(11) NOT NULL,
                             show_id INT(11) NOT NULL,
                             seat_id INT(11) NOT NULL,
                             
                             UNIQUE KEY (user_id, movie_id, show_id, seat_id),
                             FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
                             FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                             FOREIGN KEY (show_id) REFERENCES shows(id) ON DELETE CASCADE,
                             FOREIGN KEY (seat_id) REFERENCES seats(id) ON DELETE CASCADE
)";

$query = $conn->prepare($sql);
$query->execute();

$conn->close();
