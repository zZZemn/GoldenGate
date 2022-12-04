<?php 
include("time&date.php");
session_start();
$invalid = false;

if (isset($_SESSION["user_id"])) {
    include("database.php");

    $sql = "SELECT * FROM user
            WHERE user_no = {$_SESSION["user_id"]}";
    $result = $connect->query($sql);
    $user = $result->fetch_assoc();
    }
    //---------------------

    $vat_disc_Query = "SELECT * FROM payment_vat_discount";
    $vat_disc_result = $connect->query($vat_disc_Query);
    $vat_disc = $vat_disc_result->fetch_assoc();

    $tax = $vat_disc['vat'];
    $discount = $vat_disc['discount'];

    $cust_disc = 0;
    $subtotal = 0;
    $total = 0;

    $tblPOSquery = "SELECT * FROM current_pos_operation";
        $tblPOSres = $connect->query($tblPOSquery);
        if($tblPOSres->num_rows > 0)
        {
            while($row_pos = $tblPOSres->fetch_assoc())
            {
                $row_amount = $row_pos['amount'];
                $subtotal += $row_amount;
            }
        }
        
            $vat = $subtotal * $tax;
            $total = $subtotal + $vat;
            $finalTot = $total - $cust_disc;
        

//------------------------------------
    if (isset($_POST['add'])) {
            $pro_code = $_POST['pro_code'];
            $quantity = $_POST['qty'];

            $tblproduct = "SELECT * FROM products where pro_code = $pro_code";
            $tblproductres = $connect->query($tblproduct);
            $product = $tblproductres->fetch_assoc();

            $product_name = $product['pro_name'];
            $product_meas = $product['measurement'];
            $product_price = $product['price'];

            $amount = $product_price * $quantity;

            $tblPOS = "INSERT INTO current_pos_operation(`pro_name`, `measurement`, `pro_price`, `qty`, `amount`) 
                VALUES ('$product_name','$product_meas','$product_price','$quantity',' $amount')";

            $connect->query($tblPOS);

            //subtotal computation
            $subtotal += $amount;
            $vat = $subtotal * $tax;
            $total = $subtotal + $vat;
            $finalTot = $total - $cust_disc;
        }


    $change = 0;
    $payment = 0;
    if (isset($_POST['compute']))
        {
            $compVAT = $_POST['vat'];
            $compSUBTOT = $_POST['subtotal'];
            $compTOT = $_POST['total'];

            $payment = $_POST['payment'];
            $cust_id = $_POST['cust'];

            if(empty($cust_id))
                {
                    if ($payment >= $compTOT)
                        {
                            $change = $payment - $compTOT;
                        }
                    else
                        {
                            echo "<script type='text/javascript'>
                            window.onload = function () { alert('Payment should be greater than or equal to ".$compTOT."'); }
                                    </script>";
                        }
                }
            
            else
                {
                    $tblCustomer = "SELECT * FROM customer where cust_id = $cust_id";
                    $tblCustomerres = $connect->query($tblCustomer);
                    $customer = $tblCustomerres->fetch_assoc();
            
                    if(!$customer)
                        {
                            if ($payment >= $compTOT)
                                {
                                    $change = $payment - $compTOT;
                                }
                            else
                                {
                                    echo "<script type='text/javascript'>
                                    window.onload = function () { alert('Payment should be greater than or equal to ".$compTOT."'); }
                                            </script>";
                                }
                        }

                    else
                        {
                            $cust_age = $customer['age'];
                            if ($cust_age >= 60) {
                                $cust_disc = $finalTot * $discount;
                                $finalTot -= $cust_disc;
                            } else {
                                $cust_disc = 0;
                            }

                            if($payment >= $compTOT)
                            {

                                $change = $payment - $finalTot;
                            }
                            else
                            {
                                echo "<script type='text/javascript'>
                                    window.onload = function () { alert('Payment should be greater than or equal to ".$compTOT."'); }
                                            </script>";
                            }
                        }
                }
        }

    if(isset($_POST['cancel']))
        {
            $vat = 0;
            $cust_disc = 0;
            $subtotal = 0;
            $payment = 0;
            $finalTot = 0;
            $change = 0;

            $posDeleteAll = "DELETE from current_pos_operation";
            $connect->query($posDeleteAll);
        }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Point Of Sales</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/pos.css">
