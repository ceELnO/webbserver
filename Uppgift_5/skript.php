<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error ." <br>");
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$login_success = false;
$full_name = "";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		if($row["userId"] == $_POST["username"] && $row["passwd"] == $_POST["password"]) {
			$login_success = true;
			$full_name = $row["firstname"] . " " . $row["lastname"];
		}
	}
}
else {
    echo "0 results <br>";
}

$conn->close();

// Welcome user or deklare login failure
if ($login_success == true){
	echo "Welcome ". $_POST['username'] ."!";
}
else{
	echo "login failed";
}


?>