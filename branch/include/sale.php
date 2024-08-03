<?php
include "db_connect.php";
session_start();
 $sessionUserId=$_SESSION["uid"];
//delete data
if (isset($_POST['deleteData'])) {
    $id=$_POST['id'];
    $result=$con->query("DELETE FROM `invoice_details` WHERE  id=$id");
    if ($result==true) {
        echo "Item Delete Successfully";
    }
}



if (isset($_POST['getDetails'])) {
  $a=1;

 if ($invDetails=$con->query("SELECT * FROM invoice_details WHERE usr_id=$sessionUserId ")) {
      while($rows=$invDetails->fetch_array()){
         $id=$rows["id"];
         $items=$rows["items"];
         $qty=$rows["qty"];
         $value=$rows["value"];
         $total=$rows["total"];

         echo '<tr>

         <td>'.$a++.'</td>
         <td>'.$items.'</td>
         <td>'.$qty.'</td>
         <td>'.$value.'</td>
         <td>'.$total.'</td>
         <td><button type="button" data-id='.$id.' class="btn-sm btn btn-danger deleteBtn"><i class="fas fa-trash"></i></button></td>
         

         </tr>';
      }
   } 
}

if(isset($_POST['addData']))
   {
    
         $userId= $_POST['userId'];
         $date= date("Y-m-d");
         $client= $_POST['client'];
         $refer_no= $_POST['refer_no'];
         $desc= $_POST['desc'];
         $item= $_POST['item'];
         $quantity= $_POST['quantity'];
         $value= $_POST['value'];
         $total= $_POST['total'];
        $discount=$_POST['discount'];
        //for example 100 tk 5 % how?
        $getPer=($discount/100) * $total;
        $grand_total=$total-$getPer;//calculation get grand total

      $con->query("INSERT INTO invoice(client_id,date,sub_total,discount,grand_total,note) VALUES('$client','$date','$total','$discount','$grand_total','$desc')");
      // $con->rollback();

       $invcID = $con->insert_id;
      $result=$con->query("INSERT INTO invoice_details(invoice_id,usr_id,items,qty,value,total)VALUES('$invcID','$userId','$item','$quantity','$value','$total')");
   }
   //now we show grand total in front end 
   if (isset($_POST['getTotalSum'])) {
       if ($al=$con->query("SELECT * FROM invoice_details INNER JOIN invoice ON invoice.id=invoice_details.invoice_id WHERE usr_id=$sessionUserId ")) {
           while ($rows=$al->fetch_array()) {
                $sum += $rows['grand_total'];
           }
           echo '

           <tr>
              <th colspan="4"class="text-center">
              <strong style="float:right;">Sub Total =</strong></th>

              <td colspan="2"><strong>$'.$sum.'</strong></td>
            </tr>
            <tr>
              <th colspan="4"class="text-center"><strong style="float:right;">Discount =</strong></th>
              <td colspan="2"><strong>$00</strong></td>
            </tr>
            <tr>
              <th colspan="4"class="text-center"><strong style="float:right;">Grand Total =</strong></th>
              <td colspan="2"><strong>$'.$sum.'</strong></td>
            </tr>

           ';
       }else{
        echo "No data";
       }
   }


?>