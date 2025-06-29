const id = localStorage.getItem("user_id");

async function getUser() {
  if (id) {
    const response = await axios.get(
      `http://localhost/cinema/cinema-server/controllers/get_users_api.php?id=${id}`
    );

    const user = response.data.user;
    if (!user || user.user_type !== "admin") {
      alert("You are not allowed to access this page");
      window.location.href = "../pages/login.html";
    }
  }else{
    alert("You are not logged in");
      window.location.href = "../pages/login.html";
  }
}

document.addEventListener("DOMContentLoaded", async() => {
  await getUser();
});

const form = document.getElementById("add-movie-form");


// function to convert image url into base64 url
async function convertFileToBase64(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result); // base64 string with prefix
        reader.onerror = error => reject(error);
        reader.readAsDataURL(file);
      });
    }


form.addEventListener("submit", async (e) => {

    e.preventDefault();
      const fileInput = form.elements["image"];
      const file = fileInput.files[0]; 
    
      if (!file) {
        alert("Please select an image.");
        return;
      }
    
      const base64Image = await convertFileToBase64(file);
    
      const data = {
        name: form.elements["name"].value,
        description: form.elements["description"].value,
        price: form.elements["price"].value,
        rating: form.elements["rating"].value,
        release_date: form.elements["release_date"].value,
        image: base64Image,
        duration: form.elements["duration"].value,
        language: form.elements["language"].value,
      };
    
      try {
        const response = await axios.post(
          "http://localhost/cinema/cinema-server/controllers/add_movie_api.php",
          data,
          { headers: { "Content-Type": "application/json" } }
        );
        console.log(response.data);
        alert("Movie added successfully!");
        form.reset();
      } catch (error) {
        console.error("Error adding movie:", error);
        alert("Failed to add movie.");
      }
})

