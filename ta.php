<?php
function readJSONParse($fileName) {
    ini_set('mbstring.substitute_character', "none");
    return json_decode(iconv('ISO-8859-1//TRANSLIT', 'utf-8', file_get_contents($fileName)));
}

$JSON = "files/dados-certificado-autores-do-trabalho.json";
$jobs = readJSONParse($JSON);
$updates = readJSONParse("http://connepi.ifal.edu.br/2016/files/dados-certificado-autores-do-trabalho.json");
mb_internal_encoding("UTF-8");
foreach($updates as $update){
  foreach($jobs as $job){
    if($update->id == $job->id){
      $job->titulo = mb_strtoupper($update->titulo);
      $job->autores = mb_strtoupper($update->autores);
    }
  }
}
file_put_contents($JSON, json_encode($jobs));

include('header.php'); ?>
<section class="pesquisa">
  <?php
    $data = json_decode(file_get_contents($JSON));
    echo '<pre>';
    echo var_dump($data);
  ?>
</section>
<?php include('footer.php'); ?>
