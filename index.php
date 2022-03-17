<?php 
session_start();
if(isset($_SESSION['id'])) {

} else {
    echo "<script>window.location.replace(\"signIn.php\");</script>";
}

?>

<!DOCTYPE html>

<html>
    <head>
        <title>Sports Store</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <style>
        body {
            font-family: arial;
            display: grid;
            grid-row-gap: 0px;
            grid-template-columns: auto auto auto;
            background-color: #272624;
            padding: 10px;
            margin: 0px;
            overflow: scroll;
        }
        #sideBar {
            position: fixed;
            top: 0px;
            bottom: 0px;
            right: 0px;
            width: 25vw;
            background-color: #f3f3f3;
            text-align: right;
            padding: 50px;
        }
        
        #contentHolder {
            padding: 10px;
            width: 33vw;
            height: 100vw;
        }
        
        .content {
            padding: 10px;
            margin: 25px;
            background-color: #f3f3f3;
            
            border: black;
            border-style: solid;
            border-top: 0px;
            border-left: 0px;
            border-right: 0px;

        }
        
        .title, .body, .author {
            font-family: Arial;
        }
        
        .body {
            
        }
        
        .title, .author {
            background-color: #d3d3d3;
            border: black;
            border-style: solid;
            border-top: 0px;
            border-left: 0px;
            border-right: 0px;
        }
        
        #makePost input {
            
        }
        
        #formHolder {
            width 33vw;
            padding: 25px;
            text-align: center;
            height: 300px;
        }
        
        #post-body {
            width: 75%;
            height: 100px;
        }
        
        #post-title {
            width: 75%;
            height: 25px;
        }
        
        #accountInfo {
            height: 75%;
        }
        
        #searchBoxHolder {
            text-align:center;
        }
        
        #searchBox {
            padding: 15px;
            background-color: #d3d3d3;
        }
        
        
    </style>
    <body>
        <div id="sideBar">
            <div id="accountInfo">
                <h1>Account info</h1>
                	<?php 
                	
                		$user = "";
                		$DbPassword = "";
                		$hostName = "localhost";
                
                        try {
                            $dbConn = new PDO("mysql:host=localhost;dbname=holandre_Atticus", $user, $DbPassword);
                        } catch (PDOException $e) {
                            echo 'Connection error: ' . $e->getMessage();         
                        } 
                        
                        $id = $_SESSION["id"];
                        
                        $command ="SELECT * FROM User WHERE id LIKE '$id'";
                        $stmt = $dbConn->prepare($command);
                        $execOk = $stmt->execute();
                
                        if($execOk) { 
                            $row = $stmt->fetch();
                                echo 'Username: ' . $row[username] . '<br><br>' . 'Email: ' . $row[email] . "<br>" . "<br>" . 'Update Email: <form method="POST" action="changeInfo.php"><input type="hidden" name="id" value="' . $id . '"><input type="text" name="changeEmail" required><br><input type="submit" value="Change Email"></form>';
                                echo '<br>' . '<br>Change Password<br> New Password: <form method="POST" action="changeInfo.php"><input type="hidden" name="id" value="' . $id . '"><input type="password" name="changePassword" required><br>Old Password:<br><input type="password" name="currentPass" required><br><input type="submit" value="Change Password"></form>' . '<br><br>';
                                echo 'Your favourite colour: ' . $row[colour] . '<br>'  .'Update Colour: <form method="POST" action="changeInfo.php"><input type="hidden" name="id" value=' . $id . '><input type="text" name="changeFavColour"required><br><input type="submit" value="Change Favourite Colour"></form>' . '<br>';
                                
                                echo '<a href="logout.php">logout</a>';
                            
                        } else {
                            echo 'Error executing query';
                        }
                	?>
                	
            </div>
            <div id="formHolder">
    	        <form id="makePost" method="GET" action="index.php">
        	        Title: <input id="post-title" type="text" name="title"><br>
        	        Post: <textarea rows="6" cols="50" id="post-body" type="textarea" name="body"></textarea><br>
        	        <input type="submit" value="post!">
                </form>
            </div>
            <?php 
                		$user = "holandre_guest";
                		$DbPassword = "guest1admin2toor3";
                		$hostName = "localhost";
                
                        try {
                            $dbConn = new PDO("mysql:host=localhost;dbname=holandre_Atticus", $user, $DbPassword);
                        } catch (PDOException $e) {
                            echo 'Connection error: ' . $e->getMessage();         
                        } 
                        
                        $title = $_GET["title"];
                        $body = $_GET["body"];
                        $author = $_SESSION["user"];
                        
                        if (isset($title) || isset($body)) {
                            $command ="INSERT INTO `Post` (`title`, `body`, `author`) VALUES ('$title', '$body', '$author');";
                            $stmt = $dbConn->prepare($command);
                            $execOk = $stmt->execute();
                        }
                        

                ?>
    	</div>
    	<div id="searchBoxHolder">
    	    <form id="searchBox" action="index.php" method="GET">
    	        <input type="text" name="searchTerm">
    	        <input type="hidden" name="search" value="true">
    	        <input type="submit" value="search by title">
    	    </form>
    	    <form id="searchBox" action="index.php" method="GET">
    	        <input type="submit" value="filter off">
    	    </form>
    	</div>
            
    	<div id="contentHolder">
        	<?php
        	    
        	    //$command;
        	    $search = !empty($_GET["search"]);
        	    $searchTerm = $_GET["searchTerm"];

        	    
        	    if ($search == false) {
        	        $command = "SELECT * FROM `Post` ORDER BY inc DESC";
                    $stmt = $dbConn->prepare($command);
                    $execOk = $stmt->execute();
        	    } else {
        	        $command = "SELECT title, body, author FROM Post WHERE title LIKE '$searchTerm' ORDER BY inc DESC";
                    $stmt = $dbConn->prepare($command);
                    $execOk = $stmt->execute();
        	    }
        	    
    	       if($execOk) { 
    	           
                        
                    while($row = $stmt->fetch()) {
                        array_reverse($row);
                        echo '<div class="content">';
                        echo '<p class="title">Title: ' . $row[title] . '</p><br>';
                        echo '<p class="body"> ' . $row[body] . '</p><br>';
                        echo '<p class="author"> author: ' . $row[author] . '</p><br>';
                        echo '</div>';
                    }
                    
                } else {
                    echo 'Error executing following query:<br>';
                    echo "SELECT title, body, author FROM Post WHERE title LIKE '%$searchTerm%'";
                }
        	?>
        </div>

    </body>
</html>
