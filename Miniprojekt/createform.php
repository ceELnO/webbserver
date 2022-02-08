<?php
    session_start();
    
    $title = $_POST["title"];
    $description = $_POST["description"];
    $username = $_SESSION['username'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "miniprojekt";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // add input to database
    $sql = "INSERT INTO forms (title, description, user) VALUES('$title', '$description', '$username')";
    $conn->query($sql);

    // find the id
    $sql2 = "SELECT id, title user FROM forms";
    $result = $conn->query($sql2);
    $succes = false;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($row['title'] == $_POST["title"] && $row['user'] == $_SESSION['username']){
                $formName = $row['title'];
                $succes = true;
            }
        }
    }
    else {
        echo "error";
    }

    if ($succes == false){
        echo "error";
    }
    // add a new table for the form
    else{
        $dbname2 = "miniprojekt_topic";
        $conn2 = new mysqli($servername, $username, $password, $dbname2);

        $sql3 = "CREATE TABLE $row[id] (title varchar(100), description varchar(500), user varchar(100))";
        $conn2->query($sql3);
    }






    ?>




</body>
</html>