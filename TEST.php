<?php

$i = 0;
$x = array("a" => "def", "2" => "abc");
foreach($x as $k => $v) {
 $x[$i] = $v;
 array_splice($x, 0, 0);
 $i++;
}
var_dump($x);
echo "<br/>";
sort($x);
var_dump($x);

?>