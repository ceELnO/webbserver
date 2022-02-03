<?php
Session_start();

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
	$_SESSION["username"] = $_POST["username"];

	echo "<br> <a href = 'checklogin.php'> Inloggningsstatus </a>";

		// maybe remove this
		echo '
		<br> <br>
		<form action="upload.php" method="post" enctype="multipart/form-data">
			<lable> Select a image to upload: </lable> <br>
			<input type="file" name="fileToUpload" id="fileToUpload"> <br>
			<input type="submit" value="Upload Image" name="submit">
		</form>';

}
else{
	echo "login failed";
	echo "<br><br> <a href = 'index.php'> Inloggningssida <a>";
}

?>