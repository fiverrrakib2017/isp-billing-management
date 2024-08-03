<?php
include "db_connect.php";
$a=1;

 if ($invDetails=$con->query("SELECT *FROM invoice_details")) {
                              while($rows=$invDetails->fetch_array()){
                                 $id=$rows["id"];
                                 $items=$rows["items"];
                                 $qty=$rows["qty"];
                                 $value=$rows["value"];
                                 $total=$rows["total"];

                                 echo '<tr>

                                 <td>'.$id.'</td>
                                 <td>'.$items.'</td>
                                 <td>'.$qty.'</td>
                                 <td>'.$value.'</td>
                                 <td>'.$total.'</td>

                                 </tr>';
                              }
                           } 

if(isset($_GET['add']))
   {
    
      $userId= $_GET['id'];
      $date= $_GET['date'];
      $client= $_GET['client'];
      $refer_no= $_GET['refer_no'];
      $desc= $_GET['desc'];
      $item= $_GET['item'];
      $quantity= $_GET['quantity'];
      $value= $_GET['value'];
      $total= $_GET['total'];
   
      $sql=$con -> query("INSERT INTO purchase(usr_id,client_id,date) VALUES('$userId','$client','$date')");

      $invcID = $con->insert_id;
      $result=$con->query("INSERT INTO purchase_details(invoice_id,items,qty,value,total)VALUES('$invcID','$item','$quantity','$value','$total')");
   }


?>