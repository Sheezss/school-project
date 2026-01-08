<?php
include "../config/db.php";

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $type = $_POST['user_type'];
    $date = date("Y-m-d");

    $sql = "INSERT INTO users 
            (full_name, email, password, user_type, date_registered)
            VALUES ('$name', '$email', '$password', '$type', '$date')";

    if (mysqli_query($conn, $sql)) {
        echo "Registration successful";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <select name="user_type">
        <option>Individual</option>
        <option>Family</option>
        <option>Nutritionist</option>
        <option>Organization</option>
    </select>
    <button name="register">Register</button>
</form>
