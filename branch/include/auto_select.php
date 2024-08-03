
<?php
include "db_connect.php";
// if (isset($_POST['ledgerId']) && !empty($_POST['ledgerId'])) {
//  // Fetch state name base on country id
//  $query = "SELECT * FROM legder_sub WHERE ledger_id = ".$_POST['ledgerId'];
//  $result = $con->query($query);
 
//  if ($result->num_rows > 0) {
//  echo '<option value="">Select State</option>';
//  while ($row = $result->fetch_assoc()) {
//  echo '<option value="'.$row['ledger_id'].'">'.$row['item_name'].'</option>';
//  }
//  } else {
//  echo '<option value="">State not available</option>';
//  }
$sql="SELECT * FROM legder_sub WHERE ledger_id={$_POST['id']}";
$res=$con->query($sql);
echo "<option value=''>Select</option>";
while ($rows=$res->fetch_assoc()) {
	echo "<option value='{$rows['id']}'>{$rows['item_name']}</option>";
}

?>