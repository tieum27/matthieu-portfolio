/* <?php 

mysqli_connect("localhost", "root", "");
mysqli_select_db("login");

?> */

 
 <?php 

	DEFINE ('DBUSER','root');
	DEFINE ('DBPW','');
	DEFINE ('DBHOST','localhost');
	DEFINE ('DBNAME','login');
	
	if ($dbc = mysqli_connect(DBHOST, DBUSER, DBPW))
	{
		if(!mysqli_slect_db (DBNAME))
		{
			trigger_error("Could not access<br />");
			exit();
		}
	}
	else
		{
		trigger_error("Could not connect<br />");
		exit();
		}

	function escape_data($data)
	{
		if (function_exists('mysql_real_escape_string'))
		{
			global $dbc;
			$data = mysqli_real_escape_string(trim($data), $dbc);
			$data = strip_tags($data);
		}
		else
			{
			$data = mysqli_escape_string($trim($data));
			$data = strip_tags($data);
			}
	}
			

?>