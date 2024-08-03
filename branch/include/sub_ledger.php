<?php

include "db_connect.php";

if(isset($_GET["add"])){
    $ledger=$_GET["ledgerId"];
    $name=$_GET["name"];
    $discription=$_GET["discription"];

    $result=$con->query("INSERT INTO legder_sub(ledger_id,item_name,description)VALUES( '$ledger','$name','$discription')");
    if ($result==true) {
        return "Data Successfully Insert";
    }else{
       return "Data Not Insert";
    }
}

// if (isset($_GET['list'])) {
//     if ($ledgr=$con->query("SELECT * FROM legder_sub")) {
//         while ($rows=$ledgr->fetch_array()) {
//             $id=$rows["ledger_id"];
//             $item_name=$rows["item_name"];
//             $description=$rows["description"];
//             echo '<tr>

//             <td>'.$item_name.'</td>
//             <td>'.$description.'</td>

//             <tr>';
//         }
//     }
// }



?>