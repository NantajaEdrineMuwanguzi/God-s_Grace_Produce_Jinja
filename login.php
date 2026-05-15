<?php
session_start();
include 'config/db.php';

$message = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn,
    $_POST['email']);

    $password = $_POST['password'];

    // CHECK USER
    $query = mysqli_query($conn,
    "SELECT * FROM users
    WHERE email='$email'");

    if(mysqli_num_rows($query) > 0){

        $row = mysqli_fetch_assoc($query);

        // VERIFY PASSWORD
        if(password_verify($password,
        $row['password'])){

            // CREATE SESSION
            $_SESSION['user_id'] =
            $row['id'];

            $_SESSION['fullname'] =
            $row['fullname'];

            $_SESSION['role'] =
            $row['role'];

            // REDIRECT BASED ON ROLE
            if($row['role'] == "seller"){

                header("Location: seller_dashboard.php");

            }else{

                header("Location: customer_dashboard.php");
            }

            exit();

        }else{

            $message = "Incorrect password!";
        }

    }else{

        $message = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    linear-gradient(rgba(0,0,0,0.6),
    rgba(0,0,0,0.6)),

    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop');

    background-size:cover;
    background-position:center;
}

.container{

    width:400px;

    background:white;

    padding:40px;

    border-radius:20px;

    box-shadow:0 5px 20px rgba(0,0,0,0.2);
}

.icon{

    text-align:center;

    font-size:50px;

    color:#0f5132;

    margin-bottom:15px;
}

h2{

    text-align:center;

    color:#0f5132;

    margin-bottom:20px;
}

.message{

    background:#f8d7da;

    color:#842029;

    padding:12px;

    border-radius:10px;

    margin-bottom:15px;

    text-align:center;
}

.input-box{

    margin-bottom:15px;
}

.input-box input{

    width:100%;

    padding:12px;

    border:1px solid #ccc;

    border-radius:10px;

    outline:none;
}

.btn{

    width:100%;

    padding:12px;

    background:#0f5132;

    color:white;

    border:none;

    border-radius:10px;

    cursor:pointer;

    transition:0.3s;
}

.btn:hover{

    background:#198754;
}

.register-link{

    text-align:center;

    margin-top:15px;
}

.register-link a{

    color:#0f5132;

    text-decoration:none;

    font-weight:600;
}

</style>

</head>
<body>

<div class="container">

    <div class="icon">

        <i class="fas fa-user-lock"></i>

    </div>

    <h2>Login Account</h2>

    <?php
    if($message != ""){
        echo "<div class='message'>
        $message
        </div>";
    }
    ?>

    <form method="POST">

        <div class="input-box">

            <input type="email"
            name="email"

            placeholder="Enter Email"

            required>

        </div>

        <div class="input-box">

            <input type="password"

            name="password"

            placeholder="Enter Password"

            required>

        </div>

        <button type="submit"

        name="login"

        class="btn">

            Login

        </button>

    </form>

    <div class="register-link">

        Don't have an account?

        <a href="register.php">

            Register

        </a>

    </div>

</div>

</body>
</html>