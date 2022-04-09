<?php
    // if: user is making a request to create a form or else: the user is viewing the html file
    if(isset($_POST["title"], $_POST["description"])){
        session_start();

        // error message function, we will need multiple error messages
        function errorbox($message){
            $html = file_get_contents("../html/createform.html");
            $header = file_get_contents("../txt/header.txt");
            $error = file_get_contents("../txt/errorbox.txt");
        
            $error = str_replace("***text_message***", $message, $error);
    
            $content = $header;
            $content .= $error;
        
            $html = str_replace("<!--_***PHP_Goes_Here***_-->", $content, $html);
        
            echo $html;
        }

        // if the user is logged in or else: not logged in
        if(isset($_SESSION['username'])){
            
            $title = $_POST["title"];
            $description = $_POST["description"];
            $theuser = $_SESSION["username"];
        
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "miniprojekt";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        
            // make a form id
            $theId = file_get_contents("../txt/id_gen.txt");
            $idid = (int)$theId;
            $idid += 1;
        
            $next_id = fopen("../txt/id_gen.txt", "w");
            fwrite($next_id, strval($idid));
            fclose($next_id);
        
            // add input to the forms database
            $sql = "INSERT INTO forms (id, title, description, user) VALUES('$theId','$title', '$description', '$theuser')";
        
            if ($conn->query($sql) === TRUE) {
        
                // create a matching table for comments
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname2 = "miniprojekt_forms";
                $conn2 = new mysqli($servername, $username, $password, $dbname2);
                
                $tableName = "T";
                $tableName .= strval($theId);
        
                $sql2 = "create table $tableName(
                    id int(16) AUTO_INCREMENT,
                    title varchar(256),
                    description varchar(1024),
                    user varchar(256),
                    time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    KEY (id)
                )";
        
                if ($conn2->query($sql2) === TRUE) {
                    // echo strval($theId);
                    // header("Location: form.php?viewproduct='".urlencode(strval($theId))."'");
                    header("Location: forms.php");
                }
                else {
                    errorbox("Error: " . $sql2 . "<br>" . $conn2->error);
                }
                $conn2->close();
            }
            else {
                errorbox("Error: " . $sql . "<br>" . $conn->error);
            }
            $conn->close();
        }
        else {
            errorbox("You are not currently logged in <br> 
            in order to post we require you to be logged in");
        }
    }
    else{
        $html = file_get_contents("../html/createform.html");
        $header = file_get_contents("../txt/header.txt");
    
        $html = str_replace("<!--_***PHP_Goes_Here***_-->", $header, $html);
        echo "$html";
    }
?>