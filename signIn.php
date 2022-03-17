<?php
session_destroy();
session_start();
function sanitize($validInput) { //function takes input and sanitizes it and makes sure there is something in it
            trim($validInput);
            stripslashes($validInput);
            htmlspecialchars($validInput);
            if (isset($validInput)) {
                if(empty($validInput)) {
                    return "Invalid Input";
                } else {
                    return $validInput;
                }
            }
        }
        
// saves all user input in super global associative array 
$_SESSION["user"] = sanitize($_POST["user"]);
$_SESSION["pass"] = sanitize($_POST["pass"]);
$dbConn;

?>

<html>
    <head>
        <title>Shipping</title>
    </head>
    <body>
        <section id="shippingForm">
            <strong><p>Sign in</p></strong>
            <form action="signIn.php" method="POST">
                Username:<input type="text" name="user"><br>
                Passwword:<input type="password" name="pass"><br>
                <input type="submit" value="Sign In">
                <p>don't have an account? <a href="signUp.php">click here</a></p>
                <p>forgot your password? click <a href="forgot.php">here</a></p>
            </form>
        </section>
        <?php 
           ob_start();
        
            $username = $_POST["user"];
            $password = md5($_POST["pass"]);
            $_SESSION["user"] = sanitize($_POST["user"]);
        
            //if ()
    
    		$user = "";
    		$DbPassword = "";
    		$hostName = "localhost";
    
            try {
                $dbConn = new PDO("mysql:host=localhost;dbname=holandre_Atticus", $user, $DbPassword);
            } catch (PDOException $e) {
                echo 'Connection error: ' . $e->getMessage();         
            } 
            $command = "SELECT id FROM User WHERE username LIKE '$username' AND password LIKE '$password'";

            $stmt = $dbConn->prepare($command);
            $execOk = $stmt->execute();
        
    
            if($execOk) { 
                while($row = $stmt->fetch()) {
                    $_SESSION["id"] = $row[id];
                    if ($_SESSION["id"] != '' and $_SESSION["id"] != null) {
                        header("Location: index.php");
                        echo "<script>window.location.replace(\"index.php\");</script>";
                        exit;
                    } else {
                        echo "Here we are";
                    }
                }              
            } else {
                echo "yes";
                //print $dbConn->errorInfo();
                print_r($stmt->errorCode());
            }
	    ?>
    </body>
</html>


