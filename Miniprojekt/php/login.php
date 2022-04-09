<?php
    if(isset($_POST["username"], $_POST["password"])){
        session_start();
    
        // error message function
        function errorMessage($message){
            $html = file_get_contents("../html/login.html");
            $header = file_get_contents("../txt/header.txt");
            $error = file_get_contents("../txt/errorbox.txt");
        
            $error = str_replace("***text_message***", $message, $error);
    
            $content = $header;
            $content .= $error;
        
            $html = str_replace("<!--_***PHP_Goes_Here***_-->", $content, $html);
        
            echo $html;
        }
    
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
        $loginsucces = 3; //  1: succes; 2: wrong password; 3: no accounts with that username; 
    
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($row["username"] == $_POST["username"]){
                    $encrypted_password = openssl_encrypt($_POST["password"],"AES-128-ECB","aBHF65aBtG5");
                    if ($row["password"] == $encrypted_password){
                        $loginsucces = 1;
                        break;
                    }
                    else{
                        $loginsucces = 2;
                        break;
                    }
    
                }
            }
        }
        else {
            echo "error";
        }
        $conn->close();
    
        // successful login --> show forms
        if ($loginsucces == 1){
            $_SESSION["username"] = $_POST["username"];
            header("Location: forms.php");        
        }
        // wrong password
        else if ($loginsucces == 2){
            errorMessage("Accounts exists, however, passwords does not match");
        }
        // account does not exist
        else{
            errorMessage("Account does not exist");
        }
    }
    else{
        $html = file_get_contents("../html/login.html");
        $header = file_get_contents("../txt/header.txt");
    
    
        $html = str_replace("<!--_***PHP_Goes_Here***_-->", $header, $html);
        echo "$html";
    }
?>