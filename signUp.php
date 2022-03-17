<?php
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
    
    function createId() {
        
        $randStr = array("apple", "orange", "vienna", "blind", "geography");
        $randInt1 = rand();
        $randInt2 = rand();
        $toDigest = $randInt1 . $randStr . $randInt2;
        $digest = md5($toDigest);
        
        return $digest;
        
    }
        

?>

<html>
    <head>
        <title>Shipping</title>
    </head>
    <body>
        <strong><p>Sign in</p></strong>
        <form action="signUp.php" method="POST">
            Set Username:<input type="text" name="user"><br>
            Set Password:<input type="password" name="pass"><br>
            Your Email:<input type="text" name="email" pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$"><br>
            <input type="submit" value="Sign In">
        </form>
        <?php 
        
    
    		$user = "";
    		$DbPassword = "";
    		$hostName = "localhost";
    		
    		$username = sanitize($_POST["user"]);
    		$email = sanitize($_POST["email"]);
    		$pass = md5($_POST["pass"]);
    		$id = createId();
    		
    
            try {
                $dbConn = new PDO("mysql:host=localhost;dbname=holandre_Atticus", $user, $DbPassword);
            } catch (PDOException $e) {
                echo 'Connection error: ' . $e->getMessage();         
            }
            
            if (isset($username) and isset($pass)) {
                session_start();
                $_SESSION["id"] = $id;
                echo "running";
                $command ="INSERT INTO User (username, password, colour, email, id, ver) VALUES ('$username', '$pass', '', '$email', '$id', '');";
                $stmt = $dbConn->prepare($command);
                $execOk = $stmt->execute();
                echo "<script>window.location.replace(\"index.php\");</script>";
            }
            

    
            // if($execOk) { 
            //     while($row = $stmt->fetch()) {
            //         echo 'Item: ' . $row[name] . '<br>'; 
            //     }              
            // } else {
            //     echo 'Error executing query';
            // }
	    ?>
    </body>
</html>

