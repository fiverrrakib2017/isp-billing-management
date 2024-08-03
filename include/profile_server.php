<?php
include 'db_connect.php';
if (isset($_FILES['uploadFile'])) {
  //echo $_FILES['uploadFile']['name'];
      $file_name = $_FILES['uploadFile']['name'];
      $file_size =$_FILES['uploadFile']['size'];
      $file_tmp =$_FILES['uploadFile']['tmp_name'];
      $file_type=$_FILES['uploadFile']['type'];
      $result=move_uploaded_file($file_tmp, "http://103.146.16.154/profileImages/".$file_name);
      if ($result==true) {
        echo "Success";
      }else{
        echo "Error";
      }
}
// if (isset($_FILES['file'])) {
//    $filename= $_FILES['file']['name'];
//    $extension=pathinfo($filename,PATHINFO_EXTENSION);
//    $validExtension=array("png","jpg");
//    if (in_array($extension, $validExtension)) {
//      $new_name=rand().".".$extension;
//      $path="../profileImages/".$new_name;
//      if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
//         echo "Photo Uplaod Successfully";
//      }
//    }
// }else{
//   echo "select a file";
// }

// if(isset($_FILES['file']['name'])){

//    /* Getting file name */
//    $filename = $_FILES['file']['name'];

//    /* Location */
//    $location = "http://103.146.16.154/profileImages/".$filename;
//    $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
//    $imageFileType = strtolower($imageFileType);

//    /* Valid extensions */
//    $valid_extensions = array("jpg","jpeg","png");

//    $response = 0;
//    /* Check file extension */
//    if(in_array(strtolower($imageFileType), $valid_extensions)) {
//       /* Upload file */
//       if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
//          $response = $location;
//       }
//    }

//    echo $response;
//    exit;
// }

