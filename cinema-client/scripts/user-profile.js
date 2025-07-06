const id = localStorage.getItem("user_id");

if(!id){
    alert("You are not logged in");
    window.location.href = "../pages/login.html";
}

async function getUser(){
    const response = await axios.get(`http://localhost/cinema/cinema-server/users?id=${id}`, {
        headers: { "Content-Type": "application/json" }
    });

    const user = response.data.data;
    document.getElementById("welcome").innerHTML = `Welcome ${user.first_name}`;

    document.getElementById("fname").innerHTML = `${user.first_name}`;
    document.getElementById("lname").innerHTML = `${user.last_name}`;
    document.getElementById("email").innerHTML = `${user.email}`;
    document.getElementById("phn-number").innerHTML = `${user.phone_number}`;
}

document.addEventListener("DOMContentLoaded", () => {
    getUser();
});
