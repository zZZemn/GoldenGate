<?php 
    include "database.php";

    if(isset($_POST['save']))
    {
        $pro_name = $_POST['pro_name'];
        $pro_code = $_POST['pro_code'];
        $pro_cat = $_POST['pro_categories'];
        $selling_price = $_POST['price'];
        $measurement = $_POST['meas'];
        $quan = $_POST['quantity'];
        
        $updateProd = "UPDATE `products` SET `pro_name`='$pro_name',`pro_category` ='$pro_cat',
        `measurement`='$measurement',`price`='$selling_price',`quantity`='$quan' WHERE pro_code = $pro_code";

        $updating = mysqli_query($connect, $updateProd);

        header("location: products.php");
    }