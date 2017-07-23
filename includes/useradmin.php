<? include_once("initialize.php");

class userAdmin {

	private $users;


	function __construct() {
    $this->users = array();
	}

	function set_array(){
		global $database;
		$sql="SELECT * FROM userlist ORDER By lname";
		$result_set = $database->query($sql);
    while ($value = $database->fetch_array($result_set)) {
			array_push($this->users, $value);
		}
	}

	function get_who(){
		$user = new userObject(1);
		$returnArray = array(
			'netid' 		=> $user->get_netid(),
			'numindex' 	=> $user->get_numindex(),
			'fname'			=> $user->get_fname(),
			'lname'			=> $user->get_lname(),
			'level'			=> $user->get_level()
		);
		return $returnArray;
	}

	function add_user($info){
		global $database;
    $sql = "INSERT INTO userlist (";
	  	$sql .= "fname, lname, netid, level, current, webhook";
	  	$sql .= ") VALUES ('";
	  	$sql .= $database->escape_value($info['fname']) ."', '";
      $sql .= $database->escape_value($info['lname']) ."', '";
      $sql .= $database->escape_value($info['netid']) ."', '";
			$sql .= $database->escape_value($info['level']) ."', '";
			$sql .= $database->escape_value($info['current']) ."', '";
		  $sql .= $database->escape_value($info['webhook']) ."')";
		$database->query($sql);
	}

	function updateUser($fname, $lname, $netid, $level, $current, $webhook){
		global $database;

		$sql = "UPDATE userlist SET ";
		$sql .= "fname='". $database->escape_value($fname) ."', ";
		$sql .= "lname='". $database->escape_value($lname) ."', ";
		$sql .= "netid='". $database->escape_value($netid) ."', ";
		$sql .= "level='". $database->escape_value($level) ."', ";
		$sql .= "current='". $database->escape_value($current) ."', ";
		$sql .= "webhook='". $database->escape_value($webhook) ."' ";
		$sql .= "WHERE numid='". $this->numindex . "' ";
		$database->query($sql);
	}

  function deleteuser($numindex){
    global $database;
		$current = false;
		$sql = "UPDATE userlist SET ";
		$sql .= "current='0' ";
		$sql .= "WHERE numindex='". $numindex . "' ";
		$database->query($sql);
	}

  function get_users_list(){
    global $database;
    $returnArray = array();
    $sql="SELECT * FROM userlist ORDER BY lname";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			array_push($returnArray, $value);
		}
		return $returnArray;
  }

  function get_netids(){
    global $database;
    $returnArray = array();
    $sql="SELECT netid FROM userlist ORDER BY netid";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			array_push($returnArray, $value);
		}
		return $returnArray;
  }

	function get_users(){
		global $database;
    $returnArray = array();
    $sql="SELECT * FROM userlist WHERE current = 1 ORDER BY lname";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			$name = $value['fname'].' '.$value['lname'];
			$t_array = array(
				'display'		=> $name,
				'level'			=> $value['level'],
				'numindex'	=> $value['numindex']
			);
			array_push($returnArray, $t_array);
		}
		return $returnArray;
	}

	function get_user($index=1) {
		global $database;
    $sql="SELECT * FROM userlist WHERE numindex = '".$index."'";
		$result_set = $database->query($sql);
		$value = $database->fetch_array($result_set);
		return $value;
	}

}
?>
