const id = localStorage.getItem("user_id");

if (!id) {
  alert("You are not logged in");
  window.location.href = "../pages/login.html";
  exit();
}

document.addEventListener("DOMContentLoaded", async () => {
  const url_Params = new URLSearchParams(window.location.search);
  const show_id = url_Params.get("show_id");
  const movie_id = url_Params.get("movie_id");

  console.log(movie_id, show_id)

  let show = {};
  try {
    const response = await axios.get(
      `http://localhost/cinema/cinema-server/controllers/get_shows_api.php?id=${show_id}`
    );
    console.log(response);
    show = response.data.Show;
    console.log(response.data.Show);
  } catch (error) {
    console.log(error);
  }

  const response = {};
  try {
    const response = await axios.get(
      `http://localhost/cinema/cinema-server/controllers/get_all_seats_api.php?show_id=${show_id}`
    );
    seats = response.data.seats;

    const checkboxes = document.getElementById("checkboxes");
    checkboxes.innerHTML = ``;

    seats.map((seat) => {
      checkboxes.innerHTML += `<input type="checkbox" name="seats" value="${seat.id}" ${seat.is_booked ? "checked" : "" } ${seat.is_booked ? "disabled" : "" }/>`;
    });


    const form = document.getElementById("seats-form");
    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      let seats_array = Array.from(
        document.querySelectorAll("input[name='seats']:checked")
      );
      seats_array = seats_array.map((seat) => seat.value);
      

      try {
        const response = await axios.post("http://localhost/cinema/cinema-server/controllers/update_seats_api.php", seats_array, {
          headers: { "Content-Type": "application/json" }
        });
        console.log(response);

        seats_array.map( async(seat) =>{
          const booking_response = await axios.post("http://localhost/cinema/cinema-server/controllers/add_booking_api.php", {
            user_id: id, movie_id, show_id, seat_id: seat}, {
          headers: { "Content-Type": "application/json" }
        });
        console.log(booking_response);
        }) 
        
        alert(response.data.Message);
        window.location.href = "../pages/booking.html";
      } catch (error) {
        alert(response.data.Message);
      }
    });




  } catch (error) {
    console.log(error);
  }
});
