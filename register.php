<?php
include 'config/db.php';

$message = "";
$showLogin = false;

if(isset($_POST['register'])){

    // GET FORM DATA
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // CHECK IF EMAIL ALREADY EXISTS
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){

        $message = "Email already exists!";

    }else{

        // INSERT USER
        $insert = mysqli_query($conn,
        "INSERT INTO users(fullname,email,password,role)
        VALUES('$fullname','$email','$password','$role')");

        if($insert){

            $message = "Registration successful!";
            $showLogin = true;

        }else{

            $message = "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Registration</title>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- FONT AWESOME -->
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:
    linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop');

    background-size:cover;
    background-position:center;
}

.container{
    width:420px;
    background:#fff;
    padding:40px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

.icon{
    text-align:center;
    font-size:50px;
    color:#0f5132;
    margin-bottom:10px;
}

h2{
    text-align:center;
    margin-bottom:20px;
    color:#0f5132;
}

.message{
    text-align:center;
    padding:10px;
    margin-bottom:15px;
    border-radius:8px;
    background:#f8d7da;
    color:#842029;
}

.success{
    background:#d1e7dd;
    color:#0f5132;
}

.input-box{
    margin-bottom:15px;
}

.input-box input,
.input-box select{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:10px;
    outline:none;
    font-size:15px;
}

.input-box input:focus,
.input-box select:focus{
    border-color:#198754;
}

.btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#0f5132;
    color:white;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
    margin-top:10px;
}

.btn:hover{
    background:#198754;
}

.login-btn{
    display:block;
    text-align:center;
    text-decoration:none;
    background:#198754;
    color:white;
    padding:12px;
    border-radius:10px;
    margin-top:15px;
    transition:0.3s;
}

.login-btn:hover{
    background:#146c43;
}

</style>

</head>
<body>

<div class="container">

    <div class="icon">
        <i class="fas fa-user-plus"></i>
    </div>

    <h2>Create Account</h2>

    <!-- DISPLAY MESSAGE -->
    <?php
    if($message != ""){

        $class = $showLogin ? "message success" : "message";

        echo "<div class='$class'>$message</div>";
    }
    ?>

    <!-- REGISTRATION FORM -->
    <form method="POST">

        <div class="input-box">
            <input type="text" name="fullname"
            placeholder="Enter Full Name" required>
        </div>

        <div class="input-box">
            <input type="email" name="email"
            placeholder="Enter Email Address" required>
        </div>

        <div class="input-box">
            <select name="role" required>
                <option value="">-- Select Role --</option>
                <option value="customer">Customer</option>
                <option value="seller">Seller (Admin)</option>
            </select>
        </div>

        <div class="input-box">
            <input type="password" name="password"
            placeholder="Enter Password" required>
        </div>

        <button type="submit" name="register" class="btn">
            Register
        </button>

    </form>

    <!-- LOGIN BUTTON AFTER SUCCESS -->
    <?php if($showLogin){ ?>

        <a href="login.php" class="login-btn">
            <i class="fas fa-sign-in-alt"></i> Login Now
        </a>

    <?php } ?>

</div>

</body>
</html>
