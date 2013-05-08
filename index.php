<?php
include('config.php');
include('core.php');
$core = new Core();
?>
<html>
<head>
  <title>DayZ Hive Stats</title>
	<link href="style.css" rel="stylesheet"/>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="tablesorter.min.js"></script>
	<script>
	$(document).ready(function() { 
        $("#stats").tablesorter(); 
    }); 
    </script>
</head>
<body>
<?php
if($perms['server_status'] === true)
{
	$core->server_status();
}
$core->player_stats();
?>
</body>
</html>
