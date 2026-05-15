<?php
session_start();
include 'config/db.php';

/*
=====================================
CHECK LOGIN
=====================================
*/

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

// USER DATA
$user_id = $_SESSION['user_id'];

$message = "";

/*
=====================================
FETCH USER DETAILS
=====================================
*/

$query = mysqli_query($conn,

"SELECT * FROM users
WHERE id='$user_id'");

$user = mysqli_fetch_assoc($query);

/*
=====================================
UPDATE PROFILE
=====================================
*/

if(isset($_POST['update_profile'])){

    $fullname = mysqli_real_escape_string($conn,
    $_POST['fullname']);

    $email = mysqli_real_escape_string($conn,
    $_POST['email']);

    // UPDATE USER
    $update = mysqli_query($conn,

    "UPDATE users SET

    fullname='$fullname',
    email='$email'

    WHERE id='$user_id'");

    if($update){

        $_SESSION['fullname'] = $fullname;

        $message = "Profile updated successfully!";

        // REFRESH USER DATA
        $query = mysqli_query($conn,

        "SELECT * FROM users
        WHERE id='$user_id'");

        $user = mysqli_fetch_assoc($query);

    }else{

        $message = "Failed to update profile!";
    }
}

/*
=====================================
CHANGE PASSWORD
=====================================
*/

if(isset($_POST['change_password'])){

    $current_password =
    $_POST['current_password'];

    $new_password =
    $_POST['new_password'];

    $confirm_password =
    $_POST['confirm_password'];

    // VERIFY CURRENT PASSWORD
    if(password_verify($current_password,
    $user['password'])){

        if($new_password ==
        $confirm_password){

            $hashed_password =
            password_hash($new_password,
            PASSWORD_DEFAULT);

            mysqli_query($conn,

            "UPDATE users SET

            password='$hashed_password'

            WHERE id='$user_id'");

            $message =
            "Password changed successfully!";

        }else{

            $message =
            "New passwords do not match!";
        }

    }else{

        $message =
        "Current password is incorrect!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Profile Settings</title>

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

    background:
    linear-gradient(rgba(0,0,0,0.6),
    rgba(0,0,0,0.6)),

    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop');

    background-size:cover;
    background-position:center;
    min-height:100vh;
}

/* SIDEBAR */

.sidebar{

    width:250px;

    height:100vh;

    background:#0f5132;

    position:fixed;

    left:0;
    top:0;

    padding-top:20px;
}

.sidebar h2{

    color:white;

    text-align:center;

    margin-bottom:30px;
}

.sidebar a{

    display:block;

    color:white;

    text-decoration:none;

    padding:15px 25px;

    transition:0.3s;
}

.sidebar a:hover{

    background:#198754;
}

/* MAIN */

.main{

    margin-left:250px;

    padding:40px;
}

/* CARD */

.card{

    background:rgba(255,255,255,0.95);

    padding:30px;

    border-radius:20px;

    margin-bottom:25px;

    max-width:700px;
}

/* TITLE */

.card h2{

    color:#0f5132;

    margin-bottom:20px;
}

/* MESSAGE */

.message{

    background:#d1e7dd;

    color:#0f5132;

    padding:12px;

    border-radius:10px;

    margin-bottom:20px;
}

/* INPUTS */

.input-box{

    margin-bottom:20px;
}

.input-box label{

    display:block;

    margin-bottom:8px;

    color:#0f5132;

    font-weight:600;
}

.input-box input{

    width:100%;

    padding:12px;

    border:1px solid #ccc;

    border-radius:10px;

    outline:none;
}

/* BUTTON */

.btn{

    padding:12px 25px;

    background:#0f5132;

    color:white;

    border:none;

    border-radius:25px;

    cursor:pointer;

    transition:0.3s;
}

.btn:hover{

    background:#198754;
}

.role{

    background:#198754;

    color:white;

    display:inline-block;

    padding:6px 15px;

    border-radius:20px;

    margin-top:10px;
}

</style>

</head>
<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <h2>

        <i class="fas fa-user"></i>

        My Account

    </h2>

<?php if($_SESSION['role'] == "seller"){ ?>

    <a href="seller_dashboard.php">

        <i class="fas fa-home"></i>

        Dashboard

    </a>

<?php } else { ?>

    <a href="customer_dashboard.php">

        <i class="fas fa-home"></i>

        Dashboard

    </a>

<?php } ?>

    <a href="profile.php">

        <i class="fas fa-user-cog"></i>

        Profile

    </a>

    <a href="logout.php">

        <i class="fas fa-sign-out-alt"></i>

        Logout

    </a>

</div>

<!-- MAIN -->

<div class="main">

<?php
if($message != ""){
    echo "<div class='message'>
    $message
    </div>";
}
?>

    <!-- PROFILE CARD -->

    <div class="card">

        <h2>

            <i class="fas fa-user-circle"></i>

            Profile Information

        </h2>

        <form method="POST">

            <div class="input-box">

                <label>
                    Full Name
                </label>

                <input type="text"

                name="fullname"

                value="<?php
                echo $user['fullname'];
                ?>"

                required>

            </div>

            <div class="input-box">

                <label>
                    Email Address
                </label>

                <input type="email"

                name="email"

                value="<?php
                echo $user['email'];
                ?>"

                required>

            </div>

            <div class="role">

                Role:
                <?php
                echo ucfirst($user['role']);
                ?>

            </div>

            <br><br>

            <button type="submit"

            name="update_profile"

            class="btn">

                Update Profile

            </button>

        </form>

    </div>

    <!-- PASSWORD CARD -->

    <div class="card">

        <h2>

            <i class="fas fa-lock"></i>

            Change Password

        </h2>

        <form method="POST">

            <div class="input-box">

                <label>
                    Current Password
                </label>

                <input type="password"

                name="current_password"

                required>

            </div>

            <div class="input-box">

                <label>
                    New Password
                </label>

                <input type="password"

                name="new_password"

                required>

            </div>

            <div class="input-box">

                <label>
                    Confirm New Password
                </label>

                <input type="password"

                name="confirm_password"

                required>

            </div>

            <button type="submit"

            name="change_password"

            class="btn">

                Change Password

            </button>

        </form>

    </div>

</div>

</body>
</html>
