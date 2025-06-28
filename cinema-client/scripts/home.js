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
