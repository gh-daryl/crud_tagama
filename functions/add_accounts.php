<!-- TAGAMA, JHON DARYL A. -->

<?php

include "../database/connection.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $address = $_POST['address'];
    
    if(empty($email) || empty($lastname) || empty($firstname) || empty($address)) {
        header("Location: ../index.php?error=empty_fields");
        exit();
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?error=invalid_email");
        exit();
    }
    
    $check_sql = "SELECT * FROM user_accounts WHERE email = '$email'";
    $check_result = $connection->query($check_sql);
    
    if($check_result->num_rows > 0) {
        header("Location: ../index.php?error=email_exists");
        exit();
    }

    $sql = "INSERT INTO user_accounts(email, last_name, first_name, address) VALUES('$email', '$lastname', '$firstname', '$address')";

    if($connection->query($sql) === TRUE){
        header("Location: ../index.php?success=1");
        exit();
    } else {
        header("Location: ../index.php?error=add_failed");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}

$connection->close();

?>