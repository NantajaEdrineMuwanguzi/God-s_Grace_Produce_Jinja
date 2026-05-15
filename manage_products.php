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

$seller_name = $_SESSION['fullname'];

/*
=====================================
DELETE PRODUCT
=====================================
*/

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    // GET IMAGE
    $get_image = mysqli_query($conn,
    "SELECT image FROM products
    WHERE id='$id'");

    $image_row = mysqli_fetch_assoc($get_image);

    // DELETE IMAGE FILE
    if(!empty($image_row['image'])){

        $image_path =
        "uploads/" . $image_row['image'];

        if(file_exists($image_path)){

            unlink($image_path);
        }
    }

    // DELETE PRODUCT
    mysqli_query($conn,
    "DELETE FROM products
    WHERE id='$id'");

    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Manage Products</title>

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

/* MAIN CONTENT */

.main{

    margin-left:250px;

    padding:40px;
}

/* PAGE TITLE */

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

    box-shadow:0 5px 20px rgba(0,0,0,0.2);
}

table{

    width:100%;

    border-collapse:collapse;
}

table th{

    background:#0f5132;

    color:white;

    padding:15px;

    text-align:left;
}

table td{

    padding:15px;

    border-bottom:1px solid #ddd;
}

table img{

    width:80px;

    height:80px;

    object-fit:cover;

    border-radius:10px;
}

/* BUTTONS */

.btn-edit{

    padding:8px 15px;

    background:#198754;

    color:white;

    text-decoration:none;

    border-radius:8px;

    margin-right:5px;
}

.btn-delete{

    padding:8px 15px;

    background:#dc3545;

    color:white;

    text-decoration:none;

    border-radius:8px;
}

.btn-edit:hover{

    background:#157347;
}

.btn-delete:hover{

    background:#bb2d3b;
}

/* EMPTY */

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

    <!-- TITLE -->

    <div class="title">

        <h1>

            <i class="fas fa-box-open"></i>

            Manage Products

        </h1>

    </div>

    <!-- TABLE -->

    <div class="table-container">

<?php

$query = mysqli_query($conn,

"SELECT * FROM products
WHERE seller_name='$seller_name'
ORDER BY id DESC");

if(mysqli_num_rows($query) > 0){

?>

<table>

    <tr>

        <th>ID</th>

        <th>Image</th>

        <th>Product</th>

        <th>Price</th>

        <th>Description</th>

        <th>Actions</th>

    </tr>

<?php

while($row = mysqli_fetch_assoc($query)){

?>

<tr>

    <td>
        <?php echo $row['id']; ?>
    </td>

    <td>

        <img src="uploads/<?php
        echo $row['image']; ?>">

    </td>

    <td>

        <?php echo $row['name']; ?>

    </td>

    <td>

        UGX
        <?php echo number_format($row['price']); ?>

    </td>

    <td>

        <?php
        echo substr($row['description'],0,60);
        ?>...

    </td>

    <td>

        <a class="btn-edit"

        href="edit_product.php?id=<?php
        echo $row['id']; ?>">

            Edit

        </a>

        <a class="btn-delete"

        href="manage_products.php?delete=<?php
        echo $row['id']; ?>"

        onclick="return confirm(
        'Delete this product?')">

            Delete

        </a>

    </td>

</tr>

<?php } ?>

</table>

<?php

}else{

    echo "
    <div class='empty'>

        <h2>No Products Found</h2>

        <p>
            You have not uploaded
            any products yet.
        </p>

    </div>";
}

?>

    </div>

</div>

</body>
</html>
