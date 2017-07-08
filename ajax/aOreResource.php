<?php require_once("../includes/initialize.php");


$params = json_decode(file_get_contents('php://input'),true);
$what = $params['what'];
$tags = $params['tags'];
$type = $params['type'];
$title = $params['title'];
$numid = $params['numid'];
$pdfFile = $params['pdfFile'];
$description = $params['description'];
$link = $params['link'];

if ($what=='add'){
  $resources = new resourceAdmin();
  $resources->addResource($tags, $type, $title, $description, $link);
} else {
  $resource = new resObject($numid);
  $resource->updateResource($tags, $type, $title, $description, $link, $pdfFile);
}

$data = array(
  'success'=>true
);

echo json_encode($data);

?>
