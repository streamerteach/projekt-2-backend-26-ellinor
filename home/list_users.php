<?php 
// funktion för massa print statements 
function printUserCards($users, $conn){
    foreach ($users as $user) {
        $loggedIn = isset($_SESSION['uid']); //true eller false
        if ($loggedIn) // länkar till profil för annonsen (för inloggade användares bruk)
            print("<a href='../profile/index.php?id=".$user["id"]."' class='user-link'>"); 

        print("<div class= 'user-list-entry'>");
        print("<img src= '".$user['profile_picture']."' class='user-list-pfp'>");
        print("<div class='text-container'><h2>".$user["realname"]."</h2>");
        print("<p>".getGender($user["gender"])."<br>");
        print("Looking for ".getPreference($user["preference"])."<br>");
        
        // mer info för inloggade
        if ($loggedIn) {
            print("Annual salary: ".$user["salary"]."€<br>");
            print("Email: ".$user["email"]."<br> </p></div>");
        }
        else
            print("Log in to see more info! <br></p></div>");

        //like
        print("<div class='like'><img src=");
        if ($loggedIn && isLikedByUser($conn, $_SESSION['uid'], $user["id"]))  // triggas endast om inloggad OCH profil är gillad
            print("'../img/like_filled.png' alt='likes:'>".$user["likes"]."</div></div>");
        else  // om inte inloggad eller inte gillad 
            print("'../img/like.png' alt='likes:'>".$user["likes"]."</div></div>");

        if ($loggedIn)
            print("</a>");
    }  
}

    // funktion för att hämta användare från databasen
function list_users($conn, $showPagination=true) {
    $loggedIn = isset($_SESSION['uid']);
    //gräns för mängd användare som visas
    $limit = 5;
    $limit = (int)$limit;

    $page = $_GET['page'] ?? 1;
    $page = max(1, (int)$page);
    $offset = ($page - 1) * $limit;
    $offset = (int)$offset;

    if ($loggedIn) {  // för inloggade användare med filtrering 
        switch ($_GET['sort'] ?? 'likes_desc') {
            case 'salary_asc': $orderBy = "salary ASC";
                break;
            case 'salary_desc': $orderBy = "salary DESC";
                break;
            case 'likes_asc': $orderBy = "likes ASC";
                break;
            default: $orderBy = "likes DESC";
        }

        $where = "";
        $params = [];
        if (isset($_GET['show-preferred'])) {
            $preference = $_SESSION['preference'];

            switch ($preference) {
                case 1: // women
                    $where = "WHERE gender = ?";
                    $params[] = 1;
                    break;
                case 2: // men
                    $where = " WHERE gender = ?";
                    $params[] = 2;
                    break;
                case 3: // both
                    $where = " WHERE gender IN (1,2)";
                    break;
                case 4: // other
                    $where = " WHERE gender = ?";
                    $params[] = 3;
                    break;
                case 5: // any
                    $where = ""; // inget gender filter
                    break;
            }
        }

        $sql = "SELECT id, username, realname, profile_picture, salary, gender, preference, likes, email 
        FROM profiles $where ORDER BY $orderBy LIMIT $limit OFFSET $offset";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else { // för icke- inloggade användare utan filtrering
        $sql = "SELECT id, username, realname, profile_picture, gender, preference, likes
        FROM profiles LIMIT $limit OFFSET $offset";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    printUserCards($users, $conn); 
    
    print("<div class='pagination'>");
    if ($page > 1) {
        print( "<a href='?page=" . ($page - 1) . "'> <img class ='arrows' src='../img/arrows_left.png' alt='Previous'></a>");
    }
    print("<span>Page $page</span>");
    print("<a href='?page=" . ($page + 1) . "'> <img class ='arrows' src='../img/arrows_right.png' alt='Next'> </a></div>");
    
    if(!$loggedIn)
        print("<p> Log in to make searches and connect! </p>");
}