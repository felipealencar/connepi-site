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
    
  $css = file_get_contents('style_pibit.css');
  
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
$data = readCSV("data/data.csv");

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

// enviou o formulário?
if(isset($_POST['btnBuscar']))
{

  mb_internal_encoding("UTF-8");
  include_once("../mpdf60/mpdf.php");
  
  
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
        $link_download = "certificados/$filename.pdf";
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
    <title>Avaliação parcial Pibic/Pibiti 2016-2017</title>
    <meta charset="utf-8">
  </head>
  <body>
    <section class="pesquisa">
      <div>
        
        <h3>Gerar Certificado</h3>
        <p>Tente buscar seu certificado tanto com letras maiúsculas como minúsculas.</p>
        
        <?php if(count($erros)): ?>
          <ul>
          <?php foreach($erros as $erro): ?>
            <li><?php echo $erro; ?></li>
          <?php endforeach; ?>
          </ul>
        <?php endif; ?>
          
        <?php if(count($gerou)): ?>
        <div class="row">

          <p>Certificado gerado com sucesso.
          <?php $aux = 1; ?>
          <?php if(count($gerou)): ?>
            <?php foreach($gerou as $link): ?>
              <p><a href="<?php echo $link; ?>" target="_blank"><?php echo $aux; ?>. Clique aqui para visualizar.</a></p>
              <?php $aux++; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <?php endif; ?>
          
          <div class="row">
            <form method="post" name="gerar-certificados-avaliadores">       
              <input name="avaliador" type="text" value="<?php (isset($_POST['avaliador'])) ? $_POST['avaliador'] : ''; ?>" />
              <button type="submit" name="btnBuscar" value="gerar">Buscar</button>
            </form>
          </div>    
        </section>
  </body>
</html>