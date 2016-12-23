<?php
$opcoes1 = array('Ótimo', 'Bom', 'Regular', 'Ruim', 'Péssimo');
$opcoes2 = array('Mais que suficiente', 'Suficiente', 'Regular', 'Insuficiente');
$opcoes3 = array('Sim', 'Não', 'Talvez');
$opcoes4 = array('Pesquisa acadêmica', 'Pesquisa aplicada', 'Pesquisa acadêmica e aplicada');
$opcoes5 = array('Palestras', 'Mesa redonda', 'Minicursos', 'Desafio de idéias', 'Mostra tecnológica', 'Mostra de banner', 'Apresentação oral');

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
    'titulo' => "Qual a sua opinião sobre o credenciamento no evento?",
    'opcoes' => $opcoes1
  ),
  3 => array(
    'titulo' => "Qual a sua opinião sobre as diversas atividades ofertadas (palestras, mesa-redonda, minicursos, desafio de idéias, mostra tecnológica, mostra de BANNERS, apresentação ORAL de trabalhos) no evento?",
    'opcoes' => $opcoes1
  ),
  4 => array(
    'titulo' => "Qual destas atividades é indispensável para o próximo CONNEPI?",
    'opcoes' => $opcoes5
  ),
  5 => array(
    'titulo' => "Há alguma atividade que você gostaria de sugerir para o próximo CONNEPI?",
    'opcoes' => ''
  ),
  6 => array(
    'titulo' => "Você gostaria de participar do próximo CONNEPI?",
    'opcoes' => $opcoes3
  ),
  7 => array(
    'titulo' => "De um modo geral, como você avalia o nível científico do XI CONNEPI?",
    'opcoes' => $opcoes1
  ),
  8 => array(
    'titulo' => "Qual a sua percepção com relação aos trabalhos apresentados no XI CONNEPI?",
    'opcoes' => $opcoes4
  ),
  9 => array(
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
  $stmt->bindValue(1, 'participante');
  $stmt->bindValue(2, json_encode($data));
  if($stmt->execute()){
    $msg = "Formulário concluído!";
    echo '<META http-equiv="refresh" content="1;URL=certificado-participante.php">';
  } else {
    $msg = "Erro ao enviar o formulário.";
  }
}

?>

<?php include("header.php"); ?>
<section class="pesquisa">
  <div class="container">

    <div>
      <?php if(!$msg):
        include("formulario.tpl");
      else: ?>
        <h1 class="text-center wow fadeInUp" style="margin:30px 0;"><?php echo $msg;?></h1>
      <?php endif;?>

    </div>
  </div>
</section>
<?php include("footer.php");?>
