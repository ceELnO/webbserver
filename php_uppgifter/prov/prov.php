<?php
$html = file_get_contents("table.html");
$text_array = explode("***PHP***", $html);
echo $text_array[0];

$huvudstader = array("1" => "2", "3" => "4", "5" => "6", "7" => "8", "9" => "10");

foreach($huvudstader as $x => $x_value){
    $text = str_replace("***country***", $x,$text_array[1]);
    $text = str_replace("***capital***", $x_value, $text);
    echo $text;
}

echo $text_array_[2];

?>