<?php
    include "database.php";
    $id = $_GET['id'];

    $cust = "SELECT * FROM customer WHERE cust_id = $id";
    $custRes = $connect->query($cust);
    $customer = $custRes->fetch_assoc();
?>

<html>
    <head>
        <title><?php echo $customer['cust_name'] ?></title>
        <link rel="stylesheet" href="css/customer.css">
    </head>
    <body>
        <table>
            <tr class="heading">
                <td>ID</td>
                <td>Name</td>
            </tr>
            <tr class="bottom">
                <td><?php echo $customer['cust_id']?></td>
                <td><?php echo $customer['cust_name']?></td>
            </tr>

            <tr>
                <td colspan="2"><hr></td>
            </tr>

            <tr class="heading top">
                <td>Age</td>
                <td>Address</td>
            </tr>
            <tr>
                <td><?php echo $customer['age']?></td>
                <td><?php echo $customer['address']?></td>
            </tr>
        </table>
    </body>
</html>