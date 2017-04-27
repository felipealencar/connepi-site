<?php
$title_subpage = "Anais";
$dia = [
  7 => [
    'avulsas' => ['titulo' => 'Avulsas', 'totalFotos' => 21],
    'apresentacao-banner' => ['titulo' => 'Apresentação Banner', 'totalFotos' => 373],
    'apresentacao-oral' => ['titulo' => 'Apresentação Oral', 'totalFotos' => 52],
    'desafio-de-ideias' => ['titulo' => 'Desafio de Ideias', 'totalFotos' => 8],
    'minicursos' => ['titulo' => 'Mini Cursos', 'totalFotos' => 6],
    'mostra-tecnologica' => ['titulo' => 'Mostra Tecnológica', 'totalFotos' => 3],
    'palestra' => ['titulo' => 'Palestra', 'totalFotos' => 19]
  ],
  8 => [
    'apresentacao-banner' => ['titulo' => 'Apresentação Banner', 'totalFotos' => 40],
    'apresentacao-oral' => ['titulo' => 'Apresentação Oral', 'totalFotos' => 66],
    'desafio-de-ideias' => ['titulo' => 'Desafio de Ideias', 'totalFotos' => 1],
    'fortec' => ['titulo' => 'Fortec', 'totalFotos' => 24],
    'mesa-redonda' => ['titulo' => 'Mesa Redonda', 'totalFotos' => 25],
    'minicursos' => ['titulo' => 'Mini Cursos', 'totalFotos' => 20],
    'mostra-tecnologica' => ['titulo' => 'Mostra Tecnológica', 'totalFotos' => 71],
    'palestra' => ['titulo' => 'Palestra', 'totalFotos' => 18],
    'premiacao' => ['titulo' => 'Premiação', 'totalFotos' => 19],
    'sala-de-imprensa' => ['titulo' => 'Sala de Imprensa', 'totalFotos' => 4],
    'vendedores' => ['titulo' => 'Vendedores', 'totalFotos' => 12],
  ],
  9 => [
    'avulsas' => ['titulo' => 'Avulsas', 'totalFotos' => 18],
    'apresentacao-banner' => ['titulo' => 'Apresentação Banner', 'totalFotos' => 81],
    'apresentacao-oral' => ['titulo' => 'Apresentação Oral', 'totalFotos' => 54],
    'encerramento' => ['titulo' => 'Encerramento', 'totalFotos' => 72],
    'mesa-redonda' => ['titulo' => 'Mesa Redonda', 'totalFotos' => 7],
    'minicursos' => ['titulo' => 'Mini Cursos', 'totalFotos' => 31],
    'mostra-tecnologica' => ['titulo' => 'Mostra Tecnológica', 'totalFotos' => 8],
    'organizacao' => ['titulo' => 'Organização', 'totalFotos' => 22],
    'palestra' => ['titulo' => 'Palestra', 'totalFotos' => 13],
    'reuniao-de-reitores' => ['titulo' => 'Reunião de Reitores', 'totalFotos' => 19],
    'vendedores' => ['titulo' => 'Vendedores', 'totalFotos' => 4],
  ],
];

include("header.php"); ?>

