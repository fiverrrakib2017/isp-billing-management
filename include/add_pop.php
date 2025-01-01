<?php
include 'db_connect.php';

/*Update POP/Branch Script*/
if (isset($_GET['update']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    /*Sanitize and validate inputs*/
    $id = intval($_POST['id']);
    $pop = trim($_POST['pop']);
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $opening_bal = trim($_POST['opening_bal']);
    $mobile_num1 = trim($_POST['mobile_num1']);
    $mobile_num2 = trim($_POST['mobile_num2']);
    $email_address = trim($_POST['email_address']);
    $note = trim($_POST['note']);

    $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
    $pop = isset($_POST["pop"]) ? trim($_POST["pop"]) : '';
    $fullname = isset($_POST["fullname"]) ? trim($_POST["fullname"]) : '';
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';
    $opening_bal = isset($_POST["opening_bal"]) ? trim($_POST["opening_bal"]) : '';
    $mobile_num1 = isset($_POST["mobile_num1"]) ? trim($_POST["mobile_num1"]) : '';
    $mobile_num2 = isset($_POST["mobile_num2"]) ? trim($_POST["mobile_num2"]) : '';
    $email_address = isset($_POST["email_address"]) ? trim($_POST["email_address"]) : '';
    $note = isset($_POST["note"]) ? trim($_POST["note"]) : '';

    /* Validate pop */
    if (empty($pop)) {
        echo json_encode([
            'status' => false,
            'message' => 'POP/Branch name is required!',
        ]);
        exit;
    }
    /* Validate fullname */
    if (empty($fullname)) {
        echo json_encode([
            'status' => false,
            'message' => 'fullname is required!',
        ]);
        exit;
    }
    /* Validate username */
    if (empty($username)) {
        echo json_encode([
            'status' => false,
            'message' => 'Username is required!',
        ]);
        exit;
    }
    /* Validate password */
    if (empty($password)) {
        echo json_encode([
            'status' => false,
            'message' => 'password is required!',
        ]);
        exit;
    }
    /* Validate opening_bal */
    if (empty($opening_bal)) {
        echo json_encode([
            'status' => false,
            'message' => 'Opening Balance is required!',
        ]);
        exit;
    }
    /* Validate mobile_num1 */
    if (empty($mobile_num1)) {
        echo json_encode([
            'status' => false,
            'message' => 'mobile_num1 is required!',
        ]);
        exit;
    }
    /* Validate mobile_num2 */
    if (empty($mobile_num2)) {
        echo json_encode([
            'status' => false,
            'message' => 'mobile_num2 is required!',
        ]);
        exit;
    }
    /* Validate email_address */
    if (empty($email_address)) {
        echo json_encode([
            'status' => false,
            'message' => 'Email Address is required!',
        ]);
        exit;
    }

    /*Update query*/
    $query = "UPDATE add_pop SET 
                pop = ?, 
                fullname = ?, 
                username = ?, 
                password = ?, 
                opening_bal = ?, 
                mobile_num1 = ?, 
                mobile_num2 = ?, 
                email_address = ?, 
                note = ? 
              WHERE id = ?";

    $stmt = $con->prepare($query);
    if ($stmt) {
        $stmt->bind_param('sssssssssi', $pop, $fullname, $username, $password, $opening_bal, $mobile_num1, $mobile_num2, $email_address, $note, $id);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => true,
                'message' => 'POP/Branch updated successfully!',
                
            ]);
            exit; 
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Failed to update POP/Branch.',
            ]);
            exit; 
        }
    }
    exit; 
}

if (isset($_GET['list'])) {
    $popttlusr = 0;
    if ($pop_list = $con->query('SELECT * FROM add_pop')) {
        while ($rows = $pop_list->fetch_array()) {
            $lstid = $rows['id'];
            $pop_name = $rows['pop'];

            if ($pop_usr = $con->query("SELECT * FROM customers WHERE pop='$pop_name'")) {
                $popttlusr = $pop_usr->num_rows;
            }

            echo '
        <tr>
          <td>' .
                $lstid .
                '</td>
          <td>' .
                $pop_name .
                '</td>
      <td>' .
                $popttlusr .
                '</td>
          <td  class="text-right">
          <a class="btn btn-info"  href="pop_edit.php?id=' .
                $lstid .
                '"><i class="mdi mdi-border-color"></i></a>

          
          <button class="btn btn-primary btn-delete" data-id=' .
                $lstid .
                ' style="cursor:pointer; color:white;"><i class="mdi mdi-delete"></i></button>

          <a class="btn btn-success" href="view_pop.php?id=' .
                $lstid .
                '"><i class="mdi mdi-eye"></i></a>
          </td>
      ';
        }
    }
}

if (isset($_POST['pop_id'])) {
    $popID = $_POST['pop_id'];

    // Fetch areas based on pop_id
    $query = 'SELECT * FROM area_list WHERE pop_id = ?';
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $popID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<option>---Select---</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    } else {
        echo '<option>No areas found</option>';
    }

    $stmt->close();
    $con->close();
}

?>
