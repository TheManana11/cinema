<?php

$apis = [
// user controller
'/register'  => ['controller' => 'UserController', 'method' => 'register'],
'/login'  => ['controller' => 'UserController', 'method' => 'login'],
'/users'  => ['controller' => 'UserController', 'method' => 'getUsers'],
'/update_user'  => ['controller' => 'UserController', 'method' => 'updateUser'],
'/delete_user'  => ['controller' => 'UserController', 'method' => 'deleteUser'],

// movie controller
'/movies'  => ['controller' => 'MovieController', 'method' => 'getMovies'],
'/add_movie'  => ['controller' => 'MovieController', 'method' => 'addMovie'],
'/update_movie'  => ['controller' => 'MovieController', 'method' => 'updateMovie'],
'/delete_movie'  => ['controller' => 'MovieController', 'method' => 'deleteMovie'],

// show controller
'/shows'  => ['controller' => 'ShowController', 'method' => 'getShows'],
'/movie_shows'  => ['controller' => 'ShowController', 'method' => 'getMovieShows'],
'/add_show'  => ['controller' => 'ShowController', 'method' => 'addShow'],
'/update_show'  => ['controller' => 'ShowController', 'method' => 'updateShow'],
'/delete_show'  => ['controller' => 'ShowController', 'method' => 'deleteShow'],


// seats controller
'/seats'  => ['controller' => 'SeatController', 'method' => 'getSeats'],
// '/movie_shows'  => ['controller' => 'SeatController', 'method' => 'getMovieShows'],
'/add_seats'  => ['controller' => 'SeatController', 'method' => 'addAllSeats'],
'/update_seat'  => ['controller' => 'SeatController', 'method' => 'updateSeat'],
'/delete_seat'  => ['controller' => 'SeatController', 'method' => 'deleteSeat'],


// Booking controller
'/bookings'  => ['controller' => 'BookingController', 'method' => 'getBookings'],
'/add_booking'  => ['controller' => 'BookingController', 'method' => 'addBooking'],

];
