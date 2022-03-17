<?php 
session_start();

?>

<?php 
            $id = $_POST["id"];
    		$user = "";
    		$DbPassword = "";
    		$hostName = "localhost";
    		
            try {
                $dbConn = new PDO("mysql:host=localhost;dbname=holandre_Atticus", $user, $DbPassword);
            } catch (PDOException $e) {
                echo 'Connection error: ' . $e->getMessage();         
            } 
            
            if (isset($_POST["changeFavColour"])) {
                
                $changeFavColour = $_POST["changeFavColour"];
                $command = "UPDATE User SET colour = '$changeFavColour' WHERE id LIKE '$id'";
                
                $stmt = $dbConn->prepare($command);
                $execOk = $stmt->execute();
                
            } else if (isset($_POST["changeEmail"])) {
                
                $changeEmail = $_POST["changeEmail"];
                $command = "UPDATE User SET email = '$changeEmail' WHERE id LIKE '$id'";
                
                $stmt = $dbConn->prepare($command);
                $execOk = $stmt->execute();
                
            } else {
            
        
    
                
                $command = "SELECT password FROM User WHERE id LIKE '$id'";
                $stmt = $dbConn->prepare($command);
                $execOk = $stmt->execute();
                
                $row = $stmt->fetch();
                $storedPass = $row[password];
                
                
                if (isset($_POST["changePassword"]) and isset($_POST["currentPass"])) {
                    $changePassword = md5($_POST["changePassword"]);
                    $currentPass = md5($_POST["currentPass"]);
                        
                        // hash passwword here
                        if ( strcmp( $currentPass, $storedPass ) == 0 ) {
                            $command = "UPDATE User SET password = '$changePassword' WHERE id LIKE '$id'";
                            $stmt = $dbConn->prepare($command);
                            $execOk = $stmt->execute();
                        }
                }
            }
            echo "<script>window.location.replace(\"index.php\");</script>";
	    ?>