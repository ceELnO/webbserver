<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <h1>
        very good
    </h1>

    <div class = "create_form">
        <form action = "createform.php">
            <label for = "title"> Title: </label>
            <input type = "text" name = "title">
            <br> <br>

            <label for = "description"> Description: </label>
            <input type = "textarea" name = "description">
            <br> <br>

            <input type = "submit" value = "Submit">
        </form>
    </div>

    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "miniprojekt";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, title, description, user FROM forms";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                    <a href=form.php?viewproduct=",urlencode($row["id"]),">
                        $row[title] <br>
                        $row[description] <br>
                        $row[user] <br>
                        <br> <br>
                    </a>
                ";
            }
        }
        else {
            echo "error";
        }
        $conn->close();
    ?>



</body>
</html>