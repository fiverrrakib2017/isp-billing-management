<?php 
include "db_connect.php";

if (isset($_GET["update"])) {
	 $clid=$_GET["id"];
	$fullname=$_GET["fullname"];
	$company=$_GET["company"];
	$status=$_GET["status"];
	$mobile=$_GET["mobile"];
	$email=$_GET["email"];
	$address=$_GET["address"];
	$con->query("UPDATE clients SET fullname='$fullname', company='$company',status='$status',mobile='$mobile',email='$email',address='$address' WHERE id='$clid'      ");
}


if (isset($_GET["add"])) {
    $fullname=$_GET["fullname"];
    $company=$_GET["company"];
    $status=$_GET["status"];
    $mobile=$_GET["mobile"];
    $email=$_GET["email"];
    $address=$_GET["address"];

  $con->query("INSERT INTO clients(fullname,company,status,mobile,email,address,createdate)VALUES('$fullname','$company','$status','$mobile','$email','$address',NOW())");
}

if (isset($_GET['list'])) {
	if ($client=$con->query("SELECT *FROM clients")) {
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
        <a class="btn btn-success" href="client_profile.php?clid='.$lstid.'"><i class="mdi mdi-eye"></i>
        </a>

        <a class="btn btn-info" href="client_edit.php?clid='.$lstid.'"><i class="fas fa-edit"></i></a>
        <a class="btn btn-danger" href="client_delete.php?clid='.$lstid.'"><i class="fas fa-trash"></i>
        </a>

        </td>
			</tr>

			';
		}
	}
}

 ?>