const id = localStorage.getItem("user_id");
let user = {};

if(!id){
    alert("You are not logged in");
    window.location.href = "../pages/login.html";
}

async function getUser(){
    const response = await axios.get(`http://localhost/cinema/cinema-server/controllers/get_users_api.php?id=${id}`, {
        headers: { "Content-Type": "application/json" }
    });

    user = response.data.user;

        document.getElementById("welcome").innerHTML = `Welcome ${user.first_name}`;

    
    document.getElementById("fname").value = `${user.first_name}`;
    document.getElementById("lname").value = `${user.last_name}`;
    document.getElementById("email").value = `${user.email}`;
    document.getElementById("phn-number").value = `${user.phone_number}`;
}

document.addEventListener("DOMContentLoaded", () => {
    getUser();
});

const form = document.getElementById("edit-user-form");

form.addEventListener("submit", async (e)=>{
    e.preventDefault();

        const data = {
        id: id,
        first_name: form.elements["first_name"].value,
        last_name: form.elements["last_name"].value,
        email: form.elements["email"].value,
        phone_number: form.elements["phone_number"].value,
        password: form.elements["password"].value,
        }

        const response = await axios.post(`http://localhost/cinema/cinema-server/controllers/update_user_api.php`, data , {
        headers: { "Content-Type": "application/json" }
    })
    alert(response.data.Message);
    window.location.href = "../pages/user-profile.html";

    if(response?.data?.user){
        alert(response.data.Message);
    }

})
