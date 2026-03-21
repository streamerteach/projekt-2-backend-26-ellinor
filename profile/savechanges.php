<?php
include "../handy_methods.php";
if (isset($_POST['saveEdits'])) {
    $realName = test_input($_POST['realname']);
    $email = test_input($_POST['email']);
    $zip = test_input($_POST['zip']);
    $bio = test_input($_POST['bio']);
    $salary = test_input($_POST['salary']);
    $gender = $_POST['gender'];
    $preference = $_POST['preference'];
    
    $sql = "UPDATE profiles SET realname=?, zipcode=?, bio =?, email =?, salary =?, preference=?, gender=? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$realname, $zip, $bio, $email, $salary, $preference, $gender, $_SESSION['uid']]);

    $_SESSION["preference"]=$preference;

    header("Location: ./index.php");
    exit;
}