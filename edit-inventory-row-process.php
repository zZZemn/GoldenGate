<?php 
    include "database.php";

    if(isset($_POST['save']))
    {
        $invent_id = $_POST['invent_id'];
        $del_price = $_POST['del_price'];
        $del_qty = $_POST['del_qty'];
        $del_date = $_POST['del_date'];
        $ex_date = $_POST['ex_date'];
        
        $updateInv = "UPDATE `inventory` SET `del_price`='$del_price',`del_qty`='$del_qty',
        `ex_date`='$ex_date',`del_date`='$del_date' WHERE invent_no = $invent_id";

        $updating = mysqli_query($connect, $updateInv);

        header("location: inventory.php");
    }
