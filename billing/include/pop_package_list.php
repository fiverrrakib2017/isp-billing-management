<option value="">Select Package</option>
<?php
include("security_token.php");
include("pop_security.php");
include("db_connect.php");
include("users_right.php");

if(isset($_GET["popID"]))
{
    $popID = $_GET["popID"];

    $allPackageee = $con->query("SELECT * FROM branch_package WHERE pop_id='$popID'");
    while ($popRowwww = $allPackageee->fetch_array()) {
        $package_id= $popRowwww['id'];
        $package_name= $popRowwww['groupname'];
        echo '<option value="'.$package_id.'">'.$package_name.'</option>';
    }


}                                                                   

    

?>