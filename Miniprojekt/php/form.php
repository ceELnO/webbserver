<?php
    $formId = $_GET['viewproduct'];

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
                    
                            <b> $row[title] </b> by <i> $row[user]</i>; $row[time] <br>
                            $row[description]
                    
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
                
                        <b> $row[title] </b> by <i> $row[user]</i> at $row[time]: &emsp; $row[description]
                
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



    $html = file_get_contents("../html/form.html");
    $header = file_get_contents("../txt/header.txt");

    $html = str_replace("<!--_***PHP_Goes_Here***_-->", $header, $html);
    $html = str_replace("<!--_***_Orgin_Entry_Goes_here_***_-->", $orginEntry, $html);
    $html = str_replace("<!--_***_Entrys_Goes_Here_***_-->", $text, $html);
    $html = str_replace("<!--_***_Value_***_-->", $tablename, $html);

    echo "$html";
?>
