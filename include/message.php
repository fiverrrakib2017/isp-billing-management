<?php
include 'db_connect.php';

if (isset($_POST['update_message_template'])) {
    $errors = [];

    /* Sanitize input values */
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $pop_id = isset($_POST['pop_id']) ? trim($_POST['pop_id']) : '';
    $template_name = isset($_POST['template_name']) ? trim($_POST['template_name']) : '';
    $template_message = isset($_POST['template_message']) ? trim($_POST['template_message']) : '';

    /* Validate pop_id */
    if (empty($pop_id)) {
        $errors['pop_id'] = 'POP/Branch id is required.';
    }

    /* Validate template name */
    if (empty($template_name)) {
        $errors['templateName'] = 'template Name is required.';
    }

    if (empty($template_message)) {
        $errors['template_message'] = ' Template Message is required.';
    }
    /* If validation errors exist, return errors */
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'errors' => $errors,
        ]);
        exit();
    }

    $result = $con->query("UPDATE message_template SET pop_id='$pop_id', template_name='$template_name', text='$template_message' WHERE id=$id");
    if ($result == true) {
        echo json_encode([
            'success' => true,
            'message' => 'Updated Successfully!',
        ]);
        exit();
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error!',
        ]);
        exit();
    }
    exit();
}

if (isset($_POST['currentMsgTemp'])) {
    $id = $_POST['name'];
    if ($allData = $con->query("SELECT * FROM message_template WHERE id=$id")) {
        while ($rows = $allData->fetch_array()) {
            echo $rows['text'];
        }
    }
}

if (isset($_POST['messageDataInsert'])) {
    $pop_id = $_POST['pop_id'];
    $message = $_POST['message'];
    $user_type = $_POST['user_type'];
    $templateName = $_POST['templateName'];

    $result = $con->query("INSERT INTO message_template(pop_id,template_name,text,user_type) VALUES('$pop_id','$templateName','$message','$user_type')");
    if ($result == true) {
        echo 1;
    } else {
        echo 0;
    }
}
$con->close();
?>
