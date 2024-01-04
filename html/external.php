<?php
function generateRandom($length) {
$abc = "1234567890abcdefghijklmnopqrstuvwxyz";
$randomtxt = "";
for($x = 0; $x <= $length; $x++) {
$random = rand(0, strlen($abc)-1);
$randomtxt = $randomtxt . $abc[$random];
}
return $randomtxt;
}

$datact = date("Y-m-d") . "T" . date("H:i:s");
?>
