<? include_once("initialize.php");

class resourceAdmin {

	private $res_array;
	private $tag;


	function __construct() {
    $this->res_array = array();
	}

	function get_titles(){
		global $database;
		$returnArray = array();
		$sql="SELECT * FROM resources WHERE doshow !='d' AND doshow !='ds' ORDER BY title";
		$result_set = $database->query($sql);
    while ($value = $database->fetch_array($result_set)) {
			$temp_array = array(
				'display'	=> $value['title'],
				'numindex'=>	$value['numid']
			);
			array_push($returnArray, $temp_array);
		}
		return $returnArray;
	}

	function get_pending(){
		global $database;
		$returnArray = array();
		$sql="SELECT * FROM resources WHERE doshow ='p' ORDER BY wupload DESC";
		$result_set = $database->query($sql);
    while ($value = $database->fetch_array($result_set)) {
			$value['wupload'] = date('m/d/y',$value['wupload']);
			$numindex = $value['who'];
			$sqlt="SELECT * FROM userlist WHERE numindex='".$numindex."'";
			$result_sett = $database->query($sqlt);
			$info = $database->fetch_array($result_sett);
			$value['who'] = $info['fname'].' '.$info['lname'];
			array_push($returnArray, $value);
		}
		return $returnArray;
	}

	function get_edit_resources($what, $numindex, $searching){
		global $database;
		$user = new userObject($numindex);
		$level = $user->get_level();
		switch ($what) {
			case 'title':
				$sql="SELECT * FROM resources WHERE title ='".$searching."'";
				break;
			case 'latest':
				$user = new userObject($numindex);
				$level = $user->get_level();
				if ($level == 'super'){
					$sql="SELECT * FROM resources WHERE doshow !='d' AND doshow != 'ds' ORDER BY wupload DESC LIMIT 20";
				} else {
					$sql="SELECT * FROM resources WHERE who = '".$numindex."' AND doshow !='d' AND doshow != 'ds' ORDER BY wupload DESC LIMIT 20";
				}
				break;
			case 'person':
				$full_name = explode(' ', $searching);
				$lname = $full_name[1];
				$sqln = "SELECT numindex FROM userlist
						WHERE lname ='".$lname."'";
				$result_setn = $database->query($sqln);
				$value = $database->fetch_array($result_setn);
				$numindex = $value['numindex'];
				$sql="SELECT * FROM resources WHERE who ='".$numindex."' AND doshow !='d' AND doshow !='ds'";
				break;
			case 'tag':
				$temp_array = $this->get_search_results($searching, 'views', 'a', $level);
				return $temp_array;
				break;
			default:
				break;
		}
		$returnArray = array();
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			$value['wupload'] = date('m/d/y',$value['wupload']);
			$numindex = $value['who'];
			$sqlt="SELECT * FROM userlist WHERE numindex='".$numindex."'";
			$result_sett = $database->query($sqlt);
			$info = $database->fetch_array($result_sett);
			$value['who'] = $info['fname'].' '.$info['lname'];
			array_push($returnArray, $value);
		}
		return $returnArray;
	}

	function latestAdditions(){
		global $database;
		$sql="SELECT * FROM resources WHERE doshow ='s' ORDER BY wupload DESC";
		$result_set = $database->query($sql);
		$returnArray = array();
		$rArray = array();
    while ($value = $database->fetch_array($result_set)) {
			array_push($rArray, $value);
		}
		for ($i=0; $i <11 ; $i++) {
			array_push($returnArray, $rArray[$i]);
		}
		return $returnArray;
	}

	function get_resources_array($what='s'){
		global $database;
		$this->res_array = array();
		switch ($what) {
			case 's':
				$sql="SELECT * FROM resources WHERE doshow ='s' ORDER BY numviews DESC";
				break;
			case 'a':
				$sql="SELECT * FROM resources WHERE doshow != 'd' AND doshow != 'ds'  ORDER BY numviews DESC";
				break;
			case 'd':
				$sql="SELECT * FROM resources WHERE doshow != 'ds'  ORDER BY numviews DESC";
				break;
			default:
				# code...
				break;
		}
		$result_set = $database->query($sql);
    while ($value = $database->fetch_array($result_set)) {
			$value['wupload'] = date('m/d/y',$value['wupload']);
			$numindex = $value['who'];
			$sqlt="SELECT * FROM userlist WHERE numindex='".$numindex."'";
			$result_sett = $database->query($sqlt);
			$info = $database->fetch_array($result_sett);
			$value['who'] = $info['fname'].' '.$info['lname'];
			array_push($this->res_array, $value);
		}
	}

	function get_resources_rankings($what='s'){
		global $database;
		$this->res_array = array();
		switch ($what) {
			case 's':
				$sql="SELECT *, (thumbsup-thumbsdown) as rank FROM resources
							WHERE doshow ='s' ORDER BY rank DESC";
				break;
			case 'a':
				$sql="SELECT *, (thumbsup-thumbsdown) as rank FROM resources
							WHERE doshow != 'd' AND doshow != 'ds' ORDER BY rank DESC";
				break;
			default:
				# code...
				break;
		}
		$result_set = $database->query($sql);
    while ($value = $database->fetch_array($result_set)) {
			$value['wupload'] = date('m/d/y',$value['wupload']);
			$numindex = $value['who'];
			$sqlt="SELECT * FROM userlist WHERE numindex='".$numindex."'";
			$result_sett = $database->query($sqlt);
			$info = $database->fetch_array($result_sett);
			$value['who'] = $info['fname'].' '.$info['lname'];
			array_push($this->res_array, $value);
		}
	}

	function tag_number($tag){
		global $database;
		$which_tag = strtolower($tag);
		$sql="SELECT * FROM tags WHERE tag='".$which_tag."'";
		$result_set = $database->query($sql);
    	$value = $database->fetch_array($result_set);
		return $value['id'];
	}

	function get_search_results($tag, $hsearch, $what='s', $inTags){
		if ($hsearch=='views'){
			$this->get_resources_array($what);
		} else {
			$this->get_resources_rankings($what);
		}
		$temp_array = array();
		$the_tag = (int)$tag;
		if ($inTags==true){
			// $tag_id = $this->tag_number($tag);
			foreach ($this->res_array as $value) {
				$tags_array = explode(',', $value['tags']);
				if (in_array($the_tag, $tags_array)){
					array_push($temp_array, $value);
				}
			}
		} else {
			$str = preg_replace('/[^a-z]/i',' ', $tag);
			// $search_array = explode(' ', $str);
			$str = strtolower($str);
			$numid_array = array();
			// foreach ($search_array as $value) {
				foreach ($this->res_array as $value) {
					$title = strtolower($value['title']);
					$description = strtolower($value['description']);
					if (strpos($title, $str) !== false
					|| strpos($description, $str)!== false){
							array_push($numid_array, $value['numid']);
							array_push($temp_array, $value);
					}
				}
			// }
		}
		
		return $temp_array;
	}

	function addResource($tags, $type, $title, $description, $link){
		global $database;
		$netid = 1;
		$doshow = 'p';
		$today = date('U');
		$sql = "INSERT INTO resources (";
	  	$sql .= "title, type_resource, description, tags, who, wupload, doshow, rlink";
	  	$sql .= ") VALUES ('";
	  	$sql .= $database->escape_value($title)  ."', '";
      $sql .= $database->escape_value($type)  ."', '";
      $sql .= $database->escape_value($description)."', '";
			$sql .= $database->escape_value($tags) ."', '";
			$sql .= $netid ."', '";
			$sql .= $today ."', '";
			$sql .= $doshow ."', '";
		  $sql .= $database->escape_value($link) ."')";
		$database->query($sql);
	}

	function addResourcePDF($info, $place){
		global $database;
		$netid = "mfrawley";
		$today = date('U');
		$sql = "INSERT INTO resources (";
	  	$sql .= "title, type_resource, description, tags, who, wupload, rlink";
	  	$sql .= ") VALUES ('";
	  	$sql .= $database->escape_value($info['title'])  ."', '";
      $sql .= $database->escape_value($info['type'])  ."', '";
      $sql .= $database->escape_value($info['description'])."', '";
			$sql .= $database->escape_value($info['tags']) ."', '";
			$sql .= $netid ."', '";
			$sql .= $today ."', '";
		  $sql .= $place ."')";
		$database->query($sql);
	}
}
?>
