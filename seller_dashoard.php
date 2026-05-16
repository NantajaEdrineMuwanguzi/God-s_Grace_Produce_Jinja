```php
<?php
session_start();
include 'config/db.php';

/*
=============================
CHECK IF USER IS LOGGED IN
=============================
*/

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

/*
=============================
ONLY SELLERS CAN ACCESS
=============================
*/

if($_SESSION['role'] != 'seller'){

    header("Location: login.php");
    exit();
}

/*
=============================
USER DATA
=============================
*/

$fullname = $_SESSION['fullname'];

/*
=============================
TOTAL PRODUCTS
=============================
*/

$product_query = mysqli_query($conn,

"SELECT * FROM products
WHERE seller_name='$fullname'");

$total_products =
mysqli_num_rows($product_query);

/*
=============================
TOTAL ORDERS
=============================
*/

$order_query = mysqli_query($conn,

"SELECT * FROM orders
WHERE seller_name='$fullname'");

$total_orders =
mysqli_num_rows($order_query);

/*
=============================
TOTAL SALES
=============================
*/

$sales_query = mysqli_query($conn,

"SELECT SUM(total) AS total_sales
FROM orders
WHERE seller_name='$fullname'");

$sales_row =
mysqli_fetch_assoc($sales_query);

$total_sales =
$sales_row['total_sales'];

if($total_sales == ""){
    $total_sales = 0;
}

/*
=============================
CUSTOMER TESTIMONIALS
=============================
IMPORTANT:
THIS NOW RECEIVES
REVIEWS FROM CUSTOMERS
=============================
*/

$review_query = mysqli_query($conn,

"SELECT * FROM reviews
ORDER BY id DESC");

$total_reviews =
mysqli_num_rows($review_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Seller Dashboard</title>

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
}

/* SIDEBAR */

.sidebar{

    width:260px;

    height:100vh;

    background:#0f5132;

    position:fixed;

    left:0;
    top:0;

    padding-top:20px;

    overflow-y:auto;
}

.sidebar .logo{

    text-align:center;

    margin-bottom:25px;
}

.sidebar .logo img{

    width:80px;
    height:80px;

    border-radius:50%;

    object-fit:cover;

    background:white;

    padding:5px;
}

.sidebar h2{

    color:white;

    text-align:center;

    margin-top:10px;

    font-size:24px;
}

.sidebar a{

    display:block;

    color:white;

    text-decoration:none;

    padding:15px 25px;

    transition:0.3s;

    font-size:15px;
}

.sidebar a:hover{

    background:#198754;

    padding-left:35px;
}

/* MAIN */

.main{

    margin-left:260px;

    padding:30px;
}

/* TOPBAR */

.topbar{

    background:rgba(255,255,255,0.95);

    padding:20px;

    border-radius:15px;

    margin-bottom:25px;

    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

.topbar h1{

    color:#0f5132;
}

/* WELCOME */

.welcome{

    background:rgba(255,255,255,0.95);

    padding:25px;

    border-radius:15px;

    margin-bottom:25px;

    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

.welcome h2{

    color:#0f5132;

    margin-bottom:10px;
}

.welcome p{

    color:#555;
}

/* CARDS */

.cards{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(240px,1fr));

    gap:20px;

    margin-bottom:30px;
}

.card{

    background:rgba(255,255,255,0.95);

    padding:25px;

    border-radius:15px;

    transition:0.3s;

    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

.card:hover{

    transform:translateY(-5px);
}

.card i{

    font-size:40px;

    color:#198754;

    margin-bottom:15px;
}

.card h2{

    color:#0f5132;

    margin-bottom:10px;

    font-size:22px;
}

.card p{

    color:#555;

    margin-bottom:15px;
}

.card a{

    display:inline-block;

    margin-top:10px;

    background:#0f5132;

    color:white;

    text-decoration:none;

    padding:10px 20px;

    border-radius:25px;

    transition:0.3s;
}

.card a:hover{

    background:#198754;
}

.number{

    font-size:35px;

    font-weight:700;

    color:#ff9800;

    margin-bottom:10px;
}

/* TESTIMONIAL SECTION */

.review-section{

    background:rgba(255,255,255,0.95);

    padding:25px;

    border-radius:15px;

    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

.review-section h2{

    color:#0f5132;

    margin-bottom:25px;
}

.review-card{

    background:#f5f7fa;

    padding:20px;

    border-radius:15px;

    margin-bottom:20px;

    border-left:6px solid #198754;
}

.review-card h3{

    color:#0f5132;

    margin-bottom:8px;
}

.review-card .stars{

    color:#ffc107;

    font-size:18px;

    margin-bottom:10px;
}

.review-card p{

    color:#555;

    line-height:1.6;
}

.review-date{

    margin-top:10px;

    color:#999;

    font-size:13px;
}

.no-review{

    text-align:center;

    padding:40px;

    color:#666;
}

.no-review i{

    font-size:60px;

    color:#ccc;

    margin-bottom:15px;
}

/* MOBILE */

@media(max-width:768px){

    .sidebar{

        width:100%;

        height:auto;

        position:relative;
    }

    .main{

        margin-left:0;
    }

    .cards{

        grid-template-columns:1fr;
    }
}

</style>

</head>
<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <div class="logo">

        <img src="uploads/logo.png"
        alt="Logo">

        <h2>

            Seller Panel

        </h2>

    </div>

    <a href="seller_dashboard.php">

        <i class="fas fa-home"></i>

        Dashboard

    </a>

    <a href="add_product.php">

        <i class="fas fa-plus"></i>

        Add Product

    </a>

    <a href="manage_products.php">

        <i class="fas fa-box"></i>

        Manage Products

    </a>

    <a href="seller_orders.php">

        <i class="fas fa-shopping-bag"></i>

        View Orders

    </a>

    <a href="logout.php">

        <i class="fas fa-sign-out-alt"></i>

        Logout

    </a>

</div>

<!-- MAIN -->

<div class="main">

    <!-- TOPBAR -->

    <div class="topbar">

        <h1>

            Seller Dashboard

        </h1>

    </div>

    <!-- WELCOME -->

    <div class="welcome">

        <h2>

            Welcome,
            <?php echo $fullname; ?> 👋

        </h2>

        <p>

            Manage products,
            track customer orders,
            monitor sales
            and receive customer testimonials.

        </p>

    </div>

    <!-- CARDS -->

    <div class="cards">

        <!-- PRODUCTS -->

        <div class="card">

            <i class="fas fa-box-open"></i>

            <div class="number">

                <?php echo $total_products; ?>

            </div>

            <h2>Total Products</h2>

            <p>

                Products uploaded by you.

            </p>

            <a href="manage_products.php">

                Manage Products

            </a>

        </div>

        <!-- ORDERS -->

        <div class="card">

            <i class="fas fa-shopping-cart"></i>

            <div class="number">

                <?php echo $total_orders; ?>

            </div>

            <h2>Customer Orders</h2>

            <p>

                View all customer purchases.

            </p>

            <a href="seller_orders.php">

                View Orders

            </a>

        </div>

        <!-- SALES -->

        <div class="card">

            <i class="fas fa-money-bill-wave"></i>

            <div class="number">

                UGX
                <?php echo number_format($total_sales); ?>

            </div>

            <h2>Total Sales</h2>

            <p>

                Revenue generated from customer orders.

            </p>

            <a href="seller_orders.php">

                Sales Report

            </a>

        </div>

        <!-- REVIEWS -->

        <div class="card">

            <i class="fas fa-star"></i>

            <div class="number">

                <?php echo $total_reviews; ?>

            </div>

            <h2>Testimonials</h2>

            <p>

                Customer reviews and feedback.

            </p>

            <a href="#reviews">

                View Reviews

            </a>

        </div>

    </div>

    <!-- CUSTOMER TESTIMONIALS -->

    <div class="review-section"
    id="reviews">

        <h2>

            <i class="fas fa-comments"></i>

            Customer Testimonials

        </h2>

        <?php

        mysqli_data_seek($review_query, 0);

        if(mysqli_num_rows($review_query) > 0){

            while($review =
            mysqli_fetch_assoc($review_query)){
        ?>

        <div class="review-card">

            <h3>

                <?php
                echo $review['customer_name'];
                ?>

            </h3>

            <div class="stars">

                <?php

                for($i=1; $i <=
                $review['rating']; $i++){

                    echo "⭐";
                }

                ?>

            </div>

            <p>

                "<?php
                echo $review['review'];
                ?>"

            </p>

            <div class="review-date">

                Customer Testimonial

            </div>

        </div>

        <?php
            }
        } else {
        ?>

        <div class="no-review">

            <i class="fas fa-comments"></i>

            <h3>

                No Testimonials Yet

            </h3>

            <p>

                Customer testimonials will appear here.

            </p>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>
```
