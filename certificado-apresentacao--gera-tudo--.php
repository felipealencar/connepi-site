<?php
ini_set('max_execution_time', 300);
if(isset($_POST) && isset($_POST['btn-form-gerador'])){

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
  $data = readCSV("files/resultado-final-connepi-2016.csv");

  $trabalhos = array();
  // LEMBRAR:
  // AQUI SÓ ESTÁ GERANDO ALGUNS COMO TESTE
  // NA VERSÃO FINAL INSERIR count($data) COMO FINAL DO LOOP
  // vlw flw :)
  for($i = 1; $i < 3; $i++){
    $id = trim($data[$i][0]);
    $trabalhos[$id]['id'] = $id;
    $trabalhos[$id]['titulo'] = trim($data[$i][1]);
    $trabalhos[$id]['grande-area'] = trim($data[$i][4]);
    $autores_array = explode(",", trim($data[$i][2]));
    $autores_string = "";
    $autores_string = (count($autores_array) == 1) ? $autores_array[0] : $autores_string;
    $autores_string = (count($autores_array) == 2) ? $autores_array[0] . " e " . $autores_array[1] : $autores_string;
    if(count($autores_array) >= 3){
      for($j=0; $j<count($autores_array); $j++){
        if($j == (count($autores_array)-1)) $autores_string .= "e " . $autores_array[$j];
        elseif($j == (count($autores_array)-2)) $autores_string .= $autores_array[$j] . " ";
        else $autores_string .= $autores_array[$j] . ", ";
      }
    }
    $trabalhos[$id]['autores'] = $autores_string;
    $trabalhos[$id]['filedownload'] = "";
  }

  if(count($trabalhos) > 0){
    include_once("mpdf60/mpdf.php");
    $css = file_get_contents('cert/style.css');

    foreach($trabalhos as $trabalho){

      $slug_grande_area = preg_replace( array( '/([`^~\'"])/', '/([-]{2,}|[-+]+|[\s]+)/', '/(,-)/' ), array( null, '-', ', ' ), iconv( 'UTF-8', 'ASCII//TRANSLIT', $trabalho['grande-area'] ) );
      $filename = "grandeArea_" . strtoupper($slug_grande_area) . "__trabalhoId_" . strval($trabalho['id']);
      $filepath = "cert/gerados/apresentacao/";
      $filedownload = $filepath . $filename . ".pdf";

      if(!file_exists($filedownload)){
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->autoScriptToLang = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML("<html>
        <head></head>
        <body>
        <div style='padding:200px 10px 0 30px;text-align:center;'>
        Certificamos que o trabalho intitulado \"" .$trabalho['titulo']. "\" dos autores " .$trabalho['autores']. " foi apresentado no XI Congresso Norte Nordeste de Pesquisa e Inovação em Maceió - AL
        <br><br><br>
        <b style='font-size:18px;'>Maceió, 09 de dezembro de 2016.</b>
        </div>
        </body></html>");
        $mpdf->Output($filedownload, "F");
      }
      $trabalho['filedownload'] = $filename . ".pdf";
    }
  } else {
    $erros[] = "A array trabalhos está vazia!";
  }
}
?>

<?php include("header.php"); ?>

<section class="pesquisa">
  <div style="max-width:820px;margin:60px auto 0 auto;">

    <h1 class="title">Certificados de apresentação</h1>
    <hr />

    <?php if(isset($errors) && count($erros) >= 1): ?>
      <div class="row" style="margin-top:5px">
        <div class="alert alert-danger">
          <?php echo(implode('<hr />', $erros)); ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- GERADOR -->
    <div class="row text-center">
      <form name="form-gerador" method="post">
        <button class="btn btn-default btn-lg" type="submit" name="btn-form-gerador" value="btn-form-gerador">Gerar agora</button>
      </form>
    </div>

    <!-- LOADING -->
    <div class="row" id="carregando">
      <div class="loading">
        <img src="images/logo-3.png" width="100%" />
        <h3>Carregando, aguarde...</h3>
      </div>
    </div>

    <!-- PDF LIST -->
    <?php if(isset($trabalhos) && count($trabalhos) > 0): ?>
      <div class="row" style="margin-top:5px" id="pdflist">
        <div class="list-group">

          <?php foreach($trabalhos as $trabalho): ?>
          <a href="cert/gerados/apresentacao/<?php echo $trabalho['filedownload']; ?>" target="_blank" class="list-group-item"><?php echo $trabalho['titulo']; ?></a>
          <?php endforeach; ?>

        </div>
      </div>
    <?php endif; ?>

    <div class="row" style="margin-top:10px">
      <div class="well well-lg text-center">
        Se não encontrar seu certificado ou o memso estiver com algum erro, favor informar nesta <a href="https://goo.gl/forms/nyjpMubSQN7Xveva2" target="_blank">página</a>.
      </div>
    </div>
  </div>
</section><!-- ./container -->

<script>
// OWSLA
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-85059492-1', 'auto');
  ga('send', 'pageview');
</script>

<?php include("footer.php"); ?>
