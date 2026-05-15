<?php include 'config/db.php'; ?>

<?php
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
$product = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
</head>
<body>

<h2><?php echo $product['name']; ?></h2>

<img src="uploads/<?php echo $product['image']; ?>" width="300">

<p><b>Seller:</b> <?php echo $product['seller_name']; ?></p>

<p><b>Price:</b> UGX <?php echo number_format($product['price']); ?></p>

<p><?php echo $product['description']; ?></p>

<a href="add_to_cart.php?id=<?php echo $product['id']; ?>">
    Add to Cart
</a>

</body>
</html>
