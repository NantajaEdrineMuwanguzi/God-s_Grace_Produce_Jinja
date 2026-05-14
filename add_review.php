<?php
session_start();
include 'config/db.php';

/*
=========================
CHECK LOGIN
=========================
*/

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

/*
=========================
ONLY CUSTOMER
=========================
*/

if($_SESSION['role'] != 'customer'){

    header("Location: login.php");
    exit();
}

$customer_name =
$_SESSION['fullname'];

$message = "";

/*
=========================
SUBMIT REVIEW
=========================
*/

if(isset($_POST['submit_review'])){

    $seller_name =
    mysqli_real_escape_string($conn,
    $_POST['seller_name']);

    $rating =
    mysqli_real_escape_string($conn,
    $_POST['rating']);

    $review =
    mysqli_real_escape_string($conn,
    $_POST['review']);

    // INSERT REVIEW

    mysqli_query($conn,

    "INSERT INTO reviews(

    customer_name,
    seller_name,
    rating,
    review

    ) VALUES(

    '$customer_name',
    '$seller_name',
    '$rating',
    '$review'

    )");

    $message =
    "Review submitted successfully!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Add Review</title>

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

    background:#f5f7fa;

    display:flex;
    justify-content:center;
    align-items:center;

    min-height:100vh;

    padding:20px;
}

.review-box{

    width:100%;
    max-width:600px;

    background:white;

    padding:35px;

    border-radius:20px;

    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

.review-box h1{

    text-align:center;

    color:#0f5132;

    margin-bottom:25px;
}

.success{

    background:#d1e7dd;

    color:#0f5132;

    padding:15px;

    border-radius:10px;

    margin-bottom:20px;

    text-align:center;
}

.input-group{

    margin-bottom:20px;
}

.input-group label{

    display:block;

    margin-bottom:8px;

    color:#0f5132;

    font-weight:600;
}

.input-group input,
.input-group textarea,
.input-group select{

    width:100%;

    padding:14px;

    border:1px solid #ccc;

    border-radius:10px;

    outline:none;
}

textarea{

    resize:none;

    height:120px;
}

.btn{

    width:100%;

    padding:14px;

    border:none;

    background:#0f5132;

    color:white;

    border-radius:10px;

    font-size:16px;

    cursor:pointer;

    transition:0.3s;
}

.btn:hover{

    background:#198754;
}

</style>

</head>
<body>

<div class="review-box">

    <h1>

        <i class="fas fa-star"></i>

        Write Testimonial

    </h1>

    <?php if($message != ""){ ?>

        <div class="success">

            <?php echo $message; ?>

        </div>

    <?php } ?>

    <form method="POST">

        <!-- SELLER -->

        <div class="input-group">

            <label>Seller Name</label>

            <input type="text"

            name="seller_name"

            placeholder="Enter seller name"

            required>

        </div>

        <!-- RATING -->

        <div class="input-group">

            <label>Rating</label>

            <select name="rating" required>

                <option value="">Select Rating</option>

                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>

                <option value="4">⭐⭐⭐⭐ Very Good</option>

                <option value="3">⭐⭐⭐ Good</option>

                <option value="2">⭐⭐ Fair</option>

                <option value="1">⭐ Poor</option>

            </select>

        </div>

        <!-- REVIEW -->

        <div class="input-group">

            <label>Your Testimonial</label>

            <textarea
            name="review"
            placeholder="Write your experience here..."
            required></textarea>

        </div>

        <button type="submit"

        name="submit_review"

        class="btn">

            Submit Review

        </button>

    </form>

</div>

</body>
</html>