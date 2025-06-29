<?php

require("../connection/connection.php");

$sql = "CREATE TABLE actor_movie (
                             movie_id INT(11) NOT NULL,
                             actor_id INT(11) NOT NULL,
                             
                             PRIMARY KEY (movie_id, actor_id),
                             FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
                             FOREIGN KEY (actor_id) REFERENCES actors(id) ON DELETE CASCADE    
)";

$query = $conn->prepare($sql);
$query->execute();

$conn->close();