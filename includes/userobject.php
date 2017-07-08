<? include_once("initialize.php");

class userObject {

	private $fname;
	private $lname;
  private $netid;
  private $level;
  private $resources;
  private $numindex;


	function __construct($numid) {
    global $database;
    $this->resources = array();
    $sql="SELECT * FROM userlist WHERE numindex='".$numid."'";
		$result_set = $database->query($sql);
    $value = $database->fetch_array($result_set);
		$this->fname = $value['fname'];
    $this->lname = $value['lname'];
    $this->netid = $value['netid'];
    $this->level = $value['level'];
    $this->numindex = $numid;
	}

  function get_netid(){
    return $this->netid;
  }

	function get_numindex(){
    return $this->numindex;
  }

  function get_fname(){
    return $this->fname;
  }

  function get_lname(){
    return $this->lname;
  }

	function get_fullName(){
    return $this->fname.' '.$this->lname;
  }

  function get_level(){
    return $this->level;
  }

	// function set_resources(){
	// 	global $database;
	// 	$sql="SELECT * FROM resources WHERE who='".$this->numindex."' ORDER BY title";
	// 	$result_set = $database->query($sql);
	// 	while ($value = $database->fetch_array($result_set)) {
	// 		$value['wupload'] = date('m/d/y',$value['wupload']);
	// 		$value['who'] = $this->fname.' '.$this->lname;
	// 		array_push($this->resources, $value);
  //   }
	// }

  function get_resources(){
    $this->set_resources();
    return $this->resources;
  }

}
?>
