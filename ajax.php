<?php  

require_once('pdo.php');

$db = DB::init();	

if(isset($_GET['cod_grande_area'])){

	$sql = "select * from site_areas_conhecimento WHERE cod_grande_area = '{$_GET['cod_grande_area']}' ORDER BY nome_area ASC";

}elseif(isset($_GET['cod_area'])){

	$sql = "select * from site_sub_areas WHERE cod_area = '{$_GET['cod_area']}' ORDER BY nome_sub_area ASC";

}elseif(isset($_GET['cod_sub_area'])){

	$sql = "select * from site_especialidades WHERE cod_sub_area = '{$_GET['cod_sub_area']}' ORDER BY nome_especialidade ASC";

}

$response = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($response);
exit(0);

?>