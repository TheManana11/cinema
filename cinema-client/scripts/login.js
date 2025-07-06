const form = document.getElementById("login-form");


form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const data = {
        email: form.elements["email"].value,
        password: form.elements["password"].value
    };
    
    const response = await axios.post("http://localhost/cinema/cinema-server/login", data, {headers: {"Content-Type": "application/json"}});

    if(response){
        const id = response.data.data["id"];
        localStorage.setItem("user_id", id);
        window.location.href = "../index.html";
        alert(response?.data?.message);
        return;
    }else{
        alert(response?.data?.message);
        return;
    }
})