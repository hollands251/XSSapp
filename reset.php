<html>
    <head>
        
    </head>
    <body>
        <?php
            echo $_POST["message"];
        ?>
        <form action="reset.php" method="POST">
            verification code:<input type="text" name="ver"><br>
            new Password:<input type="password" name="newPass"><br>
            confirm new password<input type="password" name="confirmNewPass"><br>
            <input type="submit" value="change password">
        </form>
        <p>back to <a href="signIn.php">sign in</a></p>
        <?php
            if (isset($_POST[confirmNewPass]) && isset($_POST[newPass]) && (strcmp($_POST[confirmNewPass], $_POST[newPass]) == 0)) {
                $username = $_POST["username"];
                    
            		$user = "";
        		    $DbPassword = "";
        		    $hostName = "localhost";
        
                    try {
                        $dbConn = new PDO("mysql:host=localhost;dbname=holandre_Atticus", $user, $DbPassword);
                    } catch (PDOException $e) {
                        echo 'Connection error: ' . $e->getMessage();         
                    } 
                    
                    $newPass = md5($_POST[confirmNewPass]);
                    
                    $command = "UPDATE User SET password = '$newPass' WHERE ver = '$_POST[ver]' ";
    
                    $stmt = $dbConn->prepare($command);
                    $execOk = $stmt->execute();
                    
                    $row = $stmt->fetch();
                    if(sizeof($row) > 1) {
         
                    } else if (isset($username))  {
                        echo "error updating password";
                    }
            }
        ?>
    </body>
</html>
