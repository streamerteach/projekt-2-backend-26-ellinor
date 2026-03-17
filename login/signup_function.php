<?php
    if (!isset($_POST['signup'])) {
        return;
    }
    
    $email = test_input($_POST['email']);
    $username = test_input($_POST['username']);
    $realname = test_input($_POST['realname']);
    $password = test_input($_POST['password']);
    $zip = test_input($_POST['zip']);
    $bio = test_input($_POST['bio']);
    $salary = test_input($_POST['salary']);
    $gender = $_POST['gender'];
    $preference = $_POST['preference'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql= "INSERT INTO profiles (username, realname, zipcode, bio, salary, gender, preference, email, passhash) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";


    try {
        // förbered SQL query template
        $stmt = $conn->prepare($sql);
        // execute
        $stmt->execute([$username, $realname, $zip, $bio, $salary, $gender, $preference, $email, $hashed_password]);
    } catch (PDOException $error) {
        if ($error->getCode() == '23000') { // error kod för dubbel insert i en kolumn som kräver unika värden
            print("Username already exists");
        }
        else {
            print("Error: " . $error->getMessage());
        }
        return;

    header("Location: ../login/index.php?form=login");   
    exit;
}