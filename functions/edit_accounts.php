<!-- TAGAMA, JHON DARYL A. -->

<?php

include "../database/connection.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id = $_POST['id'];
    $email = $_POST['email'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $address = $_POST['address'];
    
    if(empty($id) || empty($email) || empty($lastname) || empty($firstname) || empty($address)) {
        header("Location: ../edit_screen.php?account_id=$id&error=empty_fields");
        exit();
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../edit_screen.php?account_id=$id&error=invalid_email");
        exit();
    }

    $sql = 
    "UPDATE user_accounts SET
    email = '$email',
    last_name = '$lastname',
    first_name = '$firstname',
    address = '$address'
    WHERE account_id = $id
    ";

    if($connection->query($sql) === TRUE){
        header("Location: ../index.php?success=1");
        exit();
    } else {
        header("Location: ../edit_screen.php?account_id=$id&error=update_failed");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}

$connection->close();

?>