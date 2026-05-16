<?php
session_start();
include 'config/db.php';

/*
=================================================
THIS SHOP PAGE:
- Displays products uploaded by sellers/admins
- Shows product image
- Shows seller name
- Buyers can see all uploaded items
=================================================
*/

// CHECK LOGIN
$isLoggedIn = false;

if(isset($_SESSION['user_id'])){
    $isLoggedIn = true;
    $fullname = $_SESSION['fullname'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>
        Marketplace Shop | God's Grace Produce
    </title>

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
        }

        /* HEADER */

        header{
            background:#0f5132;
            padding:15px 8%;
            display:flex;
            justify-content:space-between;
            align-items:center;
            position:sticky;
            top:0;
            z-index:1000;
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

        .welcome-user{
            color:#ffc107;
            margin-left:20px;
            font-weight:600;
        }

        /* PAGE TITLE */

        .page-title{
            text-align:center;
            padding:60px 20px 30px;
            color:white;
        }

        .page-title h1{
            font-size:42px;
            margin-bottom:10px;
        }

        .page-title p{
            font-size:18px;
        }

        /* PRODUCTS */

        .products{
            padding:40px 8% 80px;

            display:grid;

            grid-template-columns:
            repeat(auto-fit, minmax(300px,1fr));

            gap:30px;
        }

        .card{
            background:rgba(255,255,255,0.95);
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 5px 20px rgba(0,0,0,0.15);
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-10px);
        }

        .card img{
            width:100%;
            height:240px;
            object-fit:cover;
        }

        .card-content{
            padding:25px;
        }

        .seller{
            color:#198754;
            font-size:14px;
            margin-bottom:10px;
            font-weight:600;
        }

        .product-name{
            font-size:24px;
            color:#0f5132;
            margin-bottom:15px;
        }

        .price{
            color:#ff9800;
            font-size:22px;
            font-weight:700;
            margin-bottom:15px;
        }

        .description{
            color:#666;
            line-height:1.7;
            margin-bottom:20px;
        }

        .btn{
            display:inline-block;
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

        /* EMPTY MESSAGE */

        .empty{
            text-align:center;
            padding:80px;
            color:white;
            font-size:20px;
            grid-column:1/-1;
        }

        /* FOOTER */

        footer{
            background:#0f5132;
            color:white;
            text-align:center;
            padding:20px;
        }

        @media(max-width:768px){

            header{
                flex-direction:column;
            }

            nav{
                margin-top:15px;
            }

            nav a{
                margin:0 10px;
            }
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

        <a href="cart.php">
            <i class="fas fa-shopping-cart"></i>
            Cart
        </a>

        <?php if($isLoggedIn){ ?>

            <a href="customer_dashboard.php">
                <i class="fas fa-user"></i>
                Dashboard
            </a>

            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>

            <span class="welcome-user">
                Hi, <?php echo $fullname; ?>
            </span>

        <?php } else { ?>

            <a href="login.php">Login</a>

            <a href="register.php">Register</a>

        <?php } ?>

    </nav>

</header>

<!-- PAGE TITLE -->

<section class="page-title">

    <h1>Marketplace Products</h1>

    <p>
        Browse fresh products uploaded by
        farmers and sellers across Uganda.
    </p>

</section>

<!-- PRODUCTS -->

<section class="products">

<?php

$query = mysqli_query($conn,
"SELECT * FROM products ORDER BY id DESC");

if(mysqli_num_rows($query) > 0){

    while($row = mysqli_fetch_assoc($query)){

?>

<div class="card">

    <!-- PRODUCT IMAGE -->

    <?php
    if(!empty($row['image'])){
    ?>

    <img src="uploads/<?php echo $row['image']; ?>">

    <?php
    } else {
    ?>

    <img src="https://images.unsplash.com/photo-1518843875459-f738682238a6?q=80&w=1974&auto=format&fit=crop">

    <?php } ?>

    <div class="card-content">

        <!-- SELLER -->

        <div class="seller">

            <i class="fas fa-store"></i>

            Seller:
            <?php echo $row['seller_name']; ?>

        </div>

        <!-- PRODUCT NAME -->

        <h3 class="product-name">

            <?php echo $row['name']; ?>

        </h3>

        <!-- PRICE -->

        <div class="price">

            UGX
            <?php echo number_format($row['price']); ?>

        </div>

        <!-- DESCRIPTION -->

        <p class="description">

            <?php echo $row['description']; ?>

        </p>

        <!-- BUTTON -->

        <a href="add_to_cart.php?id=<?php echo $row['id']; ?>"
        class="btn">

            <i class="fas fa-cart-shopping"></i>

            Add To Cart

        </a>

    </div>

</div>

<?php

    }

} else {

    echo "
    <div class='empty'>

        No products uploaded yet.

    </div>";
}

?>

</section>

<!-- FOOTER -->

<footer>

    <p>

        © <?php echo date("Y"); ?>

        God's Grace Produce - Jinja

    </p>

</footer>

</body>
</html>