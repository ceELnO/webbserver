<?php
Session_start();
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<!-- Form -->
<form action="skript.php" method="post">
    Username:<br>
    <input type="text" name="username"> <br>

    Password: <br>
    <input type="password" name="password"> <br>
    
    <input type="submit" value="Logga in">
</form>

<br>

<!-- Logga ut -->
<form action="index.php" method="post">
    <input type="submit" name="someAction" value="Logga ut" />
</form>

<br>

<a href = "checklogin.php"> Inloggningsstatus </a>

</body>
</html>
<!-- php logga ut -->
<?php
function func(){
    session_destroy();
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['someAction'])){
    func();
}
?>