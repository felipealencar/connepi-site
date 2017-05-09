<?php
$galeria = array(

    6 => array(
      'avulsas' => array('titulo' => 'Avulsas', 'totalFotos' => 35)
    ),
    7 => array(
      'avulsas' => array('titulo' => 'Avulsas', 'totalFotos' => 21),
      'apresentacao-banner' => array('titulo' => 'Apresentação Banner', 'totalFotos' => 373),
      'apresentacao-oral' => array('titulo' => 'Apresentação Oral', 'totalFotos' => 52),
      'desafio-de-ideias' => array('titulo' => 'Desafio de Ideias', 'totalFotos' => 8),
      'minicursos' => array('titulo' => 'Mini Cursos', 'totalFotos' => 6),
      'mostra-tecnologica' => array('titulo' => 'Mostra Tecnológica', 'totalFotos' => 3),
      'palestra' => array('titulo' => 'Palestra', 'totalFotos' => 19)
    ),
    8 => array(
      'apresentacao-banner' => array('titulo' => 'Apresentação Banner', 'totalFotos' => 40),
      'apresentacao-oral' => array('titulo' => 'Apresentação Oral', 'totalFotos' => 66),
      'desafio-de-ideias' => array('titulo' => 'Desafio de Ideias', 'totalFotos' => 1),
      'fortec' => array('titulo' => 'Fortec', 'totalFotos' => 24),
      'mesa-redonda' => array('titulo' => 'Mesa Redonda', 'totalFotos' => 25),
      'minicursos' => array('titulo' => 'Mini Cursos', 'totalFotos' => 20),
      'mostra-tecnologica' => array('titulo' => 'Mostra Tecnológica', 'totalFotos' => 71),
      'palestra' => array('titulo' => 'Palestra', 'totalFotos' => 18),
      'premiacao' => array('titulo' => 'Premiação', 'totalFotos' => 19),
      'sala-de-imprensa' => array('titulo' => 'Sala de Imprensa', 'totalFotos' => 4),
      'vendedores' => array('titulo' => 'Vendedores', 'totalFotos' => 12)
    ),
    9 => array(
      'avulsas' => array('titulo' => 'Avulsas', 'totalFotos' => 18),
      'apresentacao-banner' => array('titulo' => 'Apresentação Banner', 'totalFotos' => 81),
      'apresentacao-oral' => array('titulo' => 'Apresentação Oral', 'totalFotos' => 54),
      'encerramento' => array('titulo' => 'Encerramento', 'totalFotos' => 72),
      'mesa-redonda' => array('titulo' => 'Mesa Redonda', 'totalFotos' => 7),
      'minicursos' => array('titulo' => 'Mini Cursos', 'totalFotos' => 31),
      'mostra-tecnologica' => array('titulo' => 'Mostra Tecnológica', 'totalFotos' => 8),
      'organizacao' => array('titulo' => 'Organização', 'totalFotos' => 22),
      'palestra' => array('titulo' => 'Palestra', 'totalFotos' => 13),
      'reuniao-de-reitores' => array('titulo' => 'Reunião de Reitores', 'totalFotos' => 19),
      'vendedores' => array('titulo' => 'Vendedores', 'totalFotos' => 4)
    ),

);

// Links da sidebarNav
$sidebarNav = "";
foreach($galeria as $key => $value){
  $subActiveClass = (isset($_GET['dia']) && $_GET['dia'] == $key) ? 'active' : '';
  $sidebarNav .= "<a href='javascript:;' data-sub='{$key}'>Fotos do dia 0{$key}.12.2017</a>";
  $sidebarNav .= "<div class='sub {$subActiveClass}' id='sub-{$key}'>";
  foreach($value as $key_value => $value_value){
    $linkGaleria = "dia={$key}&galeria={$key_value}";
    $sidebarNav .= "<a href='anais.php?{$linkGaleria}'>{$value_value['titulo']}</a>";
  }
  $sidebarNav .= "</div>";
}

// Galeria e thumbs
$showGaleria = false;
if(isset($_GET['dia']) && isset($_GET['galeria']) && !empty($_GET['dia']) && !empty($_GET['galeria'])){
  $getDia = $_GET['dia'];
  $getGaleria = $_GET['galeria'];
  $getTitulo = $galeria[$getDia][$getGaleria]['titulo'];
  $totalFotosGaleria = $galeria[$getDia][$getGaleria]['totalFotos'];
  $showGaleriaHeader = "Dia 0{$getDia}.12.16 - {$getTitulo}";
  $showGaleriaHeaderComentarios = "Dia: 0{$getDia}.12.2016<br/>Galeria: {$getTitulo}";
  $showGaleria = true;

  $widthThumbnails = 0;
  $thumbnails = "";
  $jgpOuJPG = ($getDia == 9) ? 'JPG' : 'jpg';
  for($i=1; $i<=$totalFotosGaleria; $i++){
    $linkImagem = "files/materiais_anais/dia{$getDia}/{$getGaleria}/imagem%20({$i}).{$jgpOuJPG}";
    $linkImagemThumb = "files/materiais_anais/thumbs/dia{$getDia}/{$getGaleria}/imagem%20({$i}).jpg";
    $thumbnails .= "<a class='img-tigger' href='javascript:;' data-target='{$linkImagem}'><img src='{$linkImagemThumb}' /></a>";
    $widthThumbnails += 85;
  }
  $fotoInicial = "<a href='{$linkImagem}' class='img-target-a' data-lity data-lity-target='files/materiais_anais/dia{$getDia}/{$getGaleria}/imagem%20(1).{$jgpOuJPG}'><img class='img-target' src='files/materiais_anais/dia{$getDia}/{$getGaleria}/imagem%20(1).{$jgpOuJPG}' /></a>";
}

// Vídeo
$showVideo = false;
if(isset($_GET['video']) && !empty($_GET['video'])){
  $showVideo = true;
  $videos = array(
    'abertura-evento' => array('title' => 'Abertura do evento', 'id' => 'ommjEqtgkfI'),
    'desafio-de-ideias' => array('title' => 'Desafio de ideias', 'id' => 'CexktpcdnpE'),
    'encerramento-e-premiacao' => array('title' => 'Encerramento e premiação', 'id' => 'rWpHy6d8wZM'),
    'patrocinadores' => array('title' => 'Patrocinadores', 'id' => 'vpoJFkKYPwQ'),
  );
  $getVideo = $_GET['video'];
  $videoTitle = 'Vídeo: ' . $videos[$getVideo]['title'];
  $videoId = $videos[$getVideo]['id'];
}

?>
