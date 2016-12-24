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

$minicursos = array(
  array('titulo' => 'A arte como potencializador do ensino de ciências', 'link' => 'curso=01'),
  array('titulo' => 'Audiodescrição: usos, possibilidades e inclusão pedagógica no ensino tecnológico', 'link' => 'curso=02'),
  array('titulo' => 'Dança asiática: uma alternativa prática de enriquecimento cultural para a educação', 'link' => 'curso=03'),
  array('titulo' => 'Diz isso de outro jeito: Entonações e interações da voz', 'link' => 'curso=04'),
  array('titulo' => 'Energia Solar Fotovoltaica: Oportunidades do mercado brasileiro e como se capacitar', 'link' => 'curso=06'),
  array('titulo' => 'Indicação Gerográfica e Turismo - Inovação e Desenvolvimento Regional', 'link' => 'curso=07'),
  array('titulo' => 'Introdução à programação de Robôs LEGO', 'link' => 'curso=08'),
  array('titulo' => 'Técnicas Contemporâneas de Aquarela com materiais sustentáveis para a redução de estress', 'link' => 'curso=10'),
  array('titulo' => 'Aprendizagem centrada no aluno: Compartilhando a experiência no modelo educacional finlandês', 'link' => 'curso=11')
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
  $stmt->bindValue(1, 'minicurso');
  $stmt->bindValue(2, json_encode($data));
  if($stmt->execute()){
    $msg = "Formulário concluído!";
  } else {
    $msg = "Erro ao enviar o formulário.";
  }
  $links_cursos = "";
  $i=1;
  foreach($minicursos as $curso){
    $links_cursos .= "<li><a href=\"certificado-minicursos.php?" .$curso['link']. "\" class=\"btn-certificados wow fadeInUp\" data-wow-delay=\"1.{$i}s\"><i class=\"fa fa-share\" aria-hidden=\"true\"></i> " .$curso['titulo']. "</a></li>";
    $i+=1;
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
        <div class="wow fadeIn" data-wow-delay="1s">
          <h2 style="color:white;font-weight:bold;border-bottom:1px solid rgba(0,0,0,0.1);">Selecione o curso</h3>
          <hr />
          <ul><?php echo($links_cursos); ?></ul>
        </div>
      <?php endif;?>

    </div>
  </div>
</section>
<?php include("footer.php");?>
