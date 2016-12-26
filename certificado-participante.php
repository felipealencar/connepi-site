<?php

//from php.net
function utf8_fopen_read($fileName) {
    $fc = iconv('ISO-8859-1//TRANSLIT', 'utf-8', file_get_contents($fileName));
    $handle = fopen("php://memory", "rw");
    fwrite($handle, $fc);
    fseek($handle, 0);
    return $handle;
}

function readCSV($csvFile)
{
	$row = 1;
	$__return = array();
	if (($handle = utf8_fopen_read($csvFile, "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$num = count($data);
			for ($c=0; $c < $num; $c++) {
				$__return[$row] = $data;
			}
			$row++;
		}
		fclose ($handle);
		return $__return;
	}
}
$erros = array();
$downloads = array();

if(isset($_POST['inputName'])){

  $inputName = strtoupper($_POST['inputName']);

  $data = readCSV("files/participantes_crendeciamento.CSV");
  $nao_pode = array('4E400 DESIGN E GESTÃO EMPRESARIAL', 'ACOMPANHANTE', 'AUSENTE', 'AVALIADOR', 'C', 'CM CONSTRUÇÕES', 'CONVIDADO', 'EMBAIXADA DA FINLANDIA', 'EMPRESA FERNÃO VELHO',
  'F5 CONSULTORIA', 'FERNÃO VELHO', 'FILMART', 'FORTLINE CORP', 'FRM', '');

  $participantes = array();
  for($i=0; $i<count($data); $i++){
    if($i > 1 && !in_array($data[$i][1], $nao_pode)){
      $participantes[] = trim(strtoupper($data[$i][0]), ',');
    }
  }

  function buscaParticipante($inputName, $participantes){
    $out = array();
    foreach($participantes as $key => $value){
      if(strpos($value, $inputName) !== false){
        $out[] = $value;
      }
    }
    return $out;
  }

  $busca_resultado = (buscaParticipante($inputName, $participantes)) ? buscaParticipante($inputName, $participantes) : false;

  if($busca_resultado){
    include_once("mpdf60/mpdf.php");
    $css = file_get_contents('cert/style.css');

    $count = 0;
    foreach($busca_resultado as $participante){

      $filename = strtolower(str_replace(' ', '_', trim(iconv('UTF-8', 'ASCII//TRANSLIT', $participante), ',')));
      for($i=0; $i<strlen($filename); $i++){
        if(strpos("abcdefghijklmnopqrstuvxzwy0123456789_-", $filename[$i]) === false){
          $filename[$i] = '_';
        }
      }

      $link_download = "cert/gerados/participante/$filename.pdf";

      if(!file_exists($link_download)){
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->autoScriptToLang = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML("<html>
        <head></head>
        <body>
        <div style='padding:200px 10px 0 30px;text-align:center;'>
        Certificamos que <b>$participante</b> participou do XI CONNEPI – Congresso Norte Nordeste de Pesquisa e Inovação, que ocorreu no período de 06 a 09 de dezembro de 2016, no Hotel Ritz Lagoa da Anta, na cidade de Maceió - Alagoas.
        <br><br><br>
        <b style='font-size:18px;'>Maceió, 09 de dezembro de 2016.</b>
        </div>
        </body></html>");
        $mpdf->Output($link_download, "F");
      }
      $downloads[$count] = array();
      $downloads[$count]['nome'] = $participante;
      $downloads[$count]['linkDownload'] = $link_download;
      $count++;
    }
  } else {
    $erros[] = "Usuário não encontrado ou não possui instituição.";
  }
}
?>

<?php include("header.php"); ?>

<section class="pesquisa">
  <div style="max-width:820px;margin:60px auto 0 auto;">

    <h1 class="title">Gerar certificado</h1>
    <hr />

    <div class="row">
      <form action="certificado-participante.php" method="post" name="form-gerador">
        <div class="input-group">
          <input type="text" name="inputName" class="form-control" placeholder="Nome do participante">
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit" name="btnGerar" value="gerar">Buscar</button>
          </span>
        </div>
      </form>
    </div>

    <?php if(count($erros) >= 1): ?>
      <div class="row" style="margin-top:5px">
        <div class="alert alert-danger">
          <?php echo(implode('<hr />', $erros)); ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="row" id="carregando">
      <div class="loading">
        <img src="images/logo-3.png" width="100%" />
        <h3>Carregando, aguarde...</h3>
      </div>
    </div>

    <?php if(count($downloads) > 0): ?>
      <div class="row" style="margin-top:5px" id="pdflist">
        <div class="list-group">

          <?php if(count($downloads) > 1): ?>
          <a target="_blank" class="list-group-item active">Participantes encontrados:</a>
          <?php else: ?>
          <a target="_blank" class="list-group-item active">Participante encontrado:</a>
          <?php endif; ?>

          <?php foreach($downloads as $download): ?>
          <a href="<?php echo $download['linkDownload']; ?>" target="_blank" class="list-group-item"><?php echo $download['nome']; ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="row" style="margin-top:10px">
      <div class="well well-lg">
        1. Informe seu nome.<br>
        2. O certificado só será gerado para os usuários que participaram do XI CONNEPI.<br>
        3. Em caso de dúvidas ou problemas, informe usando o formulário de <a href="https://goo.gl/forms/Bl1QUa5cddu5Snx72" target="_blank">suporte</a>.
      </div>
    </div>
  </div>
</section><!-- container -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85059492-1', 'auto');
  ga('send', 'pageview');

</script>

<?php include("footer.php"); ?>
