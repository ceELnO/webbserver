<?php

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
        $forms = "";
        while($row = $result->fetch_assoc()) {
            $forms .= "
                <a href='form.php?viewproduct=".urlencode($row["id"])."' class = 'form_link'>
                    <div class = 'form_container'>
                        <p>
                        
                            <b> $row[title] </b> by <i> $row[user]</i> at $row[time]: &emsp; $row[description] 
                        
                        </p>
                    </div>
                </a>
            ";
        }
    }
    else {
        $forms = "<p> seems like there are no forms, be first to create one!</p>";
    }
    $conn->close();

    $html = file_get_contents("../html/forms.html");
    $header = file_get_contents("../txt/header.txt");

    $html = str_replace("<!--_***PHP_Goes_Here***_-->", $header, $html);
    $html = str_replace("<!--_***Each_Form_Goes_Here_-->", $forms, $html);

    echo "$html";
?>