<?php
include "db_connect.php";
if(isset($_GET['list'])){
    
if ($cstmr = $con -> query("SELECT * FROM customers")) {
  while($rows= $cstmr->fetch_array())
  {
	  $lstid=$rows["id"];
	  $fullname=$rows["fullname"];
	  $package = $rows["package"];
	  $username = $rows["username"];
	  $mobile = $rows["mobile"];
	 echo '
	 <tr>
     <td>'.$lstid.'</td>
     <td>'.$fullname.'</td>
     <td>'.$package.'</td>
	<td>'.$username.'</td>
	 <td>'.$mobile.'</td>
     <td></td>
     <td><input type="text" class="form-control form-control-sm"/></td>
     </tr>
	 '; 
    }
  }
}
$con -> close();
?>