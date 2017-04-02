<?php

function readJSONParse($fileName) {
    ini_set('mbstring.substitute_character', "none");
    return json_decode(iconv('ISO-8859-1//TRANSLIT', 'utf-8', file_get_contents($fileName)));
    // return json_decode(mb_convert_encoding(file_get_contents(), 'UTF-8', 'UTF-8'), true);
}
$erros = array();
$downloads = array();

if(isset($_POST['inputBusca']) || isset($_GET['generateFromId'])){

  mb_internal_encoding("UTF-8");
  $inputBusca = (isset($_POST['inputBusca']) && !isset($_GET['generateFromId'])) ? trim($_POST['inputBusca']) : trim($_GET['generateFromId']);
  $tipoBusca = (isset($_POST['inputBusca']) && !isset($_GET['generateFromId'])) ? trim($_POST['inputTipoBusca']) : 'id';

  $data = readJSONParse("files/dados-certificado-autores-do-trabalho.json");

  $trabalhos = array();
  $i=0;
  foreach($data as $row){
    $trabalhos[$i]['id'] = $row->id;
    $trabalhos[$i]['titulo'] = $row->titulo;
    $autores_array = explode(",", $row->autores);
    $autores_string = "";
    $autores_string = (count($autores_array) == 1) ? $autores_array[0] : $autores_string;
    $autores_string = (count($autores_array) == 2) ? $autores_array[0] . " e " . $autores_array[1] : $autores_string;
    if(count($autores_array) >= 3){
      for($j=0; $j<count($autores_array); $j++){
        if($j == (count($autores_array)-1)){
          $autores_string .= "e " . $autores_array[$j];
        }
        elseif($j == (count($autores_array)-2)){
          $autores_string .= $autores_array[$j] . " ";
        }
        else{
          $autores_string .= $autores_array[$j] . ", ";
        }
      }
    }
    $trabalhos[$i]['autores'] = $autores_string;
    if(isset($row->colocacao) && $row->colocacao == 1){
      $trabalhos[$i]['colocacao'] = 'primeira';
    }
    elseif(isset($row->colocacao) && $row->colocacao == 2){
      $trabalhos[$i]['colocacao'] = 'segunda';
    }
    elseif(isset($row->colocacao) && $row->colocacao == 3){
      $trabalhos[$i]['colocacao'] = 'terceira';
    }
    else{
      $trabalhos[$i]['colocacao'] = (isset($row->colocacao)) ? $row->colocacao : '';
    }
    $trabalhos[$i]['area'] = (isset($row->area)) ? $row->area : '';
    $trabalhos[$i]['modalidade'] = (isset($row->modalidade)) ? $row->modalidade : '';
    $i++;
  }

  // inicio da busca
  function buscarTrabalho($inputBusca, $tipoBusca, $trabalhos){
    $resultado = array();
    foreach($trabalhos as $trabalho){
      if(strpos(mb_strtoupper($trabalho[$tipoBusca]), mb_strtoupper($inputBusca)) !== false){
        $resultado[] = $trabalho;
      }
    }
    return (count($resultado) > 0) ? $resultado : false;
  }
  // fim da busca

  $busca_resultado = buscarTrabalho($inputBusca, $tipoBusca, $trabalhos);

  if($busca_resultado){
    include_once("mpdf60/mpdf.php");
    $css = file_get_contents('cert/style.css');

    $count = 0;
    foreach($busca_resultado as $trabalho){

      $filename = strval($trabalho['id']);
      $link_download = "cert/gerados/premiados/{$filename}.pdf";

      if(1 == 1){

        // Casos isolado '-'
        if($trabalho['id'] == '11441')
        {
          $trabalho['titulo'] = "Í" . $trabalho['titulo'];
        }
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->autoScriptToLang = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML("<html>
        <head></head>
        <body>
        <div style='padding:135px 10px 0 10px;'>
        <p style='text-align:justify;line-height:32px;'>Certificamos que o trabalho ".$trabalho['titulo'].", de autoria de ".$trabalho['autores'].", foi premiado na ".$trabalho['colocacao']." colocação na área ".$trabalho['area'].", modalidade ".$trabalho['modalidade'].", no XI Congresso Norte Nordeste de Pesquisa e Inovação (CONNEPI), realizado no período de 06 a 09 de dezembro de 2016, na cidade de Maceió, Alagoas.</p>
        <br><br>
        <p style='font-size:20px;text-align:center;'>Maceió, 09 de dezembro de 2016</p>
        </div>
        </body></html>");
        $mpdf->Output($link_download, "F");
      }
      $downloads[$count] = array();
      $downloads[$count]['id'] = $trabalho['id'];
      $downloads[$count]['titulo'] = $trabalho['titulo'];
      $downloads[$count]['autores'] = $trabalho['autores'];
      $downloads[$count]['linkDownload'] = $link_download;
      $count++;
    }
  } else {
    $erros[] = "Nada encontrado.";
  }
}
?>

<?php
$title_subpage = "Certificado de Autores do trabalho";
include("header.php"); ?>

<section class="pesquisa">
  <div style="max-width:820px;margin:60px auto 0 auto;padding:0 40px;">

    <?php if(count($downloads) <= 0) : ?>
    <h1 class="wow fadeInDown" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;"><i style="margin-right:20px;" class="fa fa-search" aria-hidden="true"></i> Buscar certificado</h1>
    <hr style="margin-top:20px;border-top:1px solid rgb(157, 210, 203);border-botom:1px solid rgb(219, 219, 219);" />

    <div class="row">
      <form method="post" name="form-gerador">
        <div style="margin-bottom:10px;">
          <div class="killer-radio wow fadeInLeft" data-wow-delay="0.1s">
            <input type="radio" id="inputTipoBusca1" name="inputTipoBusca" value="id" required>
            <label for="inputTipoBusca1">ID</label>
          </div>
          <div class="killer-radio wow fadeInLeft" data-wow-delay="0.3s">
            <input type="radio" id="inputTipoBusca2" name="inputTipoBusca" value="titulo" >
            <label for="inputTipoBusca2">Título</label>
          </div>
          <div class="killer-radio wow fadeInLeft" data-wow-delay="0.5s">
            <input type="radio" id="inputTipoBusca3" name="inputTipoBusca" value="autores">
            <label for="inputTipoBusca3">Autor</label>
          </div>
        </div>
        <div class="input-group wow fadeIn" data-wow-delay="0.4s" style="margin-top:20px;">
          <input type="text" name="inputBusca" class="form-control" style="padding-top:20px;padding-bottom:20px;" placeholder="Marque o tipo e faça a busca">
          <span class="input-group-btn">
            <button class="btn btn-default" style="padding-top:10px;padding-bottom:10px;" type="submit" name="btnBuscar" value="gerar">Buscar</button>
          </span>
        </div>
      </form>
    </div>
    <?php endif; ?>

    <style media="screen">
      .killer-radio { display: block; margin-left: 40px; margin-bottom:10px;}
      label:not(.no-style) {
        display: inline-block;
        cursor: pointer;
        position: relative;
        padding-left: 25px;
        color: #fff;
        font-size: 18px;
        font-weight: 400;
        line-height: 21px;
      }
      label:not(.no-style):before {
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

      #div_verificarEmail {
      	margin-top: 30px;
      	display: none;
      	background-color: #5DB581 !important;
      }

    </style>

    <?php if(count($erros) >= 1): ?>
      <div class="row" style="margin-top:5px">
        <div class="alert alert-danger">
          <?php echo(implode('<hr />', $erros)); ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- LOADING -->
    <div class="row" id="carregando">
      <div class="loading">
        <img src="images/logo-3.png" width="100%" />
        <h3>Carregando, aguarde...</h3>
      </div>
    </div>

    <!-- PDF LIST -->
    <?php if(count($downloads) > 0): ?>
      <div class="row" style="margin-top:5px;" id="pdflist">
        <div class="list-group">

        	<h1 class="wow fadeInDown" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;"><i style="margin-right:20px;" class="fa fa-search" aria-hidden="true"></i> Resultado da busca</h1>
	        <hr style="margin-top:20px;border-top:1px solid rgb(157, 210, 203);border-botom:1px solid rgb(219, 219, 219);" />
	        <a href="javascript:;" onclick="window.history.back();" style="margin-top:10px;margin-bottom:30px;" class="btn btn-default btn-home">Voltar</a>

	        <?php foreach($downloads as $download): ?>
	        <a href="javascript:;" data-download="<?php echo $download['linkDownload']; ?>" id="<?php echo $download['id']; ?>" class="list-group-item link-artigo wow fadeInUp"><?php echo $download['titulo']; ?></a>
	        <?php endforeach; ?>

	        <div class="well-lg" id="div_verificarEmail">
	          <label for="inputEmail" class="no-style" style="color:white;padding-bottom:2px;border-bottom:1px solid #dedede;margin-bottom:10px;">Insira o e-mail do autor principal</label>
	          <input type="text" class="form-control" name="inputEmail" id="inputEmail" placeholder="">
	          <button id="btn_verificarEmail" class="btn btn-defaul btn-home">Continuar</button>
	        </div>
        </div><!-- .list-group -->
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
