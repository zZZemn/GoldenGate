<?php 
include("time&date.php");
session_start();


if (isset($_SESSION["user_id"])) {
    include("database.php");
    
    $sql = "SELECT * FROM user
            WHERE user_no = {$_SESSION["user_id"]}";
    $result = $connect->query($sql);
    $user = $result->fetch_assoc();
    
    $process_sales = "SELECT * FROM process_sales";
    $pro_sales_res = $connect->query($process_sales);
    
    $sub = 0;
    $vat = 0;
    $total = 0;
    $userLname = $user['l_name'];

    if($pro_sales_res->num_rows >0)
    {
            
           while($row = $pro_sales_res->fetch_assoc())
            {
                $sub += $row['total'];
                $vat += $row['vat'];
                
            }
            
            $total = $sub - $vat;
            
            $report = "INSERT INTO `sales-report`(`date`, `time`, `sales_subtot`, `total_vat`, `total`, `user`) 
        VALUES ('$date','$time','$sub','$vat','$total','$userLname')";
        $connect->query($report);
        
        $delSales = "DELETE FROM sales";
        $delProcSales = "DELETE FROM process_sales";

        $connect->query($delSales);
        $connect->query($delProcSales);
        }



        header("location:reports.php");
}

?>