<?php
    session_start();

    // error message function
    function createAccountError($message){
        $html = file_get_contents("../html/createAccount.html");
        $header = file_get_contents("../txt/header.txt");
        $error = file_get_contents("../txt/errorbox.txt");
    
        $error = str_replace("***text_message***", $message, $error);

        $content = $header;
        $content .= $error;
    
        $html = str_replace("<!--_***PHP_Goes_Here***_-->", $content, $html);
    
        echo $html;
    }

    if ($_POST["password"] == $_POST["passwordconfirm"]){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "miniprojekt";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $sql = "SELECT username, password FROM accounts";
        $result = $conn->query($sql);
        $succes = true;
    
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($row["username"] == $_POST["username"]){
                    $succes = false;
                    break;
                }
            }
        }
        else {
            $succes = true;
        }

        $conn->close();

        if ($succes == true){
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "INSERT INTO accounts (username, password) VALUES ('$_POST[username]', '$_POST[password]')";
            
            // success
            if ($conn->query($sql) === TRUE) {
                $_SESSION["username"] = $_POST["username"];
                header("Location: forms.php");
            } 
            else {
                createAccountError("seems like we are having server issues, please try again later");
            }

            $conn->close();
        }
        else{
            createAccountError("username is taken, please choose another one");
        }
    }
    else{
        createAccountError("passwords does not match, please try again");
    }
?>