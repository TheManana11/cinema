document.addEventListener("DOMContentLoaded", async () => {
    const url_Params = new URLSearchParams(window.location.search);
    const movie_id = url_Params.get("id");

    if(!movie_id){
        document.getElementById("movie-details").innerHTML = "No Movie found";
        window.location.href = "../index.html";
    }

    try {
        const response = await axios.get(`http://localhost/cinema/cinema-server/controllers/get_movies_api.php?id=${movie_id}`);
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
})