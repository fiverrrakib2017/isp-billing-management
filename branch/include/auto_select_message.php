
<?php
include "db_connect.php";
$sql="SELECT * FROM customers WHERE id={$_POST['id']}";
$res=$con->query($sql);
echo "<option value=''>Select</option>";
while ($rows=$res->fetch_assoc()) {
	echo "<option value='{$rows['id']}'>{$rows['mobile']}</option>";
}

?>