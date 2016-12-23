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

$fileCSV = "files/resultado/resultado-final-connepi-2016.csv";
$data = readCSV($fileCSV);

//se o arquivo não estiver vazio...
if(count($data)){ ?>
  <html>
  <head>
    <meta charset="utf-8">
    <title>Resultado final XI CONNEPI</title>
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/lity.css">
    <link rel="stylesheet" href="css/resultado.css" />
  </head>
  <body>

    <div class="jumbotron text-center">
      <img src="images/logo-3.png" />
      <h2>RESULTADO FINAL DOS ARTIGOS</h2>
      <hr />
      <a style="margin-bottom:4px;" href="files/resultado/trabalhos-aprovados-por-instituicoes.pdf" data-lity data-lity-target="files/resultado/trabalhos-aprovados-por-instituicoes.pdf" class="btn btn-default">
        Trabalhos aprovados por Instituições
      </a> <a href="files/resultado/trabalhos-aprovados-por-instituicoes.pdf" download class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i></a><br>
      <a style="margin-bottom:4px;" href="files/resultado/principais-autores-aprovados-por-instituicoes.pdf" data-lity data-lity-target="files/resultado/principais-autores-aprovados-por-instituicoes.pdf" class="btn btn-default">
        Autores principais aprovados por Instituições
      </a> <a href="files/resultado/principais-autores-aprovados-por-instituicoes.pdf" download class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i></a><br>
      <a style="margin-bottom:4px;" href="files/resultado/autores-co-autores-que-aprovaram-trabalhos-por-instituicoes.pdf" data-lity data-lity-target="files/resultado/autores-co-autores-que-aprovaram-trabalhos-por-instituicoes.pdf" class="btn btn-default">
        Autores e co-autores que aprovaram trabalhos por Instituições
      </a> <a href="files/resultado/autores-co-autores-que-aprovaram-trabalhos-por-instituicoes.pdf" download class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i></a>
    </div>

    <div class="hero">
      <table>
        <thead>
          <tr>
            <th>#ID</th>
            <th>Título</th>
            <th>Autores</th>
            <th>Instituição</th>
            <th>Grande Área</th>
            <th>Resultado</th>
          </tr>
          <tbody>
            <?php foreach($data as $d){ ?>
              <tr>
                <th><?php echo strtoupper($d[0]); ?></th>
                <th><?php echo strtoupper($d[1]); ?></th>
                <th><?php echo strtoupper($d[2]); ?></th>
                <th><?php echo strtoupper($d[3]); ?></th>
                <th><?php echo strtoupper($d[4]); ?></th>
                <th><?php echo strtoupper($d[5]); ?></th>
              </tr>
            <?php } ?>
          </tbody>
        </thead>
      </table>
    </div>

    <script src="js/vendor/jquery-1.10.2.min.js"></script>
    <script src="js/lity.js"></script>

    <script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-85059492-1', 'auto');
	  ga('send', 'pageview');
		</script>

  </body>
  </html>
<?php } else {
  echo "NO CONTENT";
} ?>
