const name=document.getElementById("name");
const email=document.getElementById("email");
const contact_number=document.getElementById("contact_number");
const password=document.getElementById("password");
const confirm_password=document.getElementById("confirm_password");
const district=document.getElementById("district");
const divisional_secretariat=document.getElementById("divisional_secretariat");
const grama_niladhari=document.getElementById("grama_niladhari");

const registerForm = document.getElementById("registerForm");
const adminname=document.getElementById("adminname");
const adminemail=document.getElementById("adminemail");
const admincontact_number=document.getElementById("admincontact_number");
const adminpassword=document.getElementById("adminpassword");
const adminconfirm_password=document.getElementById("adminconfirm_password");

if (confirm_password.value !== password.value) {
    alert("Passwords do not match!");
    return false;
  }     

if (adminconfirm_password.value !== adminpassword.value) {
    alert("Admin Passwords do not match!");
    return false;
  }
function selectRole(role) {
    if (role === "user") {
        window.location.href = "user-Register.php";
    } else if (role === "admin") {
        window.location.href = "admin-Register.php";
    }
}
