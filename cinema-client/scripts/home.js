document.addEventListener("DOMContentLoaded", () => {
  const id = localStorage.getItem("user_id");
  let user = {};
  async function getUser() {
    const response = await axios.get(
      `http://localhost/cinema/cinema-server/controllers/get_users_api.php?id=${id}`,
      {
        headers: {
          "Content-Type": "application/json",
        },
      }
    );
    user = response.data.user;

    if (user.user_type == "admin") {
      document.getElementById("login-reg").classList.add("display");
      document.getElementById("user-profile").classList.add("display");
      document.getElementById("admin-dashboard").classList.remove("display");
    } else if (user.user_type == "user") {
      document.getElementById("login-reg").classList.add("display");
      document.getElementById("user-profile").classList.remove("display");
      document.getElementById("admin-dashboard").classList.add("display");
    }
  }

  if (id) {
    getUser();
  } else {
    document.getElementById("login-reg").classList.remove("display");
    document.getElementById("user-profile").classList.add("display");
    document.getElementById("admin-dashboard").classList.add("display");
  }
});


async function get_movies(){
  try {
    const response = await axios.get("http://localhost/cinema/cinema-server/controllers/get_movies_api.php");
    const movies = response.data.movies;

    const moviesDiv = document.querySelector(".movies-container");
    moviesDiv.innerHTML = "";
    
    movies.map(movie => {
      const movieDiv = document.createElement("div");
      movieDiv.classList.add("movie-item");

      movieDiv.innerHTML = `
         <a href="../pages/movie-details.html?id=${movie.id}">
        <img src="${movie.image}" alt="${movie.name}" class="movie-item-poster" />
        <div class="movie-item-content">
          <h3>${movie.name}</h3>
          <div class="date-rating">
          <p>${movie.release_date}</p>
          <p>⭐${movie.rating}</p>
          </div>
        </div>
        </a>
      `;

      moviesDiv.appendChild(movieDiv);
    });

  } catch (error) {
    console.log(error);
  }
}

document.addEventListener("DOMContentLoaded", async()=>{
  await get_movies();
})
