<?php

$json_url = "files/dados-certificado-autores-do-trabalho.json";
$data = readJSONParse($json_url);
function readJSONParse($fileName) {
    ini_set('mbstring.substitute_character', "none");
    return json_decode(iconv('ISO-8859-1//TRANSLIT', 'utf-8', file_get_contents($fileName)));
    // return json_decode(mb_convert_encoding(file_get_contents(), 'UTF-8', 'UTF-8'), true);
}
function writeJSONParse($fileName, $data){
  return (file_put_contents($fileName, json_encode($data))) ? true : false;
}

if(isset($_POST['id'])){

  $erros = array();
  $sucessos = array();
  $inserindo = false;
  $atualizando = false;

  $id = $_POST['id'];
  $titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : false;
  $autores = (isset($_POST['autores'])) ? $_POST['autores'] : false;

  foreach($data as $trabalho){
    if(strval($trabalho->id) == strval($id)){
      $trabalho->titulo = ($titulo !== false) ? $titulo : $trabalho->titulo;
      $trabalho->autores = ($autores !== false) ? $autores : $trabalho->autores;
      $atualizando = true;
      $sucessos[] = "<b>Dados atualizado</b><hr/><b>ID</b><br>{$id}<br><br><b>Título</b><br>{$titulo}<br><br><b>Autores</b><br>{$autores}";
      break;
    }
  }

  if($atualizando !== true){
    if($id && $titulo && $autores) $data[] = array('id' => $id, 'titulo' => $titulo, 'autores' => $autores);
    else $erros[] = "Há campo(s) em branco!";
  }

  if(count($erros) <= 0){
    // Atualiza o .json
    // (independente de atualizar ou inserir dados)
    if(writeJSONParse($json_url, $data)) $sucessos[] = "<b>Dados inserido</b><hr/><b>ID</b><br>{$id}<br><br><b>Título</b><br>{$titulo}<br><br><b>Autores</b><br>{$autores}";
    else $erros[] = "Falha ao salvar o JSON";
  }
}
 ?>

<style media="screen">
  .form-control { margin-top: 15px; }
  .form-control:nth-child(1) { width: 20%; }
  .form-control:nth-child(2) { width: 60%; }
  .form-control:nth-child(3) { width: 80%; height: 120px; }
</style>

<?php
$title_subpage = "Inserir/Atualizar";
include('header.php');?>
<section class="pesquisa">
  <div class="container">
    <form method="post" name="certificado">
      <input type="text" name="id" placeholder="ID" class="form-control" required>
      <input type="text" name="titulo" placeholder="Título" class="form-control">
      <textarea name="autores" placeholder="Autores separados por vírgula" class="form-control"></textarea>
      <div class="form-group">
        <button type="submit" class="btn btn-home">Inserir/Atualizar</button>
        <button type="button" class="btn btn-home btn-debug" data-toggle="modal" data-target="#debug_data">Debug</button>
      </div>
    </form>
  </div>

  <!-- Modal Debug Data -->
  <div id="debug_data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Debug dos dados</h4>
        </div>
        <div class="modal-body">
          <div>
            <pre style="height: 600px; "><?php echo var_dump($data); ?></pre>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</section>
<?php include('footer.php');?>
