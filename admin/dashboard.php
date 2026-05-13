<?php include '../config/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
<h1>Admin Dashboard</h1>

<h2>Add Product</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Product Name"><br>
    <input type="number" name="price" placeholder="Price"><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <button name="save">Save Product</button>
</form>

<?php
if(isset($_POST['save'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    mysqli_query($conn,
    "INSERT INTO products(name,price,description)
    VALUES('$name','$price','$description')");

    echo "Product Added";
}
?>
</body>
</html>
