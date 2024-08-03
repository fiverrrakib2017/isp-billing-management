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
if (isset($_POST['currentCstmrAc'])) {
  $id=$_POST['name'];
  if ($allData=$con->query("SELECT * FROM customers WHERE id=$id")) {
      while ($rows=$allData->fetch_array()) {
          echo $rows['mobile'];
      }
  }
}


if(isset($_POST['messageDataInsert'])){
  $message= $_POST['message'];
  $pop_id= $_POST['pop_id'];
  $templateName= $_POST['templateName'];

  $result= $con->query("INSERT INTO message_template(template_name,text,pop_id) VALUES('$templateName','$message','$pop_id')");
  if ($result==true) {
    echo "Message Template Save Successfully";
  }else{
    echo "Something else please try again";
  }
}
  $con -> close();
?>

