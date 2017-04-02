<?php
function readJSONParse($fileName) {
    ini_set('mbstring.substitute_character', "none");
    return json_decode(iconv('ISO-8859-1//TRANSLIT', 'utf-8', file_get_contents($fileName)));
}

// require('pdo.php');
// $db = DB::init();
// $sql = "SELECT paper_id, setting_value FROM paper_settings WHERE setting_name = 'abstract' AND (paper_id = 12195 OR paper_id = 11880 OR paper_id = 11044 OR paper_id = 10961 OR paper_id = 10920 OR paper_id = 10751 OR paper_id = 10617 OR paper_id = 10592 OR paper_id = 10308 OR paper_id = 9355 OR paper_id = 9292 OR paper_id = 9183 OR paper_id = 9128 OR paper_id = 9120 OR paper_id = 9119 OR paper_id = 9035 OR paper_id = 8987 OR paper_id = 8903 OR paper_id = 8719 OR paper_id = 8680 OR paper_id = 8227 OR paper_id = 8139 OR paper_id = 8123 OR paper_id = 8072 OR paper_id = 7832 OR paper_id = 7809 OR paper_id = 7785 OR paper_id = 7679 OR paper_id = 7665 OR paper_id = 7563 OR paper_id = 7515 OR paper_id = 7346 OR paper_id = 7327 OR paper_id = 7292 OR paper_id = 7226 OR paper_id = 7179 OR paper_id = 7065 OR paper_id = 6931 OR paper_id = 6890 OR paper_id = 6869 OR paper_id = 6851 OR paper_id = 6756 OR paper_id = 6753 OR paper_id = 6741 OR paper_id = 6726 OR paper_id = 6715 OR paper_id = 6670 OR paper_id = 6642 OR paper_id = 6641 OR paper_id = 6623 OR paper_id = 6606 OR paper_id = 6571 OR paper_id = 6569 OR paper_id = 6559)";
//
// $abstracts = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);


$abstracts = readJSONParse("files/resumo-trabalhos-premiados.json");
$JSONUrl = "files/dados-certificado-autores-do-trabalho.json";
$jobs = readJSONParse($JSONUrl);
$out = array();
$search = ['RESUMO:'];
$replace = [''];
foreach($jobs as $job){
  foreach($abstracts as $abstract){
    if($job->id == $abstract->id){
      $job->abstract = trim(trim(str_replace($search, '', strip_tags($abstract->abstract))));
    }
  }
}
file_put_contents($JSONUrl, json_encode($jobs));

include('header.php'); ?>
<section class="pesquisa">
  <?php
    $data = json_decode(file_get_contents($JSONUrl));
    echo '<pre>';
    echo var_dump($data);
  ?>
</section>
<?php include('footer.php'); ?>
