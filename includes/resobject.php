<? include_once("initialize.php");

class resObject {

	private $title;
  private $description;
  private $who;
  private $wupload;
  private $rlink;
  private $lview;
  private $numviews;
	private $numid;
	private $thumbsup;
	private $thumbsdown;
	private $doshow;


	function __construct($numid) {
    global $database;
    $sql="SELECT * FROM resources WHERE numid='".$numid."'";
		$result_set = $database->query($sql);
    $value = $database->fetch_array($result_set);
		$this->numid = $numid;
		$this->title = $value['title'];
    $this->description = $value['description'];
    $this->who = $value['who'];
		$this->wupload = date('m/d/y',$value['wupload']);
    $this->rlink = $value['rlink'];
    $this->lview = $value['lview'];
    $this->numviews = $value['numviews'];
		$this->thumbsup = $value['thumbsup'];
    $this->thumbsdown = $value['thumbsdown'];
		$this->doshow = $value['doshow'];
	}

	function get_title(){
    return $this->title;
  }

  function get_description(){
    return $this->description;
  }

  function get_who(){
    return $this->who;
  }

  function get_wupload(){
    return $this->wupload;
  }

	function get_rlink(){
    return $this->rlink;
  }

	function get_lview(){
    return $this->lview;
  }

	function get_thumbsup(){
    return $this->thumbsup;
  }

	function get_thumbsdown(){
    return $this->thumbsdown;
  }

	function get_numviews(){
    return $this->numviews;
  }

	function get_doshow(){
		return $this->doshow;
	}

	function addOne($what = 'numviews', $pressed = 'free'){
		global $database;
		$today = date('U');
		$sql = "UPDATE resources SET ";
		switch ($what) {
			case 'numviews':
				$this->numviews++;
				$sql .= "lview='". $today ."', ";
				$sql .= "numviews='". $this->numviews ."' ";
				break;
			case 'thumbsup':
				if ($pressed=='thumbsup'){
					$this->thumbsup--;
				} elseif ($pressed=='thumbsdown') {
					$this->thumbsup++;
					$this->thumbsdown--;

				} else{
					$this->thumbsup++;
				}
				break;
			case 'thumbsdown':
			if ($pressed=='thumbsdown'){
				$this->thumbsdown--;
			} elseif ($pressed=='thumbsup') {
				$this->thumbsup--;
				$this->thumbsdown++;
			} else{
				$this->thumbsdown++;
			}
				break;
			default:
				break;
		};

		if ($what !='numviews'){
			$sql .= "thumbsup='". $this->thumbsup ."', ";
			$sql .= "thumbsdown='". $this->thumbsdown ."' ";
		}

		$sql .= "WHERE numid='". $this->numid. "' ";
		$database->query($sql);
	}

	function deleteResource($level, $status){
		global $database;
		if ($level=='super'){
			$this->doshow = ($status=='delete') ? 'ds' : 'ps';
		} else {
			if ($this->doshow=='p'){
				$this->doshow= 'd';
			}
		}
		$sql = "UPDATE resources SET ";
		$sql .= "doshow='". $this->doshow ."' ";
		$sql .= "WHERE numid='". $this->numid. "' ";
		$database->query($sql);
	}

	function updateResource($tags, $type, $title, $description, $link, $pdfFile){
		global $database;
		$sql = "UPDATE resources SET ";
		$sql .= "title='". $database->escape_value($title) ."', ";
		$sql .= "type_resource='". $database->escape_value($type) ."', ";
		$sql .= "description='". $database->escape_value($description) ."', ";
		$sql .= "rlink='". $database->escape_value($link) ."', ";
		$sql .= "tags='". $database->escape_value($tags) ."', ";
		$sql .= "doshow='p' ";
		$sql .= "WHERE numid='". $this->numid . "' ";
		$database->query($sql);
	}

}
?>
