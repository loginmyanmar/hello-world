<!DOCTYPE html>
<html>
<body>

<?php

$var1 = '2,3';
$var2 = '1,2';
$var3 = '1,2,3,4';
$var4 = '1,2,3,4,5';

echo similar_text($var1, $var2);// 1
echo "<br>";  
echo similar_text($var1, $var3);  // 2
echo "<br>"; 
echo similar_text($var1, $var4);  // 2

echo "<br><br>";
$name = "1,2,3";
$a = explode(',',$name);
print_r($a); echo "<br>";

$str = "1,2";
echo strlen($str)."<br>"; // Using strlen() to return the string length
echo substr_count($str,"1,2,3,4")."<br>"; // The number of times "is" occurs in the string
echo substr_count($str,"1,2",2)."<br>"; // The string is now reduced to "is is nice"
echo substr_count($str,"is",3)."<br>"; // The string is now reduced to "s is nice"
echo substr_count($str,"is",3,3)."<br>"; // The string is now reduced to "s i"
?>

</body>
</html>