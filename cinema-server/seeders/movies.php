<?php
require_once("../connection/connection.php");

$movies = [
    // ————— English Movies (10) —————
    [
        "name" => "The Shawshank Redemption",
        "description" => "Two imprisoned men bond over a number of years...",
        "price" => 4.99,
        "rating" => "R",
        "release_date" => "1994-09-23",
        "image" => "shawshank.jpg",
        "duration" => "142 min",
        "language" => "English"
    ],
    [
        "name" => "The Godfather",
        "description" => "The aging patriarch of an organized crime dynasty...",
        "price" => 5.99,
        "rating" => "R",
        "release_date" => "1972-03-24",
        "image" => "godfather.jpg",
        "duration" => "175 min",
        "language" => "English"
    ],
    [
        "name" => "Inception",
        "description" => "A thief who steals corporate secrets through dream-sharing...",
        "price" => 4.99,
        "rating" => "PG-13",
        "release_date" => "2010-07-16",
        "image" => "inception.jpg",
        "duration" => "148 min",
        "language" => "English"
    ],
    [
        "name" => "Jurassic World: Rebirth",
        "description" => "Dinosaurs roam once more in a fully functional theme park...",
        "price" => 6.99,
        "rating" => "PG-13",
        "release_date" => "2025-07-01",
        "image" => "jurassic_world.jpg",
        "duration" => "124 min",
        "language" => "English"
    ],
    [
        "name" => "M3GAN 2.0",
        "description" => "A lifelike doll becomes self-aware and vengeful.",
        "price" => 4.99,
        "rating" => "R",
        "release_date" => "2025-06-25",
        "image" => "m3gan2.jpg",
        "duration" => "110 min",
        "language" => "English"
    ],
    [
        "name" => "The Dark Knight",
        "description" => "Batman faces the Joker, a criminal mastermind wreaking havoc...",
        "price" => 5.99,
        "rating" => "PG-13",
        "release_date" => "2008-07-18",
        "image" => "dark_knight.jpg",
        "duration" => "152 min",
        "language" => "English"
    ],
    [
        "name" => "The Lord of the Rings: The Fellowship of the Ring",
        "description" => "A meek Hobbit sets out to destroy a powerful ring.",
        "price" => 5.99,
        "rating" => "PG-13",
        "release_date" => "2001-12-19",
        "image" => "lotr_fellowship.jpg",
        "duration" => "178 min",
        "language" => "English"
    ],
    [
        "name" => "Inside Out 2",
        "description" => "The emotional journey of Riley continues as she navigates teenage years.",
        "price" => 4.99,
        "rating" => "PG",
        "release_date" => "2024-06-14",
        "image" => "inside_out2.jpg",
        "duration" => "95 min",
        "language" => "English"
    ],
    [
        "name" => "F1: The Movie",
        "description" => "A sports drama following an F1 driver's rise to the top.",
        "price" => 6.99,
        "rating" => "PG-13",
        "release_date" => "2025-06-27",
        "image" => "f1_movie.jpg",
        "duration" => "130 min",
        "language" => "English"
    ],
    [
        "name" => "Captain America: Brave New World",
        "description" => "Sam Wilson takes up the mantle of Captain America.",
        "price" => 5.99,
        "rating" => "PG-13",
        "release_date" => "2025-02-16",
        "image" => "cap_brave.jpg",
        "duration" => "135 min",
        "language" => "English"
    ],

    // ————— Arabic Movies (5) —————
    [
        "name" => "Capernaum",
        "description" => "A Lebanese boy sues his parents over his life of hardship.",
        "price" => 4.99,
        "rating" => "PG-13",
        "release_date" => "2018-05-11",
        "image" => "capernaum.jpg",
        "duration" => "122 min",
        "language" => "Arabic"
    ],
    [
        "name" => "The Blue Caftan",
        "description" => "Moroccan drama about a caftan shop couple and their apprentice.",
        "price" => 4.99,
        "rating" => "PG-13",
        "release_date" => "2022-05-20",
        "image" => "blue_caftan.jpg",
        "duration" => "123 min",
        "language" => "Arabic"
    ],
    [
        "name" => "Night Courier",
        "description" => "Saudi black-comedy thriller about a man selling alcohol at night.",
        "price" => 4.99,
        "rating" => "R",
        "release_date" => "2023-09-08",
        "image" => "night_courier.jpg",
        "duration" => "110 min",
        "language" => "Arabic"
    ],
    [
        "name" => "Norah",
        "description" => "Saudi drama shot entirely in AlUla, premiered Cannes 2024.",
        "price" => 4.99,
        "rating" => "PG",
        "release_date" => "2023-12-01",
        "image" => "norah.jpg",
        "duration" => "94 min",
        "language" => "Arabic"
    ],
    [
        "name" => "Omar",
        "description" => "Palestinian crime drama about a young baker involved in conflict.",
        "price" => 4.99,
        "rating" => "PG-13",
        "release_date" => "2013-05-09",
        "image" => "omar.jpg",
        "duration" => "96 min",
        "language" => "Arabic"
    ],
];

foreach ($movies as $m) {
    $stmt = $conn->prepare("
        INSERT INTO movies
        (name, description, price, rating, release_date, image, duration, language)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "ssdsssss",
        $m["name"],
        $m["description"],
        $m["price"],
        $m["rating"],
        $m["release_date"],
        $m["image"],
        $m["duration"],
        $m["language"]
    );
    if ($stmt->execute()) {
        echo "Inserted movie: {$m['name']}<br>";
    } else {
        echo "Error: {$stmt->error}<br>";
    }
    $stmt->close();
}

$conn->close();
