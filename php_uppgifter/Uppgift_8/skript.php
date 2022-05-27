<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Externa files -->
    <link href = "skript.css" type = "text/css" rel = "stylesheet">
    <link href = "main.css" type = "text/css" rel = "stylesheet">

</head>
<body>
<?php
    // connect
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "web";

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

    // entry
    $name = $_POST["name"];
    $email = $_POST["email"];
    $homepage = $_POST["homepage"];
    $comment = $_POST["comment"];
    $sql = "INSERT INTO Guestbook (name, email, homepage, comment, time) VALUES ('$name', '$email', '$homepage', '$comment', now())";
    $conn->query($sql);
?>

<div class = "main_container">

    <?php
        // dispaly other entries
        $sql = "SELECT name, email, homepage, comment, time FROM Guestbook";
        $result = $conn->query($sql);

        // echo each entry
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                    <p class = 'p1'>
                        User: $row[name] <br>
                        Time: $row[time] <br>
                        Email: $row[email] <br>
                        Homepage: $row[homepage] <br>
                        Comment: <br>
                    </p>

                    <p class = 'p2'>
                            $row[comment]
                    </p>
                    <br> <br>
                ";
            }
        }
        else {
            echo "0 results";
        }
        $conn->close();
    ?>

</div>

</body>
</html>