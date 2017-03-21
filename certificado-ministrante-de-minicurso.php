<?php
//from php.net
function utf8_fopen_read($fileName){$fc=iconv('ISO-8859-1//TRANSLIT','utf-8',file_get_contents($fileName));$handle=fopen("php://memory", "rw");fwrite($handle,$fc);fseek($handle,0);return $handle;}
function readCSV($csvFile){$row=1;$__return=array();if(($handle=utf8_fopen_read($csvFile,"r"))!==FALSE){while(($data=fgetcsv($handle, 1000, ";"))!==FALSE){$num=count($data);for($c=0; $c < $num; $c++){$__return[$row]=$data;}$row++;}fclose($handle);return $__return;}}
$erros = array();
$downloads = array();

$data = readCSV("files/ministrantes_minicurso/lista-de-ministrantes.csv");

$lista_ministrantes = array();
for($i=1; $i<count($data)-1; $i++){
  $id = strval(trim($data[$i][0]));
  $lista_ministrantes[$id]['id'] = $id;
  $lista_ministrantes[$id]['titulo'] = trim($data[$i][1]);
  $lista_ministrantes[$id]['emails'] = explode('*', $data[$i][2]);
  $lista_ministrantes[$id]['url'] = "files/ministrantes_minicurso/".md5($id).".pdf";
}

if(isset($_POST['inputBusca'])){

  $inputBusca = trim($_POST['inputBusca']);

  if(count($lista_ministrantes) > 0){
    foreach($lista_ministrantes as $row){
      if(in_array($inputBusca, $row['emails'])){
        $downloads[] = $row;
      }
    }
  } else {
    $erros[] = "Email não encontrado.";
  }
}
?>

<?php include("header.php"); ?>

<section class="pesquisa">
  <div style="max-width:820px;margin:60px auto 0 auto;padding:0 40px;">

    <?php if(count($downloads) <=   0) : ?>
    <h1 class="wow fadeInDown" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;"><i style="margin-right:20px;" class="fa fa-search" aria-hidden="true"></i> Buscar certificado</h1>
    <hr style="margin-top:20px;border-top:1px solid rgb(157, 210, 203);border-botom:1px solid rgb(219, 219, 219);" />

    <div class="row">
      <form method="post" name="form-gerador">
        <div class="input-group wow fadeIn" data-wow-delay="0.4s" style="margin-top:20px;">
          <input type="text" name="inputBusca" class="form-control" style="padding-top:20px;padding-bottom:20px;" placeholder="Email">
          <span class="input-group-btn">
            <button class="btn btn-default" style="padding-top:10px;padding-bottom:10px;" type="submit" name="btnBuscar" value="gerar">Buscar</button>
          </span>
        </div>
      </form>
    </div>
    <?php endif; ?>

    <style media="screen">
      .killer-radio { display: block; margin-left: 40px; margin-bottom:10px;}
      label {
        display: inline-block;
        cursor: pointer;
        position: relative;
        padding-left: 25px;
        color: #fff;
        font-size: 18px;
        font-weight: 400;
        line-height: 21px;
      }
      label:before {
        content: "";
        width: 20px; height: 20px;
        position: absolute;
        left: -6px;
        bottom: 1px;
        border-radius: 50%;
        box-shadow: inset 0px 1px 0px 0px rgba(255, 255, 255, .4), 0px 2px 3px 0px rgba(0, 0, 0, .2);
        transition: 130ms linear all;
      }
      input[type="radio"] { display: none; }
      input[type=radio]:checked + label:before {
        background-color: #ffffff;
        box-shadow: inset 0px 2px 3px 0px rgba(0, 0, 0, .2), 0px 1px 0px 0px rgba(255, 255, 255, .5);
      }
      @media (max-width: 500px){
        .killer-radio { display: block; }
      }

    </style>

    <?php if(count($erros) >= 1): ?>
      <div class="row" style="margin-top:5px">
        <div class="alert alert-danger">
          <?php echo(implode('<hr />', $erros)); ?>
        </div>
        <a href="certificado-ministrante-de-minicurso" style="margin-top:10px;margin-bottom:30px;" class="btn btn-default btn-home">Voltar</a>
      </div>
    <?php endif; ?>

    <!-- LOADING -->
    <div class="row" id="carregando">
      <div class="loading">
        <img src="images/logo-3.png" width="100%" />
        <h3>Carregando, aguarde...</h3>
      </div>
    </div>

    <!-- DOWNLOAD VIEW -->
    <?php if($downloads): ?>
      <div class="row" style="margin-top:5px" id="pdflist">
        <div class="list-group">

          <h1 class="wow fadeIn"><i style="margin-right:20px;" class="fa fa-search" aria-hidden="true"></i> Resultado da busca</h1>
          <hr style="margin-top:20px;border-top:1px solid rgb(157, 210, 203);border-botom:1px solid rgb(219, 219, 219);" />

          <h2 style="color:white;" class="wow fadeIn" data-wow-delay="0.2s">Minicurso encontrado</h2>
          <?php foreach($downloads as $download) : ?>
            <h4 style="font-style:italic;" class="wow fadeIn" data-wow-delay="0.3s">- <?php echo $download['titulo']; ?></h4>
            <span class="row">
              <a href="<?php echo $download['url']; ?>" target="_blank" class="btn btn-home wow fadeInUp" data-wow-delay="0.5s">Visualizar</a>
              <a download href="<?php echo $download['url']; ?>" target="_blank" class="btn btn-home wow fadeInUp" data-wow-delay="0.7s">Baixar</a>
            </span>
          <?php endforeach; ?>

        </div>
      </div>
    <?php else: ?>

    <div class="row wow fadeInUp" data-wow-delay="0.9s" style="margin-top:30px">
      <div class="well well-lg text-center" style="background-color:rgba(255, 255, 255,0.6">
        Em caso de dúvidas ou problemas, informe usando o formulário de <a href="https://goo.gl/forms/nyjpMubSQN7Xveva2" target="_blank">suporte</a>.
      </div>
    </div>
  </div>
  <?php endif;?>
</section><!-- ./container -->

<?php include("footer.php"); ?>
