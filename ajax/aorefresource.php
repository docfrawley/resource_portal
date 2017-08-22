<?php require_once("../includes/initialize.php");


$params = json_decode(file_get_contents('php://input'),true);
global $database;
$whatdo = $database->escape_value($params['whatDo']);
$numid = $database->escape_value($params['numid']);
$whichview = $database->escape_value($params['whichview']);
$date = $database->escape_value($params['edate']);

$fadmin = new fpAdmin();

switch ($whatdo) {
  case 'edit':
    break;
  case 'add':
    $the_result = $fadmin->addResource($date, $whichview, $numid);
    break;
  default:
    # code...
    break;
}



$data = array(
  'success'=>$the_result
);
echo json_encode($data);

?>
