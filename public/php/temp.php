<?php
$connection = mysqli_connect('localhost', 'root', '', 'mydb') or die('Connect to database'); // 1) connect to db 

if(isset($_POST['oldPass']) && isset($_POST['newPass'])) {

    if (!$user_id = $_SESSION['user_id']) return die('No User Session Found');  // 2) make sure you are logged in

    $sql = "SELECT id, password FROM tbl_user WHERE id = $user_id";

    $result = mysqli_query($connection, $sql) or die(mysqli_error($connection)); // 3) to check whether users exist or not

    $row = mysqli_fetch_array($result, MYSQLI_BOTH);

    if ($row['userPass'] == $_POST['oldPass']) { // 4) checks previous password

        $sqlUpdateQuery = "UPDATE tbl_user SET password = " . $_POST['newPass'] . " WHERE id = $user_id";

        $result = mysqli_query($connection, $sqlUpdateQuery) or die(mysqli_error($connection));

        if ($result) {
            echo "Updated!!";
        }
    }
}
?>