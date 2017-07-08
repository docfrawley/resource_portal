<? include_once("initialize.php");

class fpAdmin {

	private $fp_array;
	private $prompts;
	private $tags;

	function __construct() {
    global $database;
    $this->fp_array = array();
		$this->prompts = array();
		$this->tags = array();
    $sql="SELECT * FROM fpage";
		$result_set = $database->query($sql);
    while ($value = $database->fetch_array($result_set)) {
			array_push($this->fp_array, $value);
		}

		$sql="SELECT * FROM search_announcements";
		$result_set = $database->query($sql);
    while ($value = $database->fetch_array($result_set)) {
			array_push($this->prompts, $value);
		}

		$sql="SELECT * FROM tags ORDER BY tag";
		$result_set = $database->query($sql);
    while ($value = $database->fetch_array($result_set)) {
			$temp_array = array(
				"value"		=> strtolower($value['tag']),
				"display"	=> $value['tag'],
				"id"			=> $value['id'],
				"show" 		=> true
			);
			array_push($this->tags, $temp_array);
		}
	}

  function get_fpresource($which_one){
    global $database;
    // $today = date('m/d/Y');
    $id = 6;
    $sql="SELECT * FROM fpage WHERE wview='".$which_one."'";
    $result_set = $database->query($sql);
		$value = $database->fetch_array($result_set);
    $resource = new resObject($value['numid']);
    $title = $resource->get_title();
    $description = $resource->get_description();
    $rlink = $resource->get_rlink();
		$numviews = $resource->get_numviews();
		$thumbsup = $resource->get_thumbsup();
		$thumbsdown = $resource->get_thumbsdown();
    $temp_array = array(
      'title'       => $title,
      'description' => $description,
      'rlink'       => $rlink,
			'numviews'		=> $numviews,
			'thumbsup'		=> $thumbsup,
			'thumbsdown'	=> $thumbsdown,
			'numid'				=> $value['numid']
    );

    return $temp_array;
  }

  function prepare_fpage(){
    $profile = $this->get_fpresource('profile');
    $staff = $this->get_fpresource('staff_tip');
    $happening = $this->get_fpresource('whatshappening');
    $returnArray = array(
      'profile'   => $profile,
      'staff'     => $staff,
      'happening' => $happening
    );
    return $returnArray;
  }

	function get_prompts(){
		$returnArray = array();
		foreach ($this->prompts as $value) {
			if ($value['show_it']){
				array_push($returnArray, $value['what_say']);
			}
		}
		return $returnArray;
	}

	function get_tags(){
		return $this->tags;
	}

}
?>
