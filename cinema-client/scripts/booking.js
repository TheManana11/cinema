const id = localStorage.getItem("user_id");

if (!id) {
  alert("You are not logged in");
  window.location.href = "../pages/login.html";
  exit();
}

document.addEventListener("DOMContentLoaded", async () => {

    const response = await axios.get(`http://localhost/cinema/cinema-server/controllers/get_bookings_api.php?user_id=${id}`);

    const bookings = response.data.bookings;

    let booking_div = document.getElementById("bookings");

    bookings.map(booking => {
        booking_div.innerHTML += `
        <div class="booking" id="booking">
            <h1>Booking Details:</h1>
            <p><strong>First Name: </strong> ${booking.first_name}</p>
            <p><strong>Last Name: </strong> ${booking.last_name}</p>
            <p><strong>Movie Name: </strong> ${booking.movie_name}</p>
            <p><strong>Show date and time: </strong> ${booking.start_time}</p>
            <p><strong>Show Hall: </strong> ${booking.hall}</p>
            <p><strong>Seat details: </strong> ${booking.row}-${booking.seat_number}</p>
            </div>
        `
    });
});