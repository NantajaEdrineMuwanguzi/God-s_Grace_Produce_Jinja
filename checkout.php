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

/*
=====================================
CHECK IF CART EXISTS
=====================================
*/

if(!isset($_SESSION['cart']) ||
count($_SESSION['cart']) == 0){

    header("Location: cart.php");
    exit();
}

// USER DATA
$customer_name =
$_SESSION['fullname'];

$message = "";

/*
=====================================
PLACE ORDER
=====================================
*/

if(isset($_POST['place_order'])){

    $total_amount = 0;

    foreach($_SESSION['cart'] as $item){

        $product_id =
        $item['id'];

        $quantity =
        $item['quantity'];

        // GET PRODUCT
        $query = mysqli_query($conn,

        "SELECT * FROM products
        WHERE id='$product_id'");

        $product =
        mysqli_fetch_assoc($query);

        if($product){

            $product_name =
            $product['name'];

            $price =
            $product['price'];

            $seller_name =
            $product['seller_name'];

            $total =
            $price * $quantity;

            $total_amount += $total;

            /*
            ============================
            INSERT ORDER
            ============================
            */

            mysqli_query($conn,

            "INSERT INTO orders(

            customer_name,
            seller_name,
            product_name,
            price,
            quantity,
            total,
            status

            ) VALUES(

            '$customer_name',
            '$seller_name',
            '$product_name',
            '$price',
            '$quantity',
            '$total',
            'Pending'

            )");
        }
    }

    /*
    ============================
    CLEAR CART
    ============================
    */

    unset($_SESSION['cart']);

    $message =
    "Order placed successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Checkout</title>

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
    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    padding:30px;
}

/* CHECKOUT BOX */

.checkout-box{

    width:100%;
    max-width:850px;

    background:rgba(255,255,255,0.97);

    padding:35px;

    border-radius:20px;

    box-shadow:0 5px 20px rgba(0,0,0,0.2);
}

/* TITLE */

.checkout-box h1{

    color:#0f5132;

    margin-bottom:25px;

    text-align:center;
}

/* TABLE */

table{

    width:100%;

    border-collapse:collapse;

    margin-bottom:25px;
}

table th{

    background:#0f5132;

    color:white;

    padding:14px;
}

table td{

    padding:14px;

    border-bottom:1px solid #ddd;

    text-align:center;
}

/* PRODUCT IMAGE */

.product-img{

    width:70px;

    height:70px;

    object-fit:cover;

    border-radius:10px;
}

/* TOTAL */

.total{

    text-align:right;

    font-size:24px;

    color:#ff9800;

    font-weight:700;

    margin-bottom:25px;
}

/* BUTTON */

.btn{

    width:100%;

    padding:15px;

    border:none;

    background:#0f5132;

    color:white;

    font-size:17px;

    border-radius:12px;

    cursor:pointer;

    transition:0.3s;
}

.btn:hover{

    background:#198754;
}

/* SUCCESS */

.success{

    text-align:center;
}

.success i{

    font-size:80px;

    color:#198754;

    margin-bottom:20px;
}

.success h2{

    color:#0f5132;

    margin-bottom:15px;
}

.success a{

    display:inline-block;

    margin-top:20px;

    padding:12px 30px;

    background:#0f5132;

    color:white;

    text-decoration:none;

    border-radius:30px;
}

.success a:hover{

    background:#198754;
}

</style>

</head>
<body>

<div class="checkout-box">

<?php
if($message != ""){
?>

    <!-- SUCCESS -->

    <div class="success">

        <i class="fas fa-check-circle"></i>

        <h2>

            <?php echo $message; ?>

        </h2>

        <p>

            Thank you for shopping
            with God's Grace Produce.

        </p>

        <a href="shop.php">

            Continue Shopping

        </a>

    </div>

<?php
}else{
?>

    <h1>

        <i class="fas fa-credit-card"></i>

        Checkout

    </h1>

    <table>

        <tr>

            <th>Image</th>

            <th>Product</th>

            <th>Seller</th>

            <th>Price</th>

            <th>Quantity</th>

            <th>Total</th>

        </tr>

<?php

$grand_total = 0;

foreach($_SESSION['cart'] as $item){

    $product_id =
    $item['id'];

    $quantity =
    $item['quantity'];

    $query = mysqli_query($conn,

    "SELECT * FROM products
    WHERE id='$product_id'");

    $product =
    mysqli_fetch_assoc($query);

    if($product){

        $total =
        $product['price'] * $quantity;

        $grand_total += $total;
?>

<tr>

    <td>

        <img class="product-img"

        src="uploads/<?php
        echo $product['image'];
        ?>">

    </td>

    <td>

        <?php
        echo $product['name'];
        ?>

    </td>

    <td>

        <?php
        echo $product['seller_name'];
        ?>

    </td>

    <td>

        UGX

        <?php
        echo number_format(
        $product['price']);
        ?>

    </td>

    <td>

        <?php echo $quantity; ?>

    </td>

    <td>

        UGX

        <?php
        echo number_format($total);
        ?>

    </td>

</tr>

<?php
    }
}
?>

    </table>

    <div class="total">

        Grand Total:
        UGX
        <?php
        echo number_format($grand_total);
        ?>

    </div>

    <form method="POST">

        <button type="submit"

        name="place_order"

        class="btn">

            <i class="fas fa-check"></i>

            Place Order

        </button>

    </form>

<?php } ?>

</div>

</body>
</html>