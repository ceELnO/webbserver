<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Inloggning med php </title>

    <!-- Externa filer -->
    <link href = "index_style.css" rel = "stylesheet" type = "text/css">

</head>
<body>

<!-- title -->
<div class = "header">

    <h1> Log in </h1>

</div>

<!-- Forum Container -->
<div class="forum_container">

    <!-- Forum-->
    <form action="welcome.php" method="POST">

        <!-- Username-->
        <label for="username"> Username: </label>
        <input required type="text" id="username" name="username" placeholder="Your Username">
        
        <br>
        
        <!-- Password -->
        <label for="password"> Password: </label>
        <input required type="text" id="password" name="password" placeholder=" Your Password ">

        <br>
        
        <!-- Submit -->
        <input type="submit" value="Submit">

    </form>

</div>

</body>
</html>