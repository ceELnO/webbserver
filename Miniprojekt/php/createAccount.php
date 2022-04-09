<?php
    if (isset($_POST["password"], $_POST["passwordconfirm"], $_POST["username"])){
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

        if ($succes == true){
            if ($_POST["password"] == $_POST["passwordconfirm"]){
                // encrypt password
                $encrypted_password = openssl_encrypt($_POST["password"],"AES-128-ECB","aBHF65aBtG5");

                $conn = new mysqli($servername, $username, $password, $dbname);
                $sql = "INSERT INTO accounts (username, password) VALUES ('$_POST[username]', '$encrypted_password')";
                
                // success
                if ($conn->query($sql) === TRUE) {
                    $_SESSION["username"] = $_POST["username"];
                    header("Location: forms.php");
                } 
                else {
                    createAccountError("seems like we are having server issues, please try again later");
                }
            }
            else{
                createAccountError("passwords does not match, please try again");
            }
        }
        else{
            createAccountError("username is taken, please choose another one");
        }
        $conn->close();
    }
    else{
        $html = file_get_contents("../html/createAccount.html");
        $header = file_get_contents("../txt/header.txt");
    
        $html = str_replace("<!--_***PHP_Goes_Here***_-->", $header, $html);
    
        echo $html;
    }
?>