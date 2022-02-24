<?php
    $html = file_get_contents("../html/createAccount.html");
    $header = file_get_contents("../txt/header.txt");

    $html = str_replace("<!--_***PHP_Goes_Here***_-->", $header, $html);

    echo $html;
?>