</head>
<body>
    <?php if (isset($user)): ?>
        <nav>
            <img src="img/ggd-logo-plain.png" alt="GGD" class="logo">
            <h3 class="store-name">GOLDEN GATE DRUGSTORE</h3>
            <h5><?php echo $time?> - <?php echo $date; ?></h5>
            
            <div class="name">
            <h3><?php echo $user['f_name']." ".$user['l_name']?></h3>
            <?php if($user['user_type'] == "Administrator")
                    {
                        echo "<hr>";
                        echo "<h3><a href='goldengate.php'>Admin Page</a></h3>";
                    } 
                    else
                    {
                        echo "<h3><a href='logout.php'><img src='img/log-out-outline.svg'></a></h3>";
                    }
            ?>
            </div>
        </nav>

        <div class="pos-container">
            <div class="main-pos">
                    <form action="" method="post">
                        <table class="search-table">
                            <tr>
                                <td class="search-td"> 
                                    <input type="text" name="pro_code" list="pro_code" placeholder="Enter Product Code / Name" required>
                                    <?php 
                                        $product_code = "SELECT * FROM products";
                                        $code_result = $connect->query($product_code);

                                        if($code_result->num_rows > 0)
                                        {
                                            echo "<datalist id='pro_code'>";

                                            while($row = $code_result->fetch_assoc())
                                            {
                                                echo "<option value=".$row['pro_code'].">".$row['pro_name']." - ".$row['quantity']."pc/s"."</option>";
                                            }
                                        }
                                    ?>
                                </td>
                                <td class="qty">
                                    <input type="number" name="qty" placeholder="qty" required>
                                </td>
                                <td class="btn">
                                    <input type="submit" name="add" value="Add">
                                </td>
                            </tr>
                        </table>
                    </form>

                    <div class="receipt-container">
                        <form action="" method="post">
                            <table class="receipt-table" border="1">
                                <tr>
                                    <th>Product</th>
                                    <th>Measurement</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                    <th colspan="2">Action</th>
                                </tr>

                            <?php
                                    $pos = "SELECT * FROM current_pos_operation";
                                    $pos_res = $connect->query($pos);

                                        if($pos_res->num_rows > 0)
                                            {
                                                while($posrow = $pos_res->fetch_assoc())
                                                {
                                                echo "
                                                    <tr class='product-adding'>
                                                    <td class='product_td'><input readonly type='text' name='pro_name' value=" . $posrow['pro_name']."></td>
                                                    <td class='meas_td'><input readonly type='text' name='measurement' value=" . $posrow['measurement'] . "></td>
                                                    <td class='price_td'><input readonly type='text' name='price' value=" . $posrow['pro_price'] . "></td>
                                                    <td class='qty_td'><input type='number' name='quantity' value=" . $posrow['qty'] . "></td>
                                                    <td class='amount_td'><input readonly type='text' name='amout' value=" . $posrow['amount'] . "></td>
                                                    <td class='action-btn'><a href='delete-pos-row.php?row_no=".$posrow['row']."'><img src='img/trash.svg' alt=''></a></td>
                                                    </tr>";
                                                }
                                            }
                            ?>
                            </table>
                        </div>
                        
                        <table class="pos-btns-table">
                            <tr>
                                <th>VAT</th>
                                <th>TOTAL</th>
                                <th>CHANGE</th>
                                
                            </tr>
                            <tr>
                                <td><input type="text" name="vat" placeholder="VAT" readonly value="<?php echo $vat; ?>"></td>
                                <td><input type="text" name="total" placeholder="Total" readonly value="<?php echo $finalTot ?>"></td>
                                <td class="change-td"><input type="text" name="change" placeholder="Change" readonly value="<?php echo $change ?>"></td>
                                <td class="cust-id" colspan="2"><input type="text" name="cust" placeholder="Custumer ID" list="customers_ID">
                                    <?php 
                                        $customer_ID = "SELECT * FROM customer";
                                        $customer_result = $connect->query($customer_ID);

                                        if($customer_result->num_rows > 0)
                                        {
                                            echo "<datalist id='customers_ID'>";

                                            while($row = $customer_result->fetch_assoc())
                                            {
                                                echo "<option value=".$row['cust_id'].">".$row['cust_name']."</option>";
                                            }
                                        }
                                    ?>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>DISCOUNT</th>
                                <th>SUBTOTAL</th>
                                <th>PAYMENT</th>
                                <td class="right"><input class="btn2  compute" type="submit" name="compute" value="Compute"></td>
                                <td class="left"><button class="btn2 print">Print</button></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="discount" placeholder="Discount" readonly value="<?php echo $cust_disc ?>"></td>
                                <td><input type="text" name="subtotal" placeholder="Subtotal" readonly value="<?php echo $subtotal ?>"></td>
                                <td class="payment-td"><input type="number" step="any" name="payment" placeholder="Payment" value="<?php echo $payment ?>"></td>
                                <td class="right"><input class="btn2 settle" type="submit" name="settle" value="Settle"></td>
                                <td class="left"><input class="btn2 cancel" type="submit" name="cancel" value="Cancel"></td>
                            </tr>
                        </table>
                    </form>

            </div>
        </div>

    <?php else: ?>
        <div class="no-account-selected">
            <h1>No account selected</h1>
            <p class="Login"><a href="index.php">Login</a>
        </div>
    <?php endif; ?>

    
    <script>
        if ( window.history.replaceState ) 
            {
                window.history.replaceState( null, null, window.location.href );
            }
    </script>
</body>
</html>