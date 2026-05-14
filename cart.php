<?php
session_start();

/*
=========================================
UPDATE QUANTITY
=========================================
*/

if(isset($_GET['action']) && isset($_GET['index'])){

    $index = $_GET['index'];

    if(isset($_SESSION['cart'][$index])){

        // INCREASE
        if($_GET['action'] == "increase"){

            $_SESSION['cart'][$index]['quantity']++;
        }

        // DECREASE
        if($_GET['action'] == "decrease"){

            if($_SESSION['cart'][$index]['quantity'] > 1){

                $_SESSION['cart'][$index]['quantity']--;
            }
        }

        // DELETE
        if($_GET['action'] == "delete"){

            unset($_SESSION['cart'][$index]);

            $_SESSION['cart'] =
            array_values($_SESSION['cart']);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Shopping Cart</title>

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
    background:#f1f1f1;
}

/* HEADER */

header{

    background:white;

    padding:15px 5%;

    border-bottom:1px solid #ddd;

    display:flex;

    justify-content:space-between;

    align-items:center;
}

/* LOGO */

.logo{

    display:flex;

    align-items:center;

    gap:12px;
}

.logo img{

    width:55px;

    height:55px;

    border-radius:50%;

    object-fit:cover;
}

.logo h2{

    color:#0f5132;

    font-size:24px;
}

/* NAV */

.nav-links{

    display:flex;

    align-items:center;

    gap:25px;
}

.nav-links a{

    text-decoration:none;

    color:#333;

    font-weight:500;
}

.nav-links a:hover{

    color:#0f5132;
}

/* MAIN */

.container{

    width:90%;

    margin:30px auto;
}

/* TOP PATH */

.path{

    margin-bottom:20px;

    color:#666;

    font-size:14px;
}

/* CART BOX */

.cart-box{

    background:white;

    border-radius:10px;

    padding:25px;

    border:1px solid #ddd;
}

/* ITEM */

.cart-item{

    display:grid;

    grid-template-columns:
    180px 1fr 220px;

    gap:25px;

    padding:25px 0;

    border-bottom:1px solid #eee;

    align-items:center;
}

/* PRODUCT IMAGE */

.product-image{

    width:180px;

    height:150px;

    background:#f5f5f5;

    border-radius:10px;

    overflow:hidden;

    display:flex;

    align-items:center;

    justify-content:center;
}

.product-image img{

    width:100%;

    height:100%;

    object-fit:cover;
}

/* DETAILS */

.product-details h2{

    color:#222;

    margin-bottom:10px;
}

.price{

    color:#0f5132;

    font-size:22px;

    font-weight:700;

    margin-bottom:15px;
}

.description{

    color:#777;

    line-height:1.6;
}

/* ACTIONS */

.product-actions{

    display:flex;

    flex-direction:column;

    gap:15px;
}

/* QUANTITY */

.quantity-box{

    display:flex;

    align-items:center;

    gap:10px;
}

.qty-btn{

    width:35px;

    height:35px;

    border:none;

    background:#ddd;

    cursor:pointer;

    font-size:18px;

    border-radius:5px;
}

.qty-btn:hover{

    background:#0f5132;

    color:white;
}

.qty{

    width:40px;

    text-align:center;

    font-size:18px;

    font-weight:600;
}

/* BUTTONS */

.add-btn{

    background:#666;

    color:white;

    text-decoration:none;

    padding:12px;

    border-radius:5px;

    text-align:center;

    font-weight:600;
}

.add-btn:hover{

    background:#0f5132;
}

.delete-btn{

    background:red;

    color:white;

    text-decoration:none;

    padding:10px;

    border-radius:5px;

    text-align:center;
}

.delete-btn:hover{

    background:darkred;
}

/* TOTAL */

.total-box{

    margin-top:30px;

    background:#fafafa;

    padding:20px;

    border-radius:10px;

    text-align:right;

    border:1px solid #ddd;
}

.total-box h2{

    color:#0f5132;

    margin-bottom:20px;
}

/* BUTTON GROUP */

.btn-group{

    display:flex;

    justify-content:flex-end;

    gap:15px;
}

.btn{

    padding:12px 25px;

    border-radius:5px;

    text-decoration:none;

    font-weight:600;

    color:white;
}

.continue{

    background:#198754;
}

.checkout{

    background:#0f5132;
}

.continue:hover{

    background:#146c43;
}

.checkout:hover{

    background:#198754;
}

/* EMPTY */

.empty{

    background:white;

    padding:70px;

    border-radius:10px;

    text-align:center;

    border:1px solid #ddd;
}

.empty i{

    font-size:70px;

    color:#ccc;

    margin-bottom:20px;
}

.empty h2{

    color:#0f5132;

    margin-bottom:10px;
}

/* RESPONSIVE */

@media(max-width:900px){

    .cart-item{

        grid-template-columns:1fr;

        text-align:center;
    }

    .product-image{

        margin:auto;
    }

    .quantity-box{

        justify-content:center;
    }

    .btn-group{

        flex-direction:column;
    }

    .nav-links{

        gap:10px;

        flex-wrap:wrap;
    }
}

</style>

</head>
<body>

<!-- HEADER -->

<header>

    <!-- LOGO -->

    <div class="logo">

        <img src="uploads/logo.png"
        alt="Logo">

        <h2>
            God's Grace Produce
        </h2>

    </div>

    <!-- NAV -->

    <div class="nav-links">

        <a href="index.php">

            <i class="fas fa-home"></i>

            Home

        </a>

        <a href="checkout.php">

            <i class="fas fa-credit-card"></i>

            Checkout

        </a>

        <a href="shop.php">

            <i class="fas fa-store"></i>

            Shop

        </a>

    </div>

</header>

<!-- CONTAINER -->

<div class="container">

    <!-- PATH -->

    <div class="path">

        Cart > Checkout

    </div>

<?php

$total = 0;

if(isset($_SESSION['cart']) &&
count($_SESSION['cart']) > 0){

foreach($_SESSION['cart'] as $index => $item){

    // FIX OLD CART ITEMS

    if(!isset($item['quantity'])){

        $_SESSION['cart'][$index]['quantity'] = 1;
    }

    $quantity =
    $_SESSION['cart'][$index]['quantity'];

    $subtotal =
    $item['price'] * $quantity;

    $total += $subtotal;
?>

<!-- CART BOX -->

<div class="cart-box">

    <!-- ITEM -->

    <div class="cart-item">

        <!-- IMAGE -->

        <div class="product-image">

            <img src="uploads/<?php echo $item['image']; ?>">

        </div>

        <!-- DETAILS -->

        <div class="product-details">

            <h2>

                <?php echo $item['name']; ?>

            </h2>

            <div class="price">

                UGX
                <?php
                echo number_format(
                $item['price']);
                ?>

            </div>

            <p class="description">

                Fresh and high quality produce
                directly from trusted farmers
                in Uganda.

            </p>

            <br>

            <strong>

                Subtotal:
                UGX
                <?php
                echo number_format(
                $subtotal);
                ?>

            </strong>

        </div>

        <!-- ACTIONS -->

        <div class="product-actions">

            <!-- QUANTITY -->

            <div class="quantity-box">

                <a href="cart.php?action=decrease&index=<?php echo $index; ?>">

                    <button class="qty-btn">
                        -
                    </button>

                </a>

                <div class="qty">

                    <?php echo $quantity; ?>

                </div>

                <a href="cart.php?action=increase&index=<?php echo $index; ?>">

                    <button class="qty-btn">
                        +
                    </button>

                </a>

            </div>

            <!-- ADD MORE -->

            <a class="add-btn"

            href="shop.php">

                <i class="fas fa-cart-plus"></i>

                Add More Items

            </a>

            <!-- REMOVE -->

            <a class="delete-btn"

            href="cart.php?action=delete&index=<?php echo $index; ?>">

                <i class="fas fa-trash"></i>

                Remove Item

            </a>

        </div>

    </div>

</div>

<?php } ?>

<!-- TOTAL -->

<div class="total-box">

    <h2>

        Cart Total:
        UGX
        <?php echo number_format($total); ?>

    </h2>

    <!-- BUTTONS -->

    <div class="btn-group">

        <a href="shop.php"
        class="btn continue">

            Continue Shopping

        </a>

        <a href="checkout.php"
        class="btn checkout">

            Proceed To Checkout

        </a>

    </div>

</div>

<?php } else { ?>

<!-- EMPTY -->

<div class="empty">

    <i class="fas fa-shopping-cart"></i>

    <h2>
        Your Cart Is Empty
    </h2>

    <p>

        Start shopping fresh produce
        from trusted farmers.

    </p>

    <br><br>

    <a href="shop.php"
    class="btn continue">

        Go Shopping

    </a>

</div>

<?php } ?>

</div>

</body>
</html>