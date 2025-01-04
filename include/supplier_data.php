<?php 
include "db_connect.php";


if (isset($_GET["update"])) {
   $id=$_GET["id"];
   $fullname=$_GET["fullname"];
   $company=$_GET["company"];
   $status=$_GET["status"];
   $mobile=$_GET["mobile"];
   $email=$_GET["email"];
   $address=$_GET["address"];

   $con->query("UPDATE suppliers SET fullname='$fullname', company='$company',status='$status',mobile='$mobile',email='$email',address='$address' WHERE id=$id      ");
}


if (isset($_GET["add"])) {
    $fullname=$_GET["fullname"];
    $company=$_GET["company"];
    $status=$_GET["status"];
    $mobile=$_GET["mobile"];
    $email=$_GET["email"];
    $address=$_GET["address"];

  $con->query("INSERT INTO suppliers(fullname,company,status,mobile,email,address)VALUES('$fullname','$company','$status','$mobile','$email','$addres')");
}

if (isset($_GET['list'])) {
   if ($client=$con->query("SELECT *FROM suppliers")) {
      while($rows=$client->fetch_array()){
         $lstid=$rows["id"];
         $fullname=$rows["fullname"];
         $company=$rows["company"];
         $status=$rows["status"];
         $mobile=$rows["mobile"];
         $email=$rows["email"];
         $address=$rows["address"];


         echo '

         <tr>

         <td>'.$lstid.'</td>
         <td>'.$fullname.'</td>
         <td>'.$company.'</td>
         <td>'.$mobile.'</td>
         <td>'.$email.'</td>
         <td >
        <a class="btn btn-info" href="supplier_edit.php?clid='.$lstid.'"><i class="mdi mdi-border-color"></i></a>
        <a class="btn btn-success" href="supplier_profile.php?clid='.$lstid.'"><i class="mdi mdi-eye"></i>
        </a>

        </td>
         </tr>

         ';
      }
   }
}

 ?>