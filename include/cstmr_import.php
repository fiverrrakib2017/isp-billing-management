<?php
session_start();
include 'db_connect.php';
date_default_timezone_set('Asia/Dhaka');
if (isset($_GET['file_import'])) {
    if (isset($_FILES['import_file_name'])) {
        $file = $_FILES['import_file_name'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        /* Check if there are any upload errors*/
        if ($fileError !== UPLOAD_ERR_OK) {
            echo json_encode([
                'success' => false,
                'message' => 'Error uploading the file. Error code: ' . $fileError
            ]);
            exit;
        }
        $allowedTypes = ['text/csv', 'application/vnd.ms-excel', 'text/plain'];
        $maxFileSize = 50 * 1024 * 1024; 
       
        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            $uploadDir = "../csv/";            
          
            $newFileName = uniqid('', true) . '-' . basename($fileName);
            $uploadPath = $uploadDir . $newFileName;
            $folderPath = "../csv/";

            $permissions = fileperms($folderPath);
            //echo "File Permission: " . decoct($permissions & 0777);exit; 
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'File uploaded successfully.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error moving the uploaded file.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid file type'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No file selected.'
        ]);
    }
}

if (isset($_POST['customImprt'])) {
    
    $directory = '../csv/';
    $files = scandir($directory);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'csv') {
            $CSVvar = fopen($directory . $file, 'r');
           
            if ($CSVvar !== false) {
                for ($i = 0; ($data = fgetcsv($CSVvar)); $i++) {
                    if ($i > 0) {
                        $DataUserfullname = $data[0];
                        $DataUsername = $data[1];
                        $Datapassword = $data[2];
                        $DatapackageName = $data[3];
                        $DataMobileNo = $data[4];
                        $DataPOPName = $data[5];
                        $DataAreaname = $data[6];
                        $DataPrice = $data[7];
                        $DataExpireDate = $data[8];
                       
                        $DataExpireDate = date('Y-m-d', strtotime($DataExpireDate));
                        // Check User name existence
                        $result = $con->query("SELECT * FROM customers WHERE username='$DataUsername' LIMIT 1");
                        $DataUsrNameexst = mysqli_num_rows($result);

                        // POP Name Existence
                        if ($popQ = $con->query("SELECT * FROM add_pop WHERE pop='$DataPOPName'")) {
                            $DataPOPexst = mysqli_num_rows($popQ);
                            while ($rowp = $popQ->fetch_array()) {
                                $POPNAME = $rowp['pop'];
                                $POP_ID = $rowp['id'];
                            }
                        }

                        // POP Area Existence
                        if ($popareaQ = $con->query("SELECT * FROM area_list WHERE name='$DataAreaname' AND pop_id='$POP_ID'")) {
                            $DataAreaexst = mysqli_num_rows($popareaQ);
                            while ($rowar = $popareaQ->fetch_array()) {
                                $AREA_ID = $rowar['id'];
                            }
                        }

                        // Package Existence
                        if ($PackageQ = $con->query("SELECT * FROM branch_package WHERE package_name='$DatapackageName' AND pop_id='$POP_ID'")) {
                            $DataPkgexst = mysqli_num_rows($PackageQ);
                            while ($rowpkg = $PackageQ->fetch_array()) {
                                $package_id = $rowpkg['id'];
                                $package_name = $rowpkg['package_name'];
                                $package_purchase_price = $rowpkg['p_price'];
                                $package_sales_price = $rowpkg['s_price'];
                            }
                        }

                        // Insert Data into Tables
                        if ($DataUsrNameexst == 0 && $DataPOPexst == 1 && $DataAreaexst == 1 && $DataPkgexst == 1) {
                            $result = $con->query("INSERT INTO customers(fullname, username, password, package, package_name, expiredate, status, mobile, address, pop, area, price) 
                        VALUES('$DataUserfullname', '$DataUsername', '$Datapassword', '$package_id', '$DatapackageName', '$DataExpireDate', '1', '$DataMobileNo', '$DataAreaname', '$POP_ID', '$AREA_ID', '$DataPrice')");

                            if ($result == true) {
                                $custID = $con->insert_id;
                                $recharge_by = $_SESSION['username'];
                                $con->query("INSERT INTO customer_rechrg(customer_id, pop_id, months, sales_price, purchase_price, ref, rchrg_until, type, rchg_by, datetm) 
                                VALUES('$custID', '$POP_ID', '1', '$package_sales_price', '$package_purchase_price', 'On Connection', '$DataExpireDate', '1', '$recharge_by', NOW())");

                                $con->query("INSERT INTO radcheck(username, attribute, op, value) VALUES('$DataUsername', 'Cleartext-Password', ':=', '$Datapassword')");
                                $con->query("INSERT INTO radreply(username, attribute, op, value) VALUES('$DataUsername', 'MikroTik-Group', ':=', '$DatapackageName')");
                            } else {
                                echo 'Problem Is : ' . $con->error;
                            }
                        }
                    }
                }
            }
            fclose($CSVvar);
            unlink($directory . $file);
        }
    }
}

?>
