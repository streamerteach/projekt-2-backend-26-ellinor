<?php
$username = $_SESSION['username'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["upload_pfp"])) {

    $file = $_FILES['profile_picture'];
    $uploadDir = '../img/users/';

    //checka filtyp o storlek
    if ($file['type'] !== 'image/jpeg' && $file['type'] !== 'image/png') {
        print('Only JPG or PNG allowed');
        return;
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        print('File too large');
        return;
    }

    //egen mapp för varje användare
    $userDir = $uploadDir.$username;
    if (!is_dir($userDir)) {
        mkdir($userDir, 0755, true);
    }

    //räknar hur många filer som redan finns i användarens mapp 
    // för att skapa passande namn
    $existingFiles = glob($userDir.'/profile*');
    $i = count($existingFiles);

    //namnger filen 
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $path = $userDir.'/profile_'.$i.'.'.$extension;
    if($i==0){
        $path = $userDir.'/profile.'.$extension;
    }
    move_uploaded_file($file['tmp_name'], $path);

    print($path);

    header("Location: index.php");
}
?>