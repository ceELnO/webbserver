<?php
    // create a message if user tries to post a comment and maybe update the site
    if(isset($_POST["title"], $_POST["description"], $_POST["commented_form"])){
        session_start();
        if(isset($_SESSION["username"])){

            $title = $_POST["title"];
            $description = $_POST["description"];
            $theForm = $_POST["commented_form"];
            $theuser = $_SESSION["username"];
        
            // add entry
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "miniprojekt_forms";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        
            $sql = "INSERT INTO $theForm (title, description, user) VALUES('$title', '$description', '$theuser')";
        
            if ($conn->query($sql) === TRUE) {
                $potential_user_message = "entry added";
            }
            else {
                $potential_user_message = "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
        else{
            $potential_user_message = "you are not logged in, log in in order to post comments";
        }
    }

    // find which form we are viewing
    if(isset($_GET['viewproduct'])){
        $formId = $_GET['viewproduct'];
    }
    else if(isset($_POST["commented_form"])){
        $formId = ltrim($_POST["commented_form"], 'T');
        $formId = strval($formId);
    }
    else{
        echo "unexpected error";
        return;
    }

    // find original post
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "miniprojekt";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, title, description, user, time FROM forms";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($formId == $row['id']){
                $orginEntry = "
                    <div class = 'form_container'>
                        <p>
                    
                            <b> $row[title] </b> by <i> $row[user]</i>; $row[time]
                            <br> $row[description]
                    
                        </p>
                    </div>
                ";
                break;
            }
        }
    }
    else {
        $orginEntry = "error <br> <br>";
    }
    $conn->close();

    // find comments
    $dbname2 = "miniprojekt_forms";
    $conn2 = new mysqli($servername, $username, $password, $dbname2);
    if ($conn2->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $tablename = "T";
    $tablename .= strval($formId);

    $sql2 = "SELECT title, description, user, time FROM $tablename";
    $result2 = $conn2->query($sql2);

    if ($result2->num_rows > 0) {
        $text = "";
        while($row = $result2->fetch_assoc()) {
            $text .= "
                <div class = 'forms_container'>
                    <p>
                
                        <b> $row[title] </b> by <i> $row[user]</i> at $row[time]:
                        <br> $row[description]
                
                    </p>
                </div>
            ";
        }
    }
    else {
        $text = "
            <br>
            no comments yet, be the first one
            <br> <br>
        ";
    }
    $conn2->close();

    // echo the file to the user
    $html = file_get_contents("../html/form.html");
    $header = file_get_contents("../txt/header.txt");

    $html = str_replace("<!--_***PHP_Goes_Here***_-->", $header, $html);
    $html = str_replace("<!--_***_Orgin_Entry_Goes_here_***_-->", $orginEntry, $html);
    $html = str_replace("<!--_***_Entrys_Goes_Here_***_-->", $text, $html);
    $html = str_replace("<!--_***_Value_***_-->", $tablename, $html);

    if(isset($potential_user_message)){
        $error = file_get_contents("../txt/messagebox.txt");
        $error = str_replace("***text_message***", $potential_user_message, $error);
        $html = str_replace("<!--_***_Potential_Error_Message_***_-->", $error, $html);
    }

    echo "$html";
?>
