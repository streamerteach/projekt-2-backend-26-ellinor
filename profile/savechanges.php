<?php
if (isset($_POST['saveEdits'])) {
    $email = test_input($_POST['email']);
    $username = test_input($_POST['username']);
    $zip = test_input($_POST['zip']);
    $bio = test_input($_POST['bio']);
    $salary = test_input($_POST['salary']);
    $gender = $_POST['gender'];
    $preference = $_POST['preference'];
    
    $sql = "UPDATE profiles SET username =?, zipcode=?, bio =?, email =?, salary =?, preference=? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username, $zip, $bio, $email, $salary, $preference, $_SESSION['uid']]);

    header("Location: ./index.php");
    exit;
}