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
    $today = microtime(true);
		$tempa = array();
    $sql="SELECT * FROM fpage WHERE wview='".$which_one."'
					AND start_show<='".$today."' ORDER BY start_show DESC";
    $result_set = $database->query($sql);
		while ($info = $database->fetch_array($result_set)) {
			array_push($tempa, $info);
		};
		$value = $tempa[0];
    $resource = new resObject($value['numid']);
    $title = $resource->get_title();
    $description = $resource->get_description();
    $rlink = $resource->get_rlink();
		$numviews = $resource->get_numviews();
		$thumbsup = $resource->get_thumbsup();
		$thumbsdown = $resource->get_thumbsdown();
    $temp_array = array(
      'title'       => $which_one,
      'description' => $description,
      'rlink'       => $rlink,
			'numviews'		=> $numviews,
			'thumbsup'		=> $thumbsup,
			'thumbsdown'	=> $thumbsdown,
			'numid'				=> $value['numid']
    );

    return $temp_array;
  }

	function get_FpageResource($numid){
		global $database;
    $sql="SELECT * FROM fpage WHERE numid='".$numid."'";
    $result_set = $database->query($sql);
		$info = $database->fetch_array($result_set);
		$year = date('Y', $info['start_show']);
		$month = date('m', $info['start_show']);
		$day = date('d', $info['start_show']);
		$returnArray = array (
			'year' => $year,
			'month' => $month,
			'day'		=> $day,
			'wview' => $info['wview']
		);
		return $returnArray;
	}

  function prepare_fpage(){
    $inspiration = $this->get_fpresource('inspiration');
    $advice = $this->get_fpresource('advice');
    $opportunities = $this->get_fpresource('opportunities');
    $returnArray = array(
      'inspiration'   => $inspiration,
      'advice'     => $advice,
      'opportunities' => $opportunities
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

	function get_dateset($which_type, $color){
		global $database;
		$sql="SELECT * FROM fpage WHERE wview='".$which_type."'";
		$result_set = $database->query($sql);
		$dates_array = array();
    while ($value = $database->fetch_array($result_set)) {
			$event = new resObject($value['numid']);
			$calendar = date('Y-m-d', $value['start_show']);
			$date_array = array(
				'title' => $event->get_title(),
				'start' => $calendar,
				'numid' => $value['numid']
			);
			array_push($dates_array, $date_array);
		}
		$returnArray = array(
			'events' 		=> $dates_array,
			'color'			=> $color
		);
		return $returnArray;
	}

	function get_dates(){
		$inspiration = $this->get_dateset('inspiration', 'red');
		$advice = $this->get_dateset('advice', 'blue');
		$opportunities = $this->get_dateset('opportunities', 'green');
		$returningArray = array();
		array_push($returningArray, $inspiration);
		array_push($returningArray, $advice);
		array_push($returningArray, $opportunities);
		return $returningArray;
	}

	function editResource($edate){
		// $themonth = intval($month);
		// $theday = intval($day);
		// $theyear = intval($year);
		// $date = mktime(0,0,0,$themonth,$theday,$theyear);
		$whatbecomes = $date->format('u');
		$thearray = array(
			'becomes' => $day
		);
		return $year;
	}

	function addResource($adate, $wview, $title){
		global $database;
		$sql="SELECT * FROM resources WHERE title='".$title."'";
		$result_set = $database->query($sql);
		$value = $database->fetch_array($result_set);
		$numid = $value['numid'];
		$tdate = (int)$adate;

		$sql = "INSERT INTO fpage (";
	  	$sql .= "numid, wview, start_show";
	  	$sql .= ") VALUES ('";
	  	$sql .= $numid  ."', '";
      $sql .= $wview  ."', '";
      $sql .= $tdate ."')";
		$database->query($sql);

		$tarray = array(
			'numid' => $numid,
			'wview' => $wview,
			'date' => $tdate
		);
		return $tarray;
	}

}
?>
