<!-- TAGAMA, JHON DARYL A. -->

<?php

include "../database/connection.php";

$id = $_GET['id'];

if(isset($id)){
    $check_sql = "SELECT * FROM user_accounts WHERE account_id = $id";
    $check_result = $connection->query($check_sql);
    
    if($check_result->num_rows > 0){
        $sql = "DELETE FROM user_accounts WHERE account_id = $id";
        $delete = $connection->query($sql);
        
        if($delete === TRUE){
            header("Location: ../index.php?success=1");
            exit();
        } else {
            header("Location: ../index.php?error=delete_failed");
            exit();
        }
    } else {
        header("Location: ../index.php?error=not_found");
        exit();
    }
}

$connection->close();

?>