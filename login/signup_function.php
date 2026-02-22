<?php
    if (!isset($_POST['signup'])) {
        return;
    }
    if (isset($_POST['signup'])) {
        $email = test_input($_POST['email']);
        $username = test_input($_POST['username']);
        $realname = test_input($_POST['realname']);
        $password = test_input($_POST['password']);
    
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql= "INSERT INTO profiles (username, realname, email, passhash) 
        VALUES (?, ?, ?, ?)";


        try {
            // förbered SQL query template
            $stmt = $conn->prepare($sql);
            // execute
            $stmt->execute([$username, $realname, $email, $hashed_password]);
        } catch (PDOException $error) {
            if ($error->getCode() == '23000') { // error kod för dubbel insert i en kolumn som kräver unika värden
                print("Username already exists");
            }
            else {
                print("Error: " . $error->getMessage());
            }
            return;
        }
        header("Location: ../login/index.php?form=login");   
}