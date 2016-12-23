<?php
$opcoes1 = array('Ótimo', 'Bom', 'Regular', 'Ruim', 'Péssimo');
$opcoes2 = array('Mais que suficiente', 'Suficiente', 'Regular', 'Insuficiente');
$opcoes3 = array('Sim', 'Não', 'Talvez');
$opcoes4 = array('Pesquisa acadêmica', 'Pesquisa aplicada', 'Pesquisa acadêmica e aplicada');
$opcoes5 = array('Palestras', 'Mesa redonda', 'Minicursos', 'Desafio de idéias', 'Mostra tecnológica', 'Mostra de banner', 'Apresentação oral');
$opcoes6 = array('Sim', 'Não');

$formulario = array(
  0 => array(
    'titulo' => "Qual a sua opinião sobre o minicurso no qual participou durante o XI CONNEPI?",
    'opcoes' => $opcoes1
  ),
  1 => array(
    'titulo' => "Qual a sua opinião sobre as instalações físicas onde ocorreram o minicurso durante o XI CONNEPI?",
    'opcoes' => $opcoes1
  ),
  2 => array(
    'titulo' => "Qual a sua opinião sobre o tempo de duração dos minicursos do XI CONNEPI?",
    'opcoes' => $opcoes1
  ),
  3 => array(
    'titulo' => "De um modo geral, como você avalia as temáticas abordadas pelos minicursos ofertados XI CONNEPI?",
    'opcoes' => $opcoes1
  ),
  4 => array(
    'titulo' => "Você se inscreveria novamente em minicursos ofertados pelo próximo CONNEPI?",
    'opcoes' => $opcoes6
  ),
  5 => array(
    'titulo' => "Por favor, insira neste campo suas críticas, seus elogios e sugestões para a comissão do XI CONNEPI:"
  )
);

$msg = false;
// salvando respostas
if(isset($_POST) && !empty($_POST))
{
  $for_text = array();
  for($i=0; $i<count($formulario); $i++)
  {
    $for_text[] = array('pergunta' => $formulario[$i]['titulo'], 'resposta' => $_POST["pergunta$i"]);
  }
  file_put_contents("respostas-minicursos.txt", json_encode($for_text), FILE_APPEND);
  $msg = "Formulário concluído!";
  echo '<META http-equiv="refresh" content="1;URL=certificado-participante.php">';
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
