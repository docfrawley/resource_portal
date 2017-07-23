<?php include_once("../includes/initialize.php");

$taskx=isset($_GET['task']) ? $_GET['task'] : "" ;
global $database;
$task = $database->escape_value($taskx);

$fpage = new fpAdmin();
$admin = new resourceAdmin();
$users = new userAdmin();

switch ($task) {
  case 'getTitles':
    $temp_array = $admin->get_titles();
    break;
  case 'getPending':
    $temp_array = $admin->get_pending();
    break;
  case 'getEditResources':
    $what = $database->escape_value($_GET['what']);
    $numindex = $database->escape_value($_GET['numindex']);
    $searching = $database->escape_value($_GET['searching']);
    $temp_array = $admin->get_edit_resources($what, $numindex, $searching);
    break;
  case 'getUsers':
    $temp_array = $users->get_users();
    break;
  case 'getUser':
    $index = $database->escape_value($_GET['index']);
    $temp_array = $users->get_user($index);
    break;
  case 'deleteuser':
    $numindex = $database->escape_value($_GET['numindex']);
    $users->deleteuser($numindex);
    $temp_array = array(
      'success'=>$numindex
    );
    break;
  case 'netids':
    $temp_array = $users->get_netids();
    break;
  case 'getWho':
    $temp_array = $users->get_who();
    break;
  case 'frontpage':
    $temp_array = $fpage->prepare_fpage();
    break;
  case 'prompts':
    $temp_array = $fpage->get_prompts();
    break;
  case 'tags':
    $temp_array = $fpage->get_tags();
    break;
  case 'get_search':
    $how_show = $database->escape_value($_GET['what_kind']);
    $tag = $database->escape_value($_GET['tag']);
    $hsearch = $database->escape_value($_GET['hsearch']);
    $inTags = $database->escape_value($_GET['inTags']);
    $temp_array = $admin->get_search_results($tag, $hsearch, $how_show, $inTags);
    break;
  case 'deleteresource':
    $numid = $database->escape_value($_GET['numid']);
    $level = $database->escape_value($_GET['level']);
    $status = $database->escape_value($_GET['status']);
    $resource = new resObject($numid);
    $resource->deleteResource($level, $status);
    $what = $resource->get_doshow();
    $temp_array = array(
      'success'=>$what
    );
    break;
  case 'dresource':
    $numid = $database->escape_value($_GET['numid']);
    $resource = new resObject($numid);
    $resource->dResource();
    $temp_array = array(
      'success'=>$numid
    );
    break;
  default:
    # code...
    break;
};

echo json_encode($temp_array);


?>
