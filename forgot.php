<html>
    <head>
        
    </head>
    <body>
        <form id="sendEmail" action="forgot.php" method="POST">
            Your username:<input type="text" name="username"><br>
            <input type="submit">
        </form>
            <?php
                
                if (isset($_POST["username"])) {
                    $username = $_POST["username"];
                    
            		$user = "holandre_guest";
        		    $DbPassword = "guest1admin2toor3";
        		    $hostName = "localhost";
        		    $ver = md5(rand());
        		    $hashedVer = md5($ver);
        
                    try {
                        $dbConn = new PDO("mysql:host=localhost;dbname=holandre_Atticus", $user, $DbPassword);
                    } catch (PDOException $e) {
                        echo 'Connection error: ' . $e->getMessage();         
                    } 
                    
                        
                    $stripedUsername = strip_tags($username);
                    $sanUsername = str_replace("'", "", $stripedUsername);
                    
                    $command = "SELECT email FROM User WHERE username LIKE '$sanUsername';";
                    
    
                    $stmt = $dbConn->prepare($command);
                    $execOk = $stmt->execute();
                    $row = $stmt->fetch();
                    
                    $_POST["email"] = $row[email];
                    $_POST["obs"] = md5($row[email]);
                    
                    
                    $command = "UPDATE User SET ver = '$hashedVer' WHERE email LIKE '$row[email]';";
                    $stmt = $dbConn->prepare($command);
                    $execOk = $stmt->execute();
                    
                    if ($execOk) {
                        $row = $stmt->fetch();
                        
                        $_POST["ver"] = $ver;
                        
                        //echo '<script>window.location.replace(\"http://jolly-corp.com/forgot.php\");</script>';
                        echo '<form id="relay" method="POST" action="http://jolly-corp.com/forgot.php"><input type="hidden" name="email" value=' . $_POST["email"] . '><input type="hidden" name="obs" value=' . $_POST["obs"] . '><input type="hidden" name="ver" value=' . $_POST["ver"] . '></form>';
                        echo '<script type="text/javascript"> document.getElementById("relay").submit(); </script>';
                        echo "her";
                        // echo '<input type="hidden" name="obs" value=$_POST["obs"]';
                        // echo '<input type="hidden" name="obs" value=$_POST["obs"]';
                        // echo '<input type="hidden" name="obs" value=$_POST["obs"]';
                    } else {
                        echo "<script>window.location.replace(\"forgot.php\");</script>";
                    }

                }
            ?>
        
        <p>Back to <a href="signIn.php">sign in</a></p>
    </body>
</html>