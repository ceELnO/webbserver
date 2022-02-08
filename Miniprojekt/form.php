<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "miniprojekt_topic";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, title, description, user FROM forms";
        $result = $conn->query($sql);

        $therightform = $_GET['viewproduct'];

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($therightform == $row['id']){
                    echo "noice";
                }
            }
        }
        else {
            echo "error";
        }
        $conn->close();


    ?>




</body>
</html>