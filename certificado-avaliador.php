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

if(isset($_POST['inputName']) && !empty($_POST['inputName'])){

  $modalidade = strtoupper($_GET['modalidade']);
  $inputName = strtoupper($_POST['inputName']);

  $data = readCSV("files/avaliadores_final.CSV");

  $participantes = array();
  $j=0;
  // Evita os duplicados
  for($i=1; $i<count($data); $i++){
    $participantes[] = (!in_array(strtoupper($data[$i][0]), $participantes)) ? strtoupper($data[$i][0]) : '';
  }
  // ===========================================================================
  // Outros participantes
  $participantes[] = strtoupper('Ayrton Pereira Correia de Barros Junior'); // ayrtonbarros_jr@hotmail.com
  $participantes[] = strtoupper('Tiago Caian de Assis Silva'); // tiagocaian1@gmail.com
  $participantes[] = strtoupper('Antônia Isabela Soares Ximenes'); // isabelaximenes52@gmail.com
  $participantes[] = strtoupper('Mayára Gomes Targino'); // may.targino@gmail.com
  $participantes[] = strtoupper('Jailson Bina da Silva'); // jailsonbina.silva@gmail.com
  $participantes[] = strtoupper('Nelma Maria Rocha de Sousa'); // nelma.bio2014@gmail.com
  $participantes[] = strtoupper('MARCUS VICTOR MITONORI MARQUES'); // marcus_victor9@hotmail.com
  $participantes[] = strtoupper('Fabiana Santos da silva'); // santosfabiana802@gmail.com
  $participantes[] = strtoupper('LEANDRO ARAUJO DE SOUSA'); // leandrosousaifce@gmail.com
  $participantes[] = strtoupper('Thiago de Loiola Araújo e Silva'); // engtiagolas@hotmail.com
  $participantes[] = strtoupper('Jocélia da Hora Oliveira Barbosa'); // joceliahora@gmail.com
  $participantes[] = strtoupper('Edvânia Valério da Silva Cavalcante'); // edvaniacavalcante@hotmail.com.br
  $participantes[] = strtoupper('Jordana Rangely Almeida Santos de Oliveira'); // jordanarangely@hotmail.com
  $participantes[] = strtoupper('Josias Silva Santos'); // josias.jss10@gmail.com
  $participantes[] = strtoupper('Fávilla Vivianne da Silva Pinto'); // favillavivianny3@gmail.com
  $participantes[] = strtoupper('jessica valesca benicio da nobrega'); // jercika_valesca@hotmail.com
  $participantes[] = strtoupper('JOSÉ RIBEIRO DA SILVA'); // jorinetos@gmail.com
  $participantes[] = strtoupper('Fabiana Santos da Silva '); // santosfabiana802@gmail.com
  $participantes[] = strtoupper('Ricardo França Alves'); // ricardopb37@gmail.com
  $participantes[] = strtoupper('Francisco Johnson Albuquerque Batista'); // franciscojohnsonwar@gmail.com
  $participantes[] = strtoupper('Jadson Alexandre Teixeira de Souza'); // jadsonalexandreg@gmail.com
  $participantes[] = strtoupper('Estefani Marciel Ciriaco da Cunha'); // estefanimarciel@hotmail.com
  $participantes[] = strtoupper('Maria Rozane da Silva'); // rosanesilvah@gmail.com
  $participantes[] = strtoupper('João Pedro Souza Andrade '); // jpsa.s.andrade@hotmail.com
  $participantes[] = strtoupper('Wéltima Teixeira Cunha'); // weltima@yahoo.com.br / weltimateixeira@ifba.edu.br
  $participantes[] = strtoupper(''); //
  $participantes[] = strtoupper(''); //
  $participantes[] = strtoupper(''); //
  $participantes[] = strtoupper(''); //
  $participantes[] = strtoupper(''); //

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

      $link_download = "cert/gerados/avaliador/".strtolower($modalidade)."/$filename.pdf";

      if(!file_exists($link_download)){
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->autoScriptToLang = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML("<html>
        <head></head>
        <body>
        <div style='padding:200px 10px 0 30px;text-align:center;'>
        Certificamos que <b>$participante</b> participou como avaliador(a) dos trabalhos - modalidade $modalidade – expostos no XI CONNEPI em Maceió – Alagoas.
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

    <?php if(!isset($_GET['modalidade']) || empty($_GET['modalidade'])): ?>
    <h1>Dectamos que você não veio da página inicial, estamos solicitando que seja respondida a nossa pesquisa de satisfação.</h1>
    <hr style="border-bottom:1px solid black;border-top:none;margin-top:20px;"/>
    <h2 style="color:white;">Preecha um simples formulário, em seguida o certificado será liberado</h2>
    <a class="btn btn-default btn-sm" href="formulario-avaliador-banner.php">AVALIADOR DE TRABALHOS - BANNER</a> <a class="btn btn-default btn-sm" href="formulario-avaliador-oral.php">AVALIADOR DE TRABALHOS - ORAL</a>
  </div>
</section>

<?php else: ?>
      <h1 class="title">Gerar certificado</h1>
      <hr />

      <div class="row">
        <form action="certificado-avaliador.php?modalidade=<?php echo $_GET['modalidade']; ?>" method="post" name="form-gerador">
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
<?php endif; ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85059492-1', 'auto');
  ga('send', 'pageview');

</script>

<?php include("footer.php"); ?>
