<?php
//Gambiarra para códigos mal feitos...
ini_set('max_execution_time', 300);

function dd($var)
{
  echo '<pre>';
  var_dump($var);
  die;
}

/**
 * return array
 * Ler o csv gerado apartir da planilha xlsx enviado pelo Ginaldo
 */
function readCSV($file)
{
  if(!$file || !file_exists($file))
  {
    return array();
  }
  
  $__data = array();
  
  if (($handle = fopen($file, "r")) !== FALSE) 
  {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
    {
      $__data[] = $data;
    }
    
    fclose($handle);
    
    return $__data;
    
  }
  
  return array();
}

/*
 * return string url pdf
 * Gera o pdf do avaliador por cada campus
 */
function gerarPDF($nome, $campus, $trabalhos, $link_download)
{
    
  $css = file_get_contents('avaliacao-parcial-pibic-pibit-2016-2017/style_pibit.css');
  
  $mpdf = new mPDF('utf-8', 'A4-L');
  $mpdf->autoScriptToLang = true;
  $mpdf->SetDisplayMode('fullpage');  
   
  $strTrablho = '<h4>TRABALHOS AVALIADOS: </h4>' . implode('<br/>', $trabalhos[$campus]);
            
  $mpdf->WriteHTML($css, 1);
  $mpdf->WriteHTML("<html>
  <head>
  </head>
  <body class='bg'>
  <div>
  <div style='padding:240px 10px 0 10px;'><p style='text-align:justify;line-height:32px;'>A Pró-Reitoria de Pesquisa e Inovação do Instituto Federal de Alagoas certifica que <strong>". $nome ."</strong> participou como avaliador dos projetos de pesquisa do  Programa de Iniciação Científica PIBIC e PIBITI do IFAL – Campus ".$campus.".</p>
  <br>
  <p style='font-size:20px;text-align:center;'>Maceió, 30 de março de 2017</p>
  </div></div>
  </body></html>");
  $mpdf->AddPage();
  $mpdf->WriteHTML("<html>
  <head>
  </head>
  <body>
  <div class='mascara'>
  <div style='padding:12px 10px 0 10px; font-size:13px;'>
  ".$strTrablho."
  </div>
  </div>    
  </body></html>");
  
  if($aux < $total)
  {
    $mpdf->AddPage();
  }       

  try{
    
    $mpdf->Output($link_download, "F");
    return $link_download;
    
  }catch(Exception $e){
    return null;  
  }
    
}

//dados do csv...
$data = readCSV("avaliacao-parcial-pibic-pibit-2016-2017/data/data.csv");

//var temp's
$avaliadoresDistintos = array();
$certificado = false;

//se o arquivo não estiver vazio
if(count($data))
{
  //agrupando as informações... porque essa planilha ta show óóóó....
  foreach($data as $item)
  {
    $avaliadoresDistintos[$item[4]][] = $item;
    $avaliadoresDistintos[$item[5]][] = $item;
    $avaliadoresDistintos[$item[6]][] = $item;
    $avaliadoresDistintos[$item[7]][] = $item;
  }
  
}

function requires(){
	if(!isset($_POST['avaliador']) || empty($_POST['avaliador'])){
		echo '<script>alert("O campo de texto deve ser preenchido!");</script>';
		return false;
	}
	return true;
}

// enviou o formulário?
if(isset($_POST['btnBuscar']) && requires())
{

  mb_internal_encoding("UTF-8");
  include_once("mpdf60/mpdf.php");
  
  
  $inputBusca = $_POST['avaliador'];
    
  if(count($avaliadoresDistintos))
  {
    
    // nomes dos avaliadores filtrados
    $nomesAvaliadores = array_filter(array_keys($avaliadoresDistintos));
    
    // fazendo o like no array
    $inputBusca = preg_quote($inputBusca, '~');
    $existe = preg_grep('~' . $inputBusca . '~', $nomesAvaliadores);

    // se algum ocorrência não for encontrada
    if($existe === false || !count($existe))
    {
      $erros[] = 'Não existe esse avaliador na base de dados.';
    }
    
    //var temp's
    $trabalhos = array();
    $campus = array();
    $nome = reset($existe);
    
    // agrupando os trabalhos por campus
    if(count($avaliadoresDistintos[$nome])){
      foreach($avaliadoresDistintos[$nome] as $trabalho)
      {
        $trabalhos[$trabalho[3]][] = $trabalho[1];
        $campus[$trabalho[3]] = $trabalho[3];
      }
    }
    
    //var temp's
    $gerou = array();
    
    // se o avaliador tiver algum registro de campus
    if(count($campus))
    {
      foreach($campus as $_campus)
      {

        // gerar o certificado dele  
        $filename = md5($nome).'_'.$_campus;
        $link_download = "avaliacao-parcial-pibic-pibit-2016-2017/certificados/$filename.pdf";
        $gerou[] = gerarPDF($nome, $_campus, $trabalhos, $link_download);
        
      }
    }       
        
  } else {
    $erros[] = "Nada encontrado.";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Certificados da avaliação parcial Pibic/Pibiti 2016-2017" />
    <meta name="author" content="Anilson Lopes (@quilamcz)">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <title>Avaliação parcial Pibic/Pibiti 2016-2017</title>
  </head>
  <body id="body">

  <div class="container">
    <div class="centered">

      <div class="row" style="margin-bottom: 20px;">
        <h1>Gerar Certificado</h1>
        <h2>Tente buscar seu certificado tanto com letras maiúsculas como minúsculas.</h2>
        <p style="font-size:11px;">(<u>Nome</u> difere-se de <u>nome</u>)</p>

        <div class="row" style="margin-top: 10px;">
          <form method="post" name="gerar-certificados-avaliadores">
              <div class="input-group">
                <input type="text" placeholder="" name="avaliador" value="<?php (isset($_POST['avaliador'])) ? $_POST['avaliador'] : ''; ?>">
                <button name="btnBuscar" type="submit" value="gerar">Buscar</button>
              </div><!-- /input-group -->
          </form>
        </div><!-- .container -->
      </div><!-- .container -->

      <?php if(count($erros)): ?>
        <hr/>
        <ul class="alert-error">
        <?php foreach($erros as $erro): ?>
          <li><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php echo $erro; ?></li>
        <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if(count($gerou)): ?>
      <hr/>
      <div class="lista">
        <h3>Certificado gerado com sucesso</h3>
        <?php $aux = 1; ?>
        <?php if(count($gerou)): ?>
          <?php foreach($gerou as $link): ?>
            <a href="<?php echo $link; ?>" target="_blank"><?php echo $aux; ?>. <span class="label label-info">Clique aqui para visualizar <i class="fa fa-eye" aria-hidden="true"></i></span></a><br>
            <?php $aux++; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </div><!-- .lista -->
      <?php endif; ?>

    </div><!-- .centered -->

    <style>
      * { margin: 0; padding: 0; }
      html, body { width: 100%; height: 100%; overflow: hidden; }
      .container {
        width: 100%;
        margin: 0 auto;
        font-family: 'Open Sans', sans-serif;
      }
      .container > .container,
      .container > .container > .container {
        padding-left: 0;
        padding-right: 0;
      }
      .centered {
        width: 100%;
        max-width: 720px;
        margin: 15% auto 0 auto;
      }
      .alert-error {
        width: 100%;
        margin: 25px 0;
        padding: 15px 25px;
        background-color: red;
        color: #fff;

        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;

        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;

        list-style-type: none;
      }
      .lista {
        margin: 25px 0 25px 0;
      }
      .lista a {
        text-decoration: none;
        color: #444;
        display: inline-block;
        margin: 5px 0 5px 15px;
      }
      .lista a:hover {
        color: blue;
        font-weight: bold;
      }
      .input-group {
        width: 100%;
      }
      .input-group:after {
        display: table;
        content: '';
        clear: both;
      }
      .input-group input,
      .input-group button {
        float: left;
        -moz-box-shadow: inset 0px 1px 0px 0px #45D6D6;
        -webkit-box-shadow: inset 0px 1px 0px 0px #45D6D6;
        box-shadow: inset 0px 1px 0px 0px #45D6D6;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        background-color: #2cbbbb;
        border: 1px solid #27A0A0;
        display: inline-block;
        color: #FFFFFF;
        font-size: 14px;
        padding: 8px 18px;
        -webkit-transition: 220ms linear all;
        -moz-transition: 220ms linear all;
        -ms-transition: 220ms linear all;
        -o-transition: 220ms linear all;
        transition: 220ms linear all;
      }
      .input-group input:hover,
      .input-group button:hover {
        -moz-box-shadow: inset 0px 1px 0px 0px #45D6D6, 0px 0px 6px rgba(0,0,0,0.5);
        -webkit-box-shadow: inset 0px 1px 0px 0px #45D6D6, 0px 0px 6px rgba(0,0,0,0.5);
        box-shadow: inset 0px 1px 0px 0px #45D6D6, 0px 0px 6px rgba(0,0,0,0.5);
      }
      .input-group input {
      	border-radius: 4px 0 0 4px;
        width: 75%;
      }
      .input-group button {
      	border-radius: 0 4px 4px 0;
        width: 25%;
        cursor: pointer;
        text-transform: uppercase;
      }
      h1, h2 {
        color: #444;
        margin: 0 0 4px 0;
      }
      h1 { font-size: 42px; }
      h2 { font-size: 16px; }
      hr {
        border-top: 1px solid rgba(0, 0, 0, 0.3);
        border-bottom: 1px solid rgba(255, 255, 255, 0.8);
      }

      #body {
        background: #f7feff;
        background: -moz-linear-gradient(top, #f7feff 1%, #b5dbab 100%);
        background: -webkit-linear-gradient(top, #f7feff 1%,#b5dbab 100%);
        background: linear-gradient(to bottom, #f7feff 1%,#b5dbab 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7feff', endColorstr='#b5dbab',GradientType=0 );
      }

    </style>

    <script src="https://use.fontawesome.com/626934f2f0.js"></script>
  </body>
</html>
