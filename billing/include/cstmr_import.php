<?php
session_start();
//date_default_timezone_set('Asia/Dhaka');
include "db_connect.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['customImprt'])) {
  
    // Getting Data from CSV file
    $CSVvar = fopen("../csv/test.csv", "r");
if ($CSVvar !== FALSE) {

    //while (! feof($CSVvar)) {
    //$data = fgetcsv($CSVvar, 1000, ",");
    //if (! empty($data)) {
            for ($i =0; $data = fgetcsv($CSVvar); $i++) {
                if($i>0)
                {

                
                $DataUserfullname   = $data[0];
                $DataUsername       = $data[1];
                $Datapassword       = $data[2]; 
                $DatapackageName    = $data[3];
                $DataMobileNo       = $data[4]; 
                $DataPOPName        = $data[5];
                $DataAreaname       = $data[6]; 
                $DataPrice          = $data[7]; 
                $DataExpireDate     = $data[8]; 



  // Check User name existance
  $result = $con->query("SELECT * FROM customers WHERE username='$DataUsername' LIMIT 1");
  $DataUsrNameexst = mysqli_num_rows($result);  


    // POP Name Existance
    if ($popQ = $con->query("SELECT * FROM add_pop WHERE pop='$DataPOPName'")) {
        $DataPOPexst = mysqli_num_rows($popQ);
        while ($rowp = $popQ->fetch_array()) {
            $POPNAME = $rowp['pop'];
            $POP_ID = $rowp['id'];
        }
    }


  // POP area Existance
    if ($popareaQ = $con->query("SELECT * FROM area_list WHERE name='$DataAreaname' AND pop_id='$POP_ID'")) {
        $DataAreaexst = mysqli_num_rows($popareaQ);
        while ($rowar = $popareaQ->fetch_array()) {
                $AREA_ID = $rowar['id'];
        }
    }

// Existance Package
if ($PackageQ = $con->query("SELECT * FROM branch_package WHERE package_name='$DatapackageName' AND pop_id='$POP_ID'")) {
    $DataPkgexst = mysqli_num_rows($PackageQ);
    while ($rowpkg = $PackageQ->fetch_array()) {
        $package_id = $rowpkg['id'];
        $package_name = $rowpkg['package_name'];
        $package_purchase_price = $rowpkg['p_price'];
        $package_sales_price = $rowpkg['s_price'];
    }
}

// Insert Info Into Tables
if($DataUsrNameexst==0 && $DataPOPexst==1 && $DataAreaexst==1 && $DataPkgexst==1)
{

   // echo $DataUserfullname.' '.$DataUsername.' '.$Datapassword.'<br>';
   /*
                $DatapackageName    = $data[3];
                $DataMobileNo       = $data[4]; 
                $DataPOPName        = $data[5];
                $DataAreaname       = $data[6]; 
                $DataPrice          = $data[7]; 
                $DataExpireDate     = $data[8]; 
                */
    
$result = $con->query("INSERT INTO customers(fullname,username,password,package,package_name,expiredate,status,mobile,address,pop,area,price) 
VALUES('$DataUserfullname','$DataUsername','$Datapassword','$package_id','$DatapackageName','$DataExpireDate','1','$DataMobileNo','$DataAreaname','$POP_ID','$AREA_ID','$DataPrice')");
    if ($result == true) {

        //Update account recharge and transection
        $custID = $con->insert_id;
        $recharge_by=$_SESSION['username'];
        $con->query("INSERT INTO customer_rechrg(customer_id, pop_id,months, sales_price, purchase_price,ref,rchrg_until,type,rchg_by,datetm) 
          VALUES('$custID','$POP_ID','1','$package_sales_price','$package_purchase_price', 'On Connection', '$DataExpireDate','1','$recharge_by',NOW())");
        echo 1;
    } else {
        echo "Problem Is : " . $con->error;
    }
    $con->query("INSERT INTO radcheck(username,attribute,op,value) VALUES('$DataUsername','Cleartext-Password',':=','$Datapassword')");
    $con->query("INSERT INTO radreply(username,attribute,op,value) VALUES('$DataUsername','MikroTik-Group',':=','$DatapackageName')");
/**/
  } 
}
  }}
        
         
}