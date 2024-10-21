<?php
include "db_connect.php";




if (isset($_POST["rechargeFilter"])) {
    $fromDate = $_POST["fromDate"];
    $toDate = $_POST["toDate"];
    $popid = $_POST["popid"];
    if (empty($popid)) {
        $popid=1;
    }

    $totalAmount = 0;

    if ($result=$con->query("SELECT * FROM customers INNER JOIN customer_rechrg ON customers.id=customer_rechrg.customer_id WHERE `datetm` BETWEEN '$fromDate'AND '$toDate' AND `pop_id` = '$popid'")) {
        while ($rows=$result->fetch_array()) {
            $totalAmount += $rows['sales_price'];
            echo '
              <tr>
                 <td>'.$rows['fullname'].'</td>
                 <td>'.$rows['datetm'].'</td>
                 <td>'.$rows['months'].'</td>
                 <td>'.$rows['rchrg_until'].'</td>
                 <td>'.$rows['sales_price'].'</td>
              </tr>
            ';
        }
    }
    echo '
        <tr>
            <td colspan="4"><strong>Total Amount</strong></td>
            <td><strong>'.$totalAmount.'</strong></td>
        </tr>
    ';
}
