const form = document.getElementById("login-form");


form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const data = {
        email: form.elements["email"].value,
        password: form.elements["password"].value
    };
    
    const response = await axios.post("http://localhost/cinema/cinema-server/controllers/login_user_api.php", data, {headers: {"Content-Type": "application/json"}});

    if(response){
        const id = response.data.user["id"];
        localStorage.setItem("user_id", id);
        window.location.href = "../index.html";
        alert(response.data.Message);
        return;
    }else{
        alert(response?.data?.Message);
        return;
    }
})