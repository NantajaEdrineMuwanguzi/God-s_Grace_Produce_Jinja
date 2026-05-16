<?php
session_start();
include 'config/db.php';

/*
==================================
ONLY SELLERS CAN ACCESS
==================================
*/

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != "seller"){

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

<title>Customer Orders</title>

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

    background:
    linear-gradient(rgba(0,0,0,0.6),
    rgba(0,0,0,0.6)),

    url('https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop');

    background-size:cover;
    background-position:center;
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

.title{

    background:rgba(255,255,255,0.95);

    padding:20px;

    border-radius:15px;

    margin-bottom:25px;
}

.title h1{

    color:#0f5132;
}

/* TABLE */

.table-container{

    background:rgba(255,255,255,0.96);

    border-radius:20px;

    overflow:hidden;
}

table{

    width:100%;

    border-collapse:collapse;
}

table th{

    background:#0f5132;

    color:white;

    padding:15px;
}

table td{

    padding:15px;

    border-bottom:1px solid #ddd;
}

.status{

    padding:6px 14px;

    border-radius:20px;

    color:white;

    font-size:14px;
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

.empty{

    text-align:center;

    padding:40px;

    color:#555;
}

</style>

</head>
<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <h2>

        <i class="fas fa-store"></i>

        Seller Panel

    </h2>

    <a href="seller_dashboard.php">

        Dashboard

    </a>

    <a href="add_product.php">

        Add Product

    </a>

    <a href="manage_products.php">

        Manage Products

    </a>

    <a href="seller_orders.php">

        Orders

    </a>

    <a href="logout.php">

        Logout

    </a>

</div>

<!-- MAIN -->

<div class="main">

    <div class="title">

        <h1>

            <i class="fas fa-shopping-bag"></i>

            Customer Orders

        </h1>

    </div>

    <div class="table-container">

<?php

$query = mysqli_query($conn,

"SELECT * FROM orders
ORDER BY id DESC");

if(mysqli_num_rows($query) > 0){

?>

<table>

<tr>

    <th>ID</th>

    <th>Customer</th>

    <th>Product</th>

    <th>Price</th>

    <th>Quantity</th>

    <th>Total</th>

    <th>Status</th>

    <th>Date</th>

</tr>

<?php

while($row = mysqli_fetch_assoc($query)){

$status = strtolower($row['status']);

?>

<tr>

    <td>
        <?php echo $row['id']; ?>
    </td>

    <td>
        <?php echo $row['customer_name']; ?>
    </td>

    <td>
        <?php echo $row['product_name']; ?>
    </td>

    <td>
        UGX <?php echo number_format($row['price']); ?>
    </td>

    <td>
        <?php echo $row['quantity']; ?>
    </td>

    <td>
        UGX <?php echo number_format($row['total']); ?>
    </td>

    <td>

        <span class="status <?php
        echo $status;
        ?>">

            <?php echo $row['status']; ?>

        </span>

    </td>

    <td>
        <?php echo $row['created_at']; ?>
    </td>

</tr>

<?php } ?>

</table>

<?php

}else{

    echo "
    <div class='empty'>

        No customer orders found.

    </div>";
}

?>

    </div>

</div>

</body>
</html>
