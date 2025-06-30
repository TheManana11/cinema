const id = localStorage.getItem("user_id");

if (!id) {
  alert("You are not logged in");
  window.location.href = "../pages/login.html";
  exit();
}

document.addEventListener("DOMContentLoaded", async () => {
  const url_Params = new URLSearchParams(window.location.search);
  const show_id = url_Params.get("show_id");


  let show = {};
  try {
    const response = await axios.get(
      `http://localhost/cinema/cinema-server/controllers/get_shows_api.php?id=${show_id}`
    );
    console.log(response)
    show = response.data.Show;
    console.log(response.data.Show);
  } catch (error) {
    console.log(error);
  }

  const h1 = document.getElementById("h1");
  h1.innerHTML = `Welcome to show with id: ${show.id}, movie_id: ${show.movie_id}, start time: ${show.start_time}, hall number: ${show.hall}`
});
