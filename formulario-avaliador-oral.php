<?php
$opcoes1 = array('Ótimo', 'Bom', 'Regular', 'Ruim', 'Péssimo');
$opcoes2 = array('Mais que suficiente', 'Suficiente', 'Regular', 'Insuficiente');
$opcoes3 = array('Sim', 'Não', 'Talvez');
$opcoes4 = array('Pesquisa acadêmica', 'Pesquisa aplicada', 'Pesquisa acadêmica e aplicada');

$formulario = array(
  0 => array(
    'titulo' => "Qual a sua opinião sobre o XI CONNEPI?",
    'opcoes' => $opcoes1
  ),
  1 => array(
    'titulo' => "Qual a sua opinião sobre as instalações físicas onde ocorreu o XI CONNEPI?",
    'opcoes' => $opcoes1
  ),
  2 => array(
    'titulo' => "Como você considera o sistema de bancas por GRANDE ÁREA estabelecida para o processo de avaliação do XI CONNEPI?",
    'opcoes' => $opcoes1
  ),
  3 => array(
    'titulo' => "Qual a sua opinião sobre o formulário utilizado para a avaliação dos trabalhos durante o XI CONNEPI?",
    'opcoes' => $opcoes1
  ),
  4 => array(
    'titulo' => "As questões contidas no formulário de avaliação foram adequadas para a avaliação dos trabalhos?",
    'opcoes' => $opcoes2
  ),
  5 => array(
    'titulo' => "Qual a sua opinião sobre o tempo disponibilizado para a sessão de exposição dos trabalhos?",
    'opcoes' => $opcoes1
  ),
  6 => array(
    'titulo' => "Você gostaria de participar de outros processos de avaliação?",
    'opcoes' => $opcoes3
  ),
  7 => array(
    'titulo' => "O modelo de apresentação no Powerpoint disponibilizado pela comissão do XI CONNEPI estava adequado para o evento?",
    'opcoes' => $opcoes1
  ),
  8 => array(
    'titulo' => "A quantidade de trabalhos avaliados foi adequada para a sessão de trabalho durante o XI CONNEPI?",
    'opcoes' => $opcoes1
  ),
  9 => array(
    'titulo' => "A quantidade de avaliadores convidada foi adequada para o XI CONNEPI?",
    'opcoes' => $opcoes1
  ),
  10 => array(
    'titulo' => "De um modo geral, como você avalia o nível dos trabalhos que foram apresentados no XI CONNEPI?",
    'opcoes' => $opcoes1
  ),
  11 => array(
    'titulo' => "Qual a sua percepção com relação aos trabalhos apresentados no XI CONNEPI?",
    'opcoes' => $opcoes4
  ),
  12 => array(
    'titulo' => "Você concorda com o formato proposto de avaliação?",
    'opcoes' => $opcoes3
  ),
  13 => array(
    'titulo' => "Por favor, insira neste campo suas críticas, seus elogios e sugestões para a comissão do XI CONNEPI:"
  )
);

require_once("pdo.php");
$db = DB::init();
$msg = false;

// salvando respostas
if(isset($_POST) && !empty($_POST))
{
  $data = array();
  for($i=0; $i<count($formulario); $i++)
  {
    $data[] = array('pergunta' => $formulario[$i]['titulo'], 'resposta' => $_POST["pergunta$i"]);
  }
  
  $sql = "INSERT INTO site_formularios (tipo, dados) VALUES (?,?)";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(1, 'avaliador-oral');
  $stmt->bindValue(2, json_encode($data));
  if($stmt->execute()){
    $msg = "Formulário concluído!";
    echo '<META http-equiv="refresh" content="1;URL=certificado-avaliador.php?modalidade=oral">';
  } else {
    $msg = "Erro ao enviar o formulário.";
  }
}

?>

<?php include("header.php"); ?>
<section class="pesquisa">
  <div class="container">

    <?php if(!$msg):
      include("formulario.tpl");
    else: ?>
      <h1 class="text-center wow fadeInUp" style="margin:30px 0;"><?php echo $msg;?></h1>
    <?php endif;?>

  </div>
</section>
<?php include("footer.php");?>
