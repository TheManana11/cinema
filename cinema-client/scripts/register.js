const form = document.getElementById("form-submit");


form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const data = {
        first_name: form.elements["first_name"].value,
        last_name: form.elements["last_name"].value,
        email: form.elements["email"].value,
        phone_number: form.elements["phone_number"].value,
        password: form.elements["password"].value,
    };

    const response = await axios.post("http://localhost/cinema/cinema-server/register", data, { headers: "Content-Type: application/json" });

    console.log(response);
    
    if(response){
        const id = response.data.data["id"];
        localStorage.setItem("user_id", id);
        window.location.href = "../index.html";
        alert(response?.data?.message);
        return;
    }else{
        console.log(response);
        alert(response?.data?.message);
    }
})