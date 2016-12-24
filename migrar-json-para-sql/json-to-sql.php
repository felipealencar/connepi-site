<?php
$tipos = array(
  'avaliador-banner',
  'avaliador-oral',
  'participante'
);

$new_data = array();
$count_line = 0;
$count_element = 0;
foreach($tipos as $tipo)
{
  $data = json_decode(str_replace("][", ",", utf8_encode(file_get_contents("respostas-{$tipo}.txt"))));
  foreach($data as $row)
  {
    $new_data[$tipo][$count_line][$count_element] = $row;
    if($tipo == "avaliador-banner")
    {
      if(($count_element++) == 12)
      {
        $count_line++;
        $count_element = 0;
      }
    }
    elseif($tipo == "avaliador-oral")
    {
      if(($count_element++) == 13)
      {
        $count_line++;
        $count_element = 0;
      }
    }
    if($tipo == "participante")
    {
      if(($count_element++) == 9)
      {
        $count_line++;
        $count_element = 0;
      }
    }
  }
  $count_line++;
}

require_once("../pdo.php");
$db = DB::init();

foreach($new_data as $key => $value){
  foreach($value as $line){
    $sql = "INSERT INTO site_formularios (tipo, dados) VALUES (?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $key);
    $stmt->bindValue(2, json_encode($line));
    if($stmt->execute()) echo "$key migrado!<br><br>";
  }
}
?>
