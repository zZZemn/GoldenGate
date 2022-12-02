<?php
    include "database.php";
    $id = $_GET['id'];

    $delete = "DELETE from inventory WHERE invent_no = $id";
    $connect->query($delete);

    header("location:inventory.php");