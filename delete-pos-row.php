<?php
    include "database.php";

    $row = $_GET['row_no'];
    
    $posDel = "DELETE from current_pos_operation WHERE row = $row";
    
    
    if ($connect->query($posDel))
    {
        header("location:pos.php");
    }