<?php include('anais_config.php');
$discus_pageUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$discus_pageIdentifier = (isset($_GET['dia'])) ? 'Galeria_Dia_'.$_GET['dia'] : 'none';
?>

<!DOCTYPE html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>XI CONNEPI - Anais</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
<link href='http://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/lity.css">
<link rel="stylesheet" href="css/anais/style.css">
</head>
<body>

<div class="container animated">

  <div class="sidebar">
    <div class="sidebar-header"></div><!-- .sidebar-header -->
    <button class="toggleNav"><i class="fa fa-bars" aria-hidden="true"></i></button>
    <nav class="sidebar-nav">
      <a href="anais.php">Inicio</a>
      <a href="javascript:;" data-sub="videos">Vídeos <i class='fa fa-chevron-down' aria-hidden='true'></i></a>
      <div class="sub <?php echo (isset($_GET['video'])) ? 'active' : ''; ?>" id="sub-videos">
        <a href="anais.php?video=abertura-evento">Abertura do evento</a>
        <a href="anais.php?video=desafio-de-ideias">Desafio de Ideias</a>
        <a href="anais.php?video=encerramento-e-premiacao">Encerramento e Premiação</a>
        <a href="anais.php?video=patrocinadores">Patrocinadores</a>
      </div>
      <?php echo $sidebarNav; ?>
    </nav><!-- .sidebar-nav -->
  </div><!-- .sidebar -->

  <div class="content">
    <div class="content-header">
      <h1><?php echo ($showGaleria) ? $showGaleriaHeader: "Anais do XI CONNEPI"; ?></h1>
    </div><!-- .content-header -->

    <?php if(!$showVideo && !$showGaleria && (!isset($_GET) || empty($_GET))):?>
      <div class="content-entry">
        <h2>Bem vindo ao Anais do XI CONNEPI</h2>
        <hr style="margin:20px 0;border-top:none;border-bottom:1px solid #6f6f6f;"/>
        <p style="font-size:14px;font-style:italic;">Visualize as galerias navegando no menu à esquerda, elas estão agrupadas por dias e, organizadas em categorias.</p>
      </div><!-- .content-entry -->
    <?php endif;?>

    <?php if($showVideo):?>
      <!-- INICIO VÍDEO -->
      <div class="content-entry">
        <h1><?php echo $videoTitle; ?></h1>
        <div class="video">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/<?=$videoId;?>?rel=0&amp;showinfo=0?ecver=1" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="comments">
          <h2>Comentários</h2>
          <p style="text-transform:uppercase; margin-top:10px; font-size:11px;"><?=$videoTitle;?></p>
          <?php include('discus_view.php');?>
        </div><!-- .comments -->
      </div><!-- .content-entry -->
      <!-- FIM VÍDEO -->
    <?php endif;?>

    <?php if($showGaleria):?>
      <!-- INICIO GALERIA DE FOTOS -->
      <div class="content-entry">
        <div class="thumbs-roll">
          <div class="thumbs" style="width:<?=$widthThumbnails;?>px;">
            <?php echo $thumbnails; ?>
          </div><!-- .thumbs -->
          <span class="next" data-control="next"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></span>
          <span class="prev" data-control="prev"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></span>
        </div><!-- .thumbs-roll -->
        <div class="foto">
          <?php echo $fotoInicial; ?>
        </div>
        <div class="comments">
          <h2>Comentários</h2>
          <p style="text-transform:uppercase; margin-top:10px; font-size:11px;"><?=$showGaleriaHeaderComentarios;?></p>
          <?php include('discus_view.php');?>
        </div><!-- .comments -->
      </div><!-- .content-entry -->
      <!-- FIM GALERIA DE FOTOS -->
    <?php endif;?>

  </div><!-- .content -->

</div>

<script src="js/vendor/jquery-1.10.2.min.js" charset="utf-8"></script>
<script src="js/lity.min.js" charset="utf-8"></script>
<script id="dsq-count-scr" src="//horarioescolar.disqus.com/count.js" async></script>
<script src="js/anais/scripts.js" charset="utf-8"></script>

</body>
</html>
