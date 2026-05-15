<?php
session_start();
include 'config/db.php';

/*
=====================================
ONLY SELLERS CAN ACCESS
=====================================
*/

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != "seller"){

    header("Location: login.php");
    exit();
}

/*
=====================================
GET PRODUCT ID
=====================================
*/

if(!isset($_GET['id'])){

    header("Location: manage_products.php");
    exit();
}

$id = $_GET['id'];

/*
=====================================
FETCH PRODUCT
=====================================
*/

$query = mysqli_query($conn,
"SELECT * FROM products WHERE id='$id'");

$product = mysqli_fetch_assoc($query);

if(!$product){

    header("Location: manage_products.php");
    exit();
}

$message = "";

/*
=====================================
UPDATE PRODUCT
=====================================
*/

if(isset($_POST['update_product'])){

    $name = mysqli_real_escape_string($conn,
    $_POST['name']);

    $price = mysqli_real_escape_string($conn,
    $_POST['price']);

    $description = mysqli_real_escape_string($conn,
    $_POST['description']);

    // OLD IMAGE
    $old_image = $product['image'];

    // CHECK IF NEW IMAGE IS UPLOADED
    if(!empty($_FILES['image']['name'])){

        $new_image = time() . "_" .
        $_FILES['image']['name'];

        $tmp_name =
        $_FILES['image']['tmp_name'];

        $upload_path =
        "uploads/" . $new_image;

        // MOVE IMAGE
        move_uploaded_file($tmp_name,
        $upload_path);

        // DELETE OLD IMAGE
        if(file_exists("uploads/" . $old_image)){

            unlink("uploads/" . $old_image);
        }

    }else{

        $new_image = $old_image;
    }

    /*
    =====================================
    UPDATE QUERY
    =====================================
    */

    $update = mysqli_query($conn,

    "UPDATE products SET

    name='$name',
    price='$price',
    description='$description',
    image='$new_image'

    WHERE id='$id'");

    if($update){

        $message = "Product updated successfully!";

        // REFRESH PRODUCT DATA
        $query = mysqli_query($conn,
        "SELECT * FROM products
        WHERE id='$id'");

        $product =
        mysqli_fetch_assoc($query);

    }else{

        $message = "Failed to update product!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Edit Product</title>

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

/* FORM CARD */

.form-card{

    max-width:700px;

    margin:auto;

    background:rgba(255,255,255,0.96);

    padding:35px;

    border-radius:20px;

    box-shadow:0 5px 20px rgba(0,0,0,0.2);
}

.form-card h1{

    color:#0f5132;

    margin-bottom:25px;

    text-align:center;
}

/* MESSAGE */

.message{

    background:#d1e7dd;

    color:#0f5132;

    padding:12px;

    border-radius:10px;

    margin-bottom:20px;

    text-align:center;
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

.input-box input,
.input-box textarea{

    width:100%;

    padding:14px;

    border:1px solid #ccc;

    border-radius:10px;

    outline:none;
}

.input-box textarea{

    resize:none;

    height:140px;
}

/* IMAGE */

.current-image{

    width:150px;

    height:150px;

    object-fit:cover;

    border-radius:15px;

    margin-top:10px;
}

/* BUTTON */

.btn{

    width:100%;

    padding:14px;

    border:none;

    background:#0f5132;

    color:white;

    font-size:16px;

    border-radius:10px;

    cursor:pointer;

    transition:0.3s;
}

.btn:hover{

    background:#198754;
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

    <a href="logout.php">

        <i class="fas fa-sign-out-alt"></i>

        Logout

    </a>

</div>

<!-- MAIN CONTENT -->

<div class="main">

    <div class="form-card">

        <h1>

            <i class="fas fa-edit"></i>

            Edit Product

        </h1>

        <!-- MESSAGE -->

        <?php
        if($message != ""){
            echo "<div class='message'>
            $message
            </div>";
        }
        ?>

        <!-- FORM -->

        <form method="POST"
        enctype="multipart/form-data">

            <!-- PRODUCT NAME -->

            <div class="input-box">

                <label>
                    Product Name
                </label>

                <input type="text"

                name="name"

                value="<?php
                echo $product['name'];
                ?>"

                required>

            </div>

            <!-- PRICE -->

            <div class="input-box">

                <label>
                    Product Price (UGX)
                </label>

                <input type="number"

                name="price"

                value="<?php
                echo $product['price'];
                ?>"

                required>

            </div>

            <!-- DESCRIPTION -->

            <div class="input-box">

                <label>
                    Product Description
                </label>

                <textarea
                name="description"

                required><?php
                echo $product['description'];
                ?></textarea>

            </div>

            <!-- CURRENT IMAGE -->

            <div class="input-box">

                <label>
                    Current Image
                </label>

                <br>

                <img src="uploads/<?php
                echo $product['image'];
                ?>"

                class="current-image">

            </div>

            <!-- NEW IMAGE -->

            <div class="input-box">

                <label>
                    Upload New Image
                </label>

                <input type="file"
                name="image">

            </div>

            <!-- BUTTON -->

            <button type="submit"

            name="update_product"

            class="btn">

                <i class="fas fa-save"></i>

                Update Product

            </button>

        </form>

    </div>

</div>

</body>
</html>
