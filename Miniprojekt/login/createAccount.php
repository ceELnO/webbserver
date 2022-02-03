<?php
    if ($_POST["password"] == $_POST["passwordconfirm"]){
        check_account();
    }
    else{
        echo "passwords does not match, please try again <br> <br>";
        include ("createAccount.html");
    }

    function check_account(){
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
            echo "error";
            include ("createAccount.html");
        }

        $conn->close();

        if ($succes == true){
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "INSERT INTO accounts (username, password) VALUES ($_POST[username], $_POST[password])";

            $conn->query($sql);
            
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
              } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }

            /*
            if(mysqli_query($conn, $sql)){
                echo "account succesfully created <br> <br>";
                include ("../forms/forms.html");
            }
            else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                include ("createAccounts.html");
            }

            $conn->close();
            */
            $conn->close();
        }
        else{
            echo "username is taken, please choose another one <br> <br>";
            include ("createAccount.html");
        }
    }
?>