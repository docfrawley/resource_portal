<? include_once("initialize.php");

class userAdmin {

	private $users;
	private $tag;


	function __construct() {
    $this->users = array();
	}

	function set_array(){
		global $database;
		$sql="SELECT * FROM userlist ORDER By netid";
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
	  	$sql .= "fname, lname, netid, level";
	  	$sql .= ") VALUES ('";
	  	$sql .= $database->escape_value($info['fname']) ."', '";
      $sql .= $database->escape_value($info['lname']) ."', '";
      $sql .= $database->escape_value($info['netid']) ."', '";
		  $sql .= $database->escape_value($info['level']) ."')";
		$database->query($sql);
	}

	function update_user($info){
    global $database;
    $sql = "UPDATE userlist SET ";
		$sql .= "fname='". $database->escape_value($info['fname']) ."', ";
    $sql .= "lname='". $database->escape_value($info['lname']) ."', ";
    $sql .= "netid='". $database->escape_value($info['netid']) ."', ";
    $sql .= "title='". $database->escape_value($info['level']) ."' ";
		$sql .= "WHERE numindex='". $database->escape_value($info['numindex']). "' ";
		$database->query($sql);
	}

  function delete_user($numindex){
    global $database;
    $sql = "DELETE FROM userlist ";
      $sql .= "WHERE numindex=". $database->escape_value($numindex);
      $sql .= " LIMIT 1";
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
    $sql="SELECT * FROM userlist ORDER BY lname";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			$name = $value['fname'].' '.$value['lname'];
			$t_array = array(
				'display'			=> $name,
				'numindex'	=> $value['numindex']
			);
			array_push($returnArray, $t_array);
		}
		return $returnArray;
	}

}
?>
