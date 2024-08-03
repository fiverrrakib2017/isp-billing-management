<?php 
include "db_connect.php";

if (isset($_POST["updateMessageTemplate"])) {
  $BrandId=$_POST["id"];
  $name=$_POST["name"];
  $message=$_POST["message"];
  $result=$con->query("UPDATE message_template SET  template_name='$name', text='$message' WHERE id=$BrandId");
  if ($result==true) {
    echo "Update Successfully";
  }else{
    echo "Error";
  }
   
}

if (isset($_POST['currentMsgTemp'])) {
  $id=$_POST['name'];
  if ($allData=$con->query("SELECT * FROM message_template WHERE id=$id")) {
      while ($rows=$allData->fetch_array()) {
          echo $rows['text'];
      }
  }
}


if(isset($_POST['messageDataInsert'])){
  $message= $_POST['message'];
  $user_type= $_POST['user_type'];
  $templateName= $_POST['templateName'];

  $result= $con->query("INSERT INTO message_template(template_name,text,user_type) VALUES('$templateName','$message','$user_type')");
  if ($result==true) {
    echo 1;
  }else{
    echo 0;
  }
}
  $con -> close();
?>

