<?php
    include "database.php";
    $id = $_GET['id'];

    $inventoryDelete = "DELETE from inventory WHERE pro_code = $id";
    $delete = "DELETE from products WHERE pro_code = $id";

    if ($connect->query($inventoryDelete))
        {
            $connect->query($delete);
            header("location:products.php");
        }