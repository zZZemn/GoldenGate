<?php 
include("time&date.php");
session_start();

if (isset($_SESSION["user_id"])) {
    include("database.php");

    $sql = "SELECT * FROM user
            WHERE user_no = {$_SESSION["user_id"]}";
    $result = $connect->query($sql);
    $user = $result->fetch_assoc();

    $inventory = "SELECT * FROM inventory ORDER by ex_date";
    $inventory_result = $connect->query($inventory);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Transaction</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/sales-transaction.css">
</head>
<body>
    <?php if (isset($user)): ?>
        <nav class="top-nav">
            <a href="goldengate.php"><img src="img/ggd-logo.png" alt="GGD"></a>
            <h1>SALES</h1>
            <h5><?php echo "".$time ?></h5>
        </nav>
    
        <nav class="side-nav">
            <table class="nav-links">
                <tr class="user-profile">
                    <td><img src="img/person-circle-outline.svg" alt=""></td>
                    <td><a class="profile" href="#"><?php echo $user["f_name"]." ".$user["mi"]." ".$user["l_name"] ?></a></td>
                </tr>
                <tr>
                    <td><img src="img/reader-outline.svg" alt=""></td>
                    <td><a class="sales-trans" href="sales-transaction.php">SALES TRANSACTION</a></td>
                </tr>
                <tr>
                    <td><img src="img/layers-outline.svg" alt=""></td>
                    <td><a class="inventory" href="inventory.php">INVENTORY</a></td>
                </tr>
                <tr>
                    <td><img src="img/stats-chart-outline.svg" alt=""></td>
                    <td><a class="reports" href="reports.php">REPORTS</a></td>
                </tr>
                <tr>
                    <td><img src="img/build-outline.svg" alt=""></td>
                    <td><a class="maintenance" href="#">MAINTENANCE</a></td>
                </tr>
                <tr class="others-td">
                    <td><img src="img/apps-outline.svg" alt=""></td>
                    <td><a class="others" href="#">OTHERS</a></td>
                </tr>
            </table>

            <div class="date"><?php echo "<h4>".$date."</h4>"; ?></div>

            <table class="daily-sales">
                <tr>
                    <td class="img-td"><img src="img/wallet-outline.svg" alt=""></td>
                    <td class="daily-sales-text-td">DAILY SALES</td>
                </tr>
                <tr>
                    <td class="daily-sales-amount-td" colspan="2">PHP 1400</td>
                </tr>
            </table>

            <table class="notice">
                <tr>
                    <td class="img-td"><img src="img/alert-circle-outline.svg" alt=""></td>
                    <td class="notice-text-td">NOTICE</td>
                </tr>
                <tr>
                    <td class="notice-td" colspan="2"><li><a href="#">Products low level!</a></li></td>
                </tr>
            </table>
        </nav>

        <div class="process-sales-container">
                                        
              <table class="process-sales-table" border="1">
                <tr>
                    <th>Process&nbsp;ID</th>
                    <th>Customer&nbsp;ID</th>
                    <th>Subtotal</th>
                    <th>VAT</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Change</th>
                </tr>
             <?php 
                $pro_sales = "SELECT * FROM process_sales";
                $pro_sales_res = $connect->query($pro_sales);

                if($pro_sales_res->num_rows>0)
                    {
                        while($sales_row = $pro_sales_res->fetch_assoc())
                            {
                            echo "<tr>
                                <td><a target='_blank' href='sales-per-process.php?process_id=".$sales_row['process_id']."'>".$sales_row['process_id']."</a></td>
                                <td><a href='customer.php?id=".$sales_row['cust_id']."' target='_blank'>".$sales_row['cust_id']."</a></td>
                                <td>".$sales_row['sub_total']."</td>
                                <td>".$sales_row['vat']."</td>
                                <td>".$sales_row['discount']."</td>
                                <td>".$sales_row['total']."</td>
                                <td>".$sales_row['payment']."</td>
                                <td>".$sales_row['cust_change']."</td>
                                </tr>";
                            }
                    }
                else
                    {
                        echo "<tr class='empty'>
                            <th colspan='8'>Empty record!</th>
                         </tr>";
                    }
             ?>                           
              </table>                              
            </div>

            <a class="report" href="daily-sales-report-process.php">Report</a>               
        

    <?php else: ?>
        <div class="no-account-selected">
            <h1>No account selected</h1>
            <p class="Login"><a href="index.php">Login</a>
        </div>
    <?php endif; ?>
</body>
</html>