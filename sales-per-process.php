<?php
    include "database.php";
    $id = $_GET['process_id'];

    $sales = "SELECT * FROM sales WHERE process_id = $id";
    $salesRes = $connect->query($sales);
?>
<html>
<head>
    <title>
        <?php echo "process id ".$id." Receipt"?>
    </title>
    <link rel="stylesheet" href="css/receipt.css">
</head>
    <body>
    
        <table>
            <tr>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Measurement</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
            <?php
            if ($salesRes->num_rows > 0)
                $qty = 0;
            while($row = $salesRes->fetch_assoc())
            {
                $pro_code = $row['pro_code'];
                
                $productDetails = "SELECT * FROM products WHERE pro_code = $pro_code";
                $proDetRes = $connect->query($productDetails);
                $proDet = $proDetRes->fetch_assoc();
                $qty += $row['quantity'];

                            echo "<tr>
                            <td>".$pro_code."</td>
                            <td>".$proDet['pro_name']."</td>
                            <td>".$proDet['measurement']."</td>
                            <td>".$row['quantity']."</td>
                            <td>".$row['amount']."</td>
                            </tr>";

                    echo "";
                        }

                        $computedAmt = "SELECT * FROM process_sales WHERE process_id = $id";
                        $result = $connect->query($computedAmt);
                        $amt = $result->fetch_assoc();
                        ?>

                        <tr>
                            <td colspan="5"><hr></td>
                        </tr>
                        <tr>
                            <td colspan="3">Total Quantity: </td>
                            <td><?php echo $qty ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5"><hr></td>
                        </tr>
                        <tr>
                            <td>Subtotal</th>
                            <td colspan="2"></td>
                            <td>PHP</td>
                            <td><?php echo $amt['sub_total']?></td>
                        </tr>
                        <tr>
                            <td>VAT</td>
                            <td colspan="2"></td>
                            <td>PHP</td>
                            <td><?php echo $amt['vat']?></td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td colspan="2"></td>
                            <td>PHP</td>
                            <td><?php echo $amt['discount']?></td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td colspan="2"></td>
                            <td>PHP</td>
                            <td><?php echo $amt['total']?></td>
                        </tr>
                        <tr class="change">
                            <td>CHANGE</td>
                            <td colspan="2"></td>
                            <td>PHP</td>
                            <td><?php echo $amt['cust_change']?></td>
                        </tr>
                        <tr>
                            <td><input type="button" onclick="window.print()" value="Print"></td>
                        </tr>
        </table>
    </body>
</html>