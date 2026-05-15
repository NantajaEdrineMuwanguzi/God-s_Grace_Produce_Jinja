<?php
session_start();
include 'config/db.php';

// CHECK IF USER IS LOGGED IN
if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

// USER DATA
$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'];
$role = $_SESSION['role'];

// ONLY CUSTOMERS
if($role != "customer"){

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>My Orders</title>

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
    background-attachment:fixed;

    min-height:100vh;
}

/* HEADER */

header{
    background:#0f5132;
    padding:15px 8%;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo{
    color:white;
    font-size:28px;
    font-weight:700;
}

nav a{
    color:white;
    text-decoration:none;
    margin-left:25px;
    font-weight:500;
    transition:0.3s;
}

nav a:hover{
    color:#ffc107;
}

/* PAGE TITLE */

.page-title{
    text-align:center;
    color:white;
    padding:50px 20px 20px;
}

.page-title h1{
    font-size:42px;
    margin-bottom:10px;
}

/* ORDER CONTAINER */

.orders-container{
    width:90%;
    max-width:1200px;
    margin:30px auto 80px;
}

/* ORDER CARD */

.order-card{
    background:rgba(255,255,255,0.96);
    border-radius:20px;
    padding:25px;
    margin-bottom:25px;
    box-shadow:0 5px 20px rgba(0,0,0,0.15);
}

.order-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.order-id{
    color:#0f5132;
    font-size:22px;
    font-weight:700;
}

.status{
    padding:8px 18px;
    border-radius:30px;
    color:white;
    font-size:14px;
    font-weight:600;
}

.pending{
    background:#ffc107;
}

.completed{
    background:#198754;
}

.cancelled{
    background:#dc3545;
}

/* ORDER DETAILS */

.order-details{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.detail-box{
    background:#f5f5f5;
    padding:15px;
    border-radius:12px;
}

.detail-box h4{
    color:#0f5132;
    margin-bottom:8px;
}

.detail-box p{
    color:#555;
}

/* EMPTY */

.empty{
    text-align:center;
    background:rgba(255,255,255,0.95);
    padding:60px;
    border-radius:20px;
    color:#555;
    font-size:20px;
}

/* BUTTON */

.btn{
    display:inline-block;
    margin-top:20px;
    padding:12px 25px;
    background:#0f5132;
    color:white;
    text-decoration:none;
    border-radius:30px;
    transition:0.3s;
}

.btn:hover{
    background:#198754;
}

/* FOOTER */

footer{
    background:#0f5132;
    color:white;
    text-align:center;
    padding:20px;
}

</style>

</head>
<body>

<!-- HEADER -->

<header>

    <div class="logo">
        God's Grace Produce
    </div>

    <nav>

        <a href="index.php">Home</a>

        <a href="shop.php">Shop</a>

        <a href="customer_dashboard.php">
            Dashboard
        </a>

        <a href="cart.php">
            Cart
        </a>

        <a href="logout.php">
            Logout
        </a>

    </nav>

</header>

<!-- TITLE -->

<section class="page-title">

    <h1>My Orders</h1>

    <p>
        Welcome,
        <?php echo $fullname; ?>
    </p>

</section>

<!-- ORDERS -->

<div class="orders-container">

<?php

/*
======================================
ORDERS TABLE SHOULD HAVE:
id
user_id
product_name
price
quantity
total
status
created_at
======================================
*/

$query = mysqli_query($conn,
"SELECT * FROM orders
WHERE user_id='$user_id'
ORDER BY id DESC");

if(mysqli_num_rows($query) > 0){

    while($row = mysqli_fetch_assoc($query)){

        $status = strtolower($row['status']);
?>

<div class="order-card">

    <div class="order-top">

        <div class="order-id">

            Order #<?php echo $row['id']; ?>

        </div>

        <div class="status <?php echo $status; ?>">

            <?php echo ucfirst($row['status']); ?>

        </div>

    </div>

    <div class="order-details">

        <div class="detail-box">

            <h4>Product</h4>

            <p>
                <?php echo $row['product_name']; ?>
            </p>

        </div>

        <div class="detail-box">

            <h4>Price</h4>

            <p>
                UGX
                <?php echo number_format($row['price']); ?>
            </p>

        </div>

        <div class="detail-box">

            <h4>Quantity</h4>

            <p>
                <?php echo $row['quantity']; ?>
            </p>

        </div>

        <div class="detail-box">

            <h4>Total</h4>

            <p>
                UGX
                <?php echo number_format($row['total']); ?>
            </p>

        </div>

        <div class="detail-box">

            <h4>Order Date</h4>

            <p>
                <?php echo $row['created_at']; ?>
            </p>

        </div>

    </div>

</div>

<?php

    }

} else {

?>

<div class="empty">

    <i class="fas fa-shopping-bag"
    style="font-size:60px;color:#198754;margin-bottom:20px;">
    </i>

    <h2>No Orders Yet</h2>

    <p>
        You have not placed any orders yet.
    </p>

    <a href="shop.php" class="btn">

        <i class="fas fa-store"></i>

        Start Shopping

    </a>

</div>

<?php } ?>

</div>

<!-- FOOTER -->

<footer>

    © <?php echo date("Y"); ?>
    God's Grace Produce - Jinja

</footer>

</body>
</html>
```
