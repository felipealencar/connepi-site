<?php

function readJSONParse($fileName) {
    // return json_decode(iconv('ISO-8859-1//TRANSLIT', 'utf-8', file_get_contents($fileName)));
    ini_set('mbstring.substitute_character', "none");
    return json_decode(mb_convert_encoding(file_get_contents($fileName), 'UTF-8', 'UTF-8'));
}

$erros = array();
$downloads = array();

if(isset($_POST['inputBusca'])){

  mb_internal_encoding("UTF-8");
  $inputBusca = mb_strtoupper(trim($_POST['inputBusca']));
  $tipoBusca = $_POST['inputTipoBusca'];

  $data = readJSONParse("files/apresentador-do-trabalho/dados-certificado-apresentadores.json");

  // inicio de uma funcao
  function buscarTrabalho($inputBusca, $tipoBusca, $data){
    $resultado = array();
    if($tipoBusca == 'id') foreach($data as $apresentacao) if($apresentacao->id == $inputBusca) $resultado[] = $apresentacao;
    elseif($tipoBusca == 'titulo') foreach($data as $apresentacao) if(strpos($apresentacao->titulo, $inputBusca) !== false) $resultado[] = $apresentacao;
    elseif($tipoBusca == 'apresentador') foreach($data as $apresentacao) if(strpos($apresentacao->apresentador, $inputBusca) !== false) $resultado[] = $apresentacao;
    return (count($resultado) > 0) ? $resultado : false;
  }
  // fim de uma funcao

  $busca_resultado = buscarTrabalho($inputBusca, $tipoBusca, $data);

  if($busca_resultado){
    include_once("mpdf60/mpdf.php");
    $css = file_get_contents('cert/style.css');

    $count = 0;
    foreach($busca_resultado as $trabalho){

      $filename = strval($trabalho->id);
      $link_download = "cert/gerados/apresentador/$filename.pdf";

      $mpdf = new mPDF('utf-8', 'A4-L');
      $mpdf->autoScriptToLang = true;
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($css, 1);
      $mpdf->WriteHTML("<html>
      <head></head>
      <body>
      <div style='padding:135px 10px 0 10px;'>
      <p style='text-align:justify;line-height:32px;'>Certificamos que " .$trabalho->apresentador. " apresentou o trabalho intitulado \"" .$trabalho->titulo. "\" no XI CONNEPI – XI Congresso Norte Nordeste de Pesquisa e Inovação, que ocorreu no período de 06 a 09 de dezembro de 2016, na cidade de Maceió - Alagoas.</p>
      <br><br>
      <p style='font-size:20px;text-align:center;'>Maceió, 09 de dezembro de 2016</p>
      </div>
      </body></html>");
      $mpdf->Output($link_download, "F");
      $downloads[$count] = array();
      $downloads[$count]['id'] = $trabalho->id;
      $downloads[$count]['titulo'] = $trabalho->titulo;
      $downloads[$count]['apresentador'] = $trabalho->apresentador;
      $downloads[$count]['linkDownload'] = $link_download;
      $count++;
    }
  } else {
    $erros[] = "Nada encontrado.";
  }
}
?>

<?php
$title_subpage = "Certificado de Apresentador";
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
            <input type="radio" id="inputTipoBusca3" name="inputTipoBusca" value="apresentador">
            <label for="inputTipoBusca3">Apresentador</label>
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
      <div class="row" style="margin-top:5px" id="pdflist">
        <div class="list-group">

          <h1 class="wow fadeInDown" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;"><i style="margin-right:20px;" class="fa fa-search" aria-hidden="true"></i> Resultado da busca</h1>
          <hr style="margin-top:20px;border-top:1px solid rgb(157, 210, 203);border-botom:1px solid rgb(219, 219, 219);" />
          <a href="certificado-apresentador" style="margin-top:10px;margin-bottom:30px;" class="btn btn-default btn-home">Voltar</a>

          <?php foreach($downloads as $download): ?>
          <a href="<?php echo $download['linkDownload']; ?>" target="_blank" class="list-group-item wow fadeInUp"><?php echo $download['titulo']; ?></a>
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

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85059492-1', 'auto');
  ga('send', 'pageview');

</script>

<?php include("footer.php"); ?>
