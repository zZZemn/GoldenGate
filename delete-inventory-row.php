<?php
    include "database.php";
    $invent_no = $_GET['invent_no'];

    $query = "SELECT * FROM inventory WHERE invent_no = $invent_no";
    $result = $connect->query($query);
    $row = $result->fetch_assoc();

    $pro_code = $row['pro_code'];
    $tblProductQuery = "SELECT * FROM products WHERE pro_code = $pro_code";
    $tblProductQueryResult = $connect->query($tblProductQuery);
    $product_row = $tblProductQueryResult->fetch_assoc();


    echo "<html>
            <head>
            <title>Delete</title>
            <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap' rel='stylesheet'>
            <link rel='stylesheet' href='css/delete-inventory-row.css'>
            <head>
            <div class='delete-inventory'>
                <img src='img/alert-circle-outline.svg'>
                <h5>Are you sure that you want to delete ".$product_row['pro_name']."<br>That delivered on ".$row['del_date']."?</h5>
                <hr>
                <div>
                <a href='delete-inventory-row-process.php?id=".$row['invent_no']."' class='confirm'>Confirm</a>
                <a href='inventory.php' class='cancel'>Cancel</a>
                <div>
            </div>
            </html>";