<section class="ta-hero">
    <div class="container">
      <h1 class="anais-title wow fadeIn" style="color:#fff;">Anais do XI CONNEPI</h1>

      <?php if(!isset($_GET['dia']) || empty($_GET['dia'])): ?>
      <!-- ========================
            Seleção de dias
      ========================= -->
      <div class="row anais-dias">
        <div class="col-md-6 col-md-offset-3">
          <h2 class="wow fadeIn">Dezembro de 2016</h2>
          <div class="wow fadeInUp col-md-3 col-lg-3 col-sm-3 col-xs-3" data-wow-delay="0.1s">
            <span>T</span>
            <a href="anais.php?dia=6">6</a>
          </div>
          <div class="wow fadeInUp col-md-3 col-lg-3 col-sm-3 col-xs-3" data-wow-delay="0.2s">
            <span>Q</span>
            <a href="anais.php?dia=7">7</a>
          </div>
          <div class="wow fadeInUp col-md-3 col-lg-3 col-sm-3 col-xs-3" data-wow-delay="0.3s">
            <span>Q</span>
            <a href="anais.php?dia=8">8</a>
          </div>
          <div class="wow fadeInUp col-md-3 col-lg-3 col-sm-3 col-xs-3" data-wow-delay="0.4s">
            <span>S</span>
            <a href="anais.php?dia=9">9</a>
          </div>
        </div>
      </div>
      <?php else: ?>
      <!-- ===============================
          Exibição dos dias
      ================================ -->
      <div class="row wow fadeIn anais-dia"w>

        <?php if($_GET['dia'] == 6):?>
          <!-- /////// DIA 06.12.16 \\\\\\\\ -->
          <h2>terça, 6 de dezembro <a href="anais.php?dia=7"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></h2>
          <?php for($v=1;$v<=35;$v++):?>
            <div class="anais-dia-item col-lg-2 col-md-3 col-sm-3 col-xs-6">
              <a href="files/materiais_anais/dia6/imagem%20(<?php echo($v); ?>).JPG" data-lity data-lity-target="files/materiais_anais/dia6/imagem%20(<?php echo($v); ?>).JPG">
                <img src="files/materiais_anais/dia6/imagem%20(<?php echo($v); ?>).JPG"/>
              </a>
            </div>
          <?php endfor;?>
        <?php endif;?>

        <?php if($_GET['dia'] >= 7 && $_GET['dia'] <= 9):?>
          <!-- /////// DIA > 6 \\\\\\\\ -->
          <?php $dia_prev = ($_GET['dia'] >= 7)? $_GET['dia']-1 : false; ?>
          <?php $dia_next = ($_GET['dia'] <= 8)? $_GET['dia']+1 : false; ?>
          <h2>
            <?php if($dia_prev !== false): ?>
              <a href="anais.php?dia=<?php echo($dia_prev);?>"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
            <?php endif;?>
            terça, <?php echo($_GET['dia']);?> de dezembro
            <?php if($dia_next !== false): ?>
            <a href="anais.php?dia=<?php echo($dia_next);?>"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
            <?php endif;?>
          </h2>
          <div class="row anais-dia-links-galeria">
            <?php foreach($dia[$_GET['dia']] as $key => $value):?>
              <a class="col-lg-2 col-md-4 col-sm-4 col-xs-6 btn btn-default btn-home" href="anais.php?dia=<?php echo($_GET['dia']);?>&galeria=<?php echo($key);?>"><?php echo($value['titulo']);?></a>
            <?php endforeach; ?>
          </div>
          <?php if(!isset($_GET['galeria']) || empty($_GET['galeria'])):?>
            <h2 style="margin-top:40px;">Selecione uma galeria</h2>
          <?php else:?>
            <!-- /////// EXIBE A GALERIA ESPECIFICADO EM $_GET['galeria'] \\\\\\\\ -->
            <h2 style="margin-top:40px;"><?php echo $dia[$_GET['dia']][$_GET['galeria']]['titulo']; ?></h2>
            <?php for($v=1;$v<=$dia[$_GET['dia']][$_GET['galeria']]['totalFotos'];$v++):?>
              <div class="anais-dia-item col-lg-2 col-md-3 col-sm-3 col-xs-6">
                <a href="files/materiais_anais/dia<?php echo($_GET['dia']) ?>/<?php echo($_GET['galeria']) ?>/imagem%20(<?php echo($v); ?>).JPG" data-lity data-lity-target="files/materiais_anais/dia<?php echo($_GET['dia']) ?>/<?php echo($_GET['galeria']) ?>/imagem%20(<?php echo($v); ?>).JPG">
                  <img src="files/materiais_anais/dia<?php echo($_GET['dia']) ?>/<?php echo($_GET['galeria']) ?>/imagem%20(<?php echo($v); ?>).JPG"/>
                </a>
              </div>
            <?php endfor;?>
          <?php endif;?>
          <!-- /////// FIM - DIA 07.12.16 \\\\\\\\ -->
        <?php endif;?>

      </div><!-- .row anais-dia -->
      <?php endif; ?>


    </div><!-- .container -->
</section><!-- .ta-hero -->

<?php include("footer.php"); ?>
