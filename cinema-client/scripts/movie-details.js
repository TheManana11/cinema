const id = localStorage.getItem("user_id");

if(!id){
  alert("You are not logged in");
  window.location.href = "../pages/login.html";
  exit();
}

document.addEventListener("DOMContentLoaded", async () => {
  const user_response = await axios.get(`http://localhost/cinema/cinema-server/users?id=${id}`)

  if(user_response.data.data.user_type === "user"){
    document.getElementById("admin-shows").classList.add("display");
  }

  const url_Params = new URLSearchParams(window.location.search);
  const movie_id = url_Params.get("id");

  if (!movie_id) {
    document.getElementById("movie-details").innerHTML = "No Movie found";
    window.location.href = "../index.html";
  }

  try {
    const response = await axios.get(
      `http://localhost/cinema/cinema-server/movies?id=${movie_id}`
    );
    const movie = response.data.movie;

    const detailsDiv = document.getElementById("movie-details");
    detailsDiv.innerHTML = `
      <img class="movie-details-poster" src="${movie.image}" alt="${movie.name}">
      <div class="movie-details-content"> 
        <h1>${movie.name}</h1>
        <p><strong>Description:</strong> ${movie.description}</p>
        <p><strong>Genre:</strong> ${movie.genre}</p>
        <p><strong>Release Date:</strong> ${movie.release_date}</p>
        <p><strong>Duration:</strong> ${movie.duration}</p>
        <p><strong>Language:</strong> ${movie.language}</p>
        <p><strong>Rating:</strong> ${movie.rating}</p>
        <p><strong>Price:</strong> $${movie.price}</p>
      </div>
    `;
  } catch (error) {
    console.log(error);
  }

  const form = document.getElementById("shows-form");
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const show_data = {
      movie_id: movie_id,
      start_time: form.elements["start_time"].value,
      hall: form.elements["hall"].value,
    };


    let seats_response = {};
    let show_response = {};

    try {
      show_response = await axios.post(
        "http://localhost/cinema/cinema-server/add_show",
        show_data,
        {
          headers: { "Content-Type": "application/json" },
        }
      );      

      const show_id = show_response.data.show.id;
      seats_response = await axios.post(
        "http://localhost/cinema/cinema-server/add_seats",
        show_id,
        {
          headers: { "Content-Type": "application/json" },
        }
      );

      alert(show_response.data.Message , seats_response.data.Message);
    } catch (error) {
      console.log(error);
      alert(show_response.data.Message , seats_response.data.Message);
    }
  });

  try {
    const get_shows_response = await axios.get(`http://localhost/cinema/cinema-server/movie_shows?movie_id=${movie_id}`);

    console.log(get_shows_response);
    const shows = get_shows_response.data.shows;

    const btns = document.getElementById("shows-btns");

    shows.map(show => {
      btns.innerHTML += `<a href="./seats.html?show_id=${show.id}&movie_id=${movie_id}"><button>${show.start_time} | Hall number: ${show.hall}</button></a>`
    })
  } catch (error) {
    console.log(error);
  }
});