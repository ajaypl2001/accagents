<?php 
$rand = substr(str_shuffle("1234567890"), 0, 3);
echo $rand;
echo '<br>';
echo '<br>';

$rand1 = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1);
echo $rand1;
echo '<br>';
echo '<br>';


$rand2 = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 2);
echo $rand2;
echo '<br>';
echo '<br>';

$rand3 = substr(str_shuffle("!@#$%&*"), 0, 2);
echo $rand3;
echo '<br>';
echo '<br>';
echo '<br>';


$genreator = $rand.''.$rand1.''.$rand2.''.$rand3;
$total_rand = str_shuffle($genreator);
$total_rand1 = ('asdfghgfdsdfgh');
echo $total_rand1;
echo '<br>';
echo '<br>';
echo '<br>';
echo $password = md5(sha1($total_rand1));

echo '<br>';
echo '<br>';
echo $total_rand;
echo '<br>';
echo '<br>';
$password = md5(sha1($total_rand));
echo $password;
?>