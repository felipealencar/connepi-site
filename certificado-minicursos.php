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


  $curso = $_GET['curso'];
  $inputName = strtolower($_POST['inputName']);

  $data = readCSV("files/participantes_minicurso/$curso.CSV");
  $minicursos = array(
    '01' => array('titulo' => 'A arte como potencializador do ensino de ciências', 'data' => '07'),
    '02' => array('titulo' => 'Audiodescrição: usos, possibilidades e inclusão pedagógica no ensino tecnológico', 'data' => '07'),
    '03' => array('titulo' => 'Dança asiática: uma alternativa prática de enriquecimento cultural para a educação', 'data' => '07'),
    '04' => array('titulo' => 'Diz isso de outro jeito: Entonações e interações da voz', 'data' => '07'),
    '05' => array('titulo' => 'Energia Solar Fotovoltaica: Oportunidades do mercado brasileiro e como se capacitar', 'data' => '08'),
    '06' => array('titulo' => 'Indicação Gerográfica e Turismo - Inovação e Desenvolvimento Regional', 'data' => '08'),
    '07' => array('titulo' => 'Introdução à programação de Robôs LEGO', 'data' => '08'),
    '08' => array('titulo' => 'Técnicas Contemporâneas de Aquarela com materiais sustentáveis para a redução de estress', 'data' => '09'),
    '09' => array('titulo' => 'Aprendizagem centrada no aluno: Compartilhando a experiência no modelo educacional finlandês', 'data' => '09')
  );

  $participantes = array();
  $j=0;
  for($i=1; $i<count($data); $i++){
    $participantes[] = $data[$i][0];
  }

  // ===========================================================================
  // Inserindo mais participantes
  $participantes[] = strtoupper('JHONATAS GUTIERREZ SANTOS DE JESUS'); // teslaguto@gmail.com
  $participantes[] = strtoupper('Clênio Renê Kurz Böhmer'); // cleniob@gmail.com
  $participantes[] = strtoupper('Ricardo Nascimento do Carmo'); // ricardo.nascimento@acad.ifma.edu.br
  $participantes[] = strtoupper('Thiago de Loiola Araújo e Silva'); // engtiagolas@hotmail.com
  $participantes[] = strtoupper('Leonardo Mendes Sousa Xavier'); // leoo_mendes@hotmail.com
  $participantes[] = strtoupper('Maria Aparecida Gonçalves dos Santos'); // aparecidagsantos94@gmail.com
  $participantes[] = strtoupper('Danillo Gabriel Moreira Correia de Souza'); // danillosouzamc@gmail.com
  $participantes[] = strtoupper('ROMÁRIO SILVA BARROS'); // romario.barros@ifpi.edu.br
  $participantes[] = strtoupper('GIRLENE DE LIMA SANTOS'); // girlenelimasantos200@gmail.com
  $participantes[] = strtoupper('Estefani Marciel Ciriaco da Cunha'); // estefanimarciel@hotmail.com
  $participantes[] = strtoupper('Matheus Henrique Felipe Lima'); // matheus1selection@gmail.com
  $participantes[] = strtoupper('Adriana Maria Coelho'); // dryana.coelho@gmail.com
  $participantes[] = strtoupper(''); //
  $participantes[] = strtoupper(''); //
  $participantes[] = strtoupper(''); //
  $participantes[] = strtoupper(''); //
  $participantes[] = strtoupper(''); //
  $participantes[] = strtoupper(''); //
  $participantes[] = strtoupper(''); //

  function buscaParticipante($inputName, $participantes){
    $out = array();
    foreach($participantes as $key => $value){
      if(strpos(strtolower($value), $inputName) !== false){
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

      $link_download = "cert/gerados/minicursos/{$curso}/{$filename}.pdf";

      if(!file_exists($link_download)){
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->autoScriptToLang = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML("<html>
        <head></head>
        <body>
        <div style='padding:200px 10px 0 30px;text-align:center;'>
        Certificamos que <b>$participante</b> participou do minicurso
        intitulado <b>“".$minicursos[$curso]['titulo']."”</b>, com
        carga horária de 4 horas, realizado no dia ".$minicursos[$curso]['data']." de dezembro de 2016, no
        <b>XI Congresso Norte Nordeste de Pesquisa e Inovação – Connepi</b>.
        </div></body></html>");
        $mpdf->Output($link_download, "F");
      }
      $downloads[$count] = array();
      $downloads[$count]['nome'] = $participante;
      $downloads[$count]['linkDownload'] = $link_download;
      $count++;
    }
  } else {
    $erros[] = "Usuário não encontrado.";
  }
}
?>

<?php include("header.php"); ?>

<section class="pesquisa">
  <div style="max-width:820px;margin:60px auto 0 auto;">

    <?php if(!isset($_GET['curso'])): ?>
    <h1>Dectamos que você não veio da página inicial, estamos solicitando que seja respondida a nossa pesquisa de satisfação.</h1>
    <hr style="border-bottom:1px solid black;border-top:none;margin-top:20px;"/>
    <h2 style="color:white;">Preecha um simples formulário, em seguida o certificado será liberado</h2>
    <a class="btn btn-default btn-sm" href="formulario-minicursos.php">Ir para o formulário</a>
  </div>
</section>

<?php else: ?>
      <h1 class="title">Gerar certificado</h1>
      <hr />

      <div class="row">
        <form action="certificado-minicursos.php?curso=<?php echo $_GET['curso']; ?>" method="post" name="form-gerador">
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
