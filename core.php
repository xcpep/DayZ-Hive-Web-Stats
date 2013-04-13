<?php

class Core {

  /*
	 * @sql;
	 * Holds the MySQL database connection.
	*/	
	private $sql;

	/*
	 * @perms;
	 * Holds all of the permission settings in an array.
	*/
	private $perms;

	// This is the first function run when the class is declared.
	public function __construct()
	{
		include('config.php');
		$this->perms = $perms;
		$this->ip = $server_ip;
		$this->port = $server_port;
		$this->sql = mysqli_connect($host, $user, $pass, $db);
	}

	// Last function run before ending script.
	public function __destruct()
	{

	}
	
	// User stats for the user image
	public function user_status($uid)
	{
		$id = mysqli_real_escape_string($this->sql, "$uid");
		$select = mysqli_query($this->sql, "SELECT * FROM `survivor` WHERE `unique_id` = '$id'");
		while($r = mysqli_fetch_array($query))
		{
		}
	}

	// Game Tracker server status image.
	public function server_status()
	{
		$url = '';
		$url .= 'http://www.gametracker.com/server_info/';
		$url .= $this->ip.':'.$this->port;
		$url .= '/banner_560x95.png';
		$img = '<div class="status"><img src="'.$url.'" align="center"/></div>';
		echo $img;
	}

	// Player stats page.
	public function player_stats()
	{
		$select = mysqli_query($this->sql, "SELECT `id`,`unique_id`,`is_dead`,`survivor_kills`,`bandit_kills`,`zombie_kills`,`headshots`,`survival_time`,`last_updated` FROM `survivor`;");
		echo('<table width="960px" id="stats" class="tablesorter" border="0" cellspacing="0" align="center">');
		echo('<thead><tr>');
		echo('	<th>ID</th>');
		echo('	<th>Username</th>');
		echo('	<th>Alive?</th>');
		echo('	<th>Survivor Kills</th>');
		echo('	<th>Bandit Kills</th>');
		echo('	<th>Zombie Kills</th>');
		echo('	<th>Headshots</th>');
		echo('	<th>Survival Time</th>');
		echo('	<th>Last Updated</th>');
		echo('</tr></thead><tbody>');
		while($r = mysqli_fetch_array($select, MYSQLI_ASSOC))
		{ 
			echo('<tr class="row">');
			echo('	<td>'.$r['id'].'</td>');
			echo('	<td>'.$this->get_username($r['unique_id']).'</td>');
			echo('	<td>'.$this->dead($r['is_dead']).'</td>');
			echo('	<td>'.$r['survivor_kills'].'</td>');
			echo('	<td>'.$r['bandit_kills'].'</td>');
			echo('	<td>'.$r['zombie_kills'].'</td>');
			echo('	<td>'.$r['headshots'].'</td>');
			echo('	<td>'.$this->time_format($r['survival_time']).'</td>');
			echo('	<td>'.$r['last_updated'].'</td>');
			echo('</tr>');
		}
		echo('</tbody></table>');
	}

	public function dead($a)
	{
		if($a == '1')
		{
			return 'No';
		}
		else
		{
			return 'Yes';
		}
	}

	public function time_format($time)
	{
		$time = abs($time);
		return sprintf("%d:%02d", floor($time/60), $time%60);
	}

	public function get_username($id)
	{
		$id = mysqli_real_escape_string($this->sql, $id);
		$select = mysqli_query($this->sql, "SELECT * FROM `profile` WHERE `unique_id` = '$id' LIMIT 1;");
		while($r = mysqli_fetch_array($select, MYSQLI_ASSOC))
		{
			return $r['name'];
		}
	}

}
