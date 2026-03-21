<?php 
    // funktion för att hämta användare från databasen
    function list_users($conn) {
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
                        $where = "WHERE gender = ?";
                        $params[] = 2;
                        break;
                    case 3: // both
                        $where = "WHERE gender IN (1,2)";
                        break;
                    case 4: // other
                        $where = "WHERE gender = ?";
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

            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else{ // för icke- inloggade användare utan filtrering
            $sql = "SELECT id, username, realname, profile_picture, gender, preference, likes
            FROM profiles LIMIT $limit OFFSET $offset";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        printUserCards($users, $conn); // från handy_methods för o gömma massa fula print statements här

        print("<div class='pagination'>");
        if ($page > 1) {
            print( "<a href='?page=" . ($page - 1) . "'>Previous</a>");
        }
        print("<span>Page $page</span>");
        print("<a href='?page=" . ($page + 1) . "'>Next</a>");
        print("</div>");
    }