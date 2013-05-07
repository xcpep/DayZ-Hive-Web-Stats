<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include('config.php');
if($perms['player_signature'] == false)
{
	die();
}
else
{
	header("Content-type: image/png");
	$sql = mysqli_connect($host, $user, $pass, $db);
	$uid = mysqli_real_escape_string($sql, $_GET['id']);
	$select = mysqli_query($sql, "SELECT * FROM `survivor`,`profile` WHERE `survivor`.`unique_id` = '$uid' AND `profile`.`unique_id` = '$uid'") or die(mysqli_error($sql));
	while($r = mysqli_fetch_array($select))
	{
		$humanity = $r['humanity'];
		$name = $r['name'];
		$zombies = $r['total_zombie_kills'];
	}
	$string = 'Player: '.$name;
	$human = 'Humanity: '.$humanity;
	$zombies = 'Zombie Kills: '.$zombies;
	$im = imagecreatefrompng("images/userbar.png");
	$black = imagecolorallocate($im, 255, 255, 255);
	$px = 15;
	imagestring($im, 3, $px, 7, $string, $black);
	imagestring($im, 3, $px, 22, $human, $black);
	imagestring($im, 3, $px, 37, $zombies, $black);
	imagepng($im);
	imagedestroy($im);
}
?>