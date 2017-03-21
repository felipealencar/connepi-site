<?php
$title_subpage = "Trabalhos premiados";
include("header.php"); ?>

<section class="ta-hero">
  <div class="container">

    <h1 class="ta-premiados-title wow fadeInDown">Trabalhos Premiados</h1>
    <h2 class="ta-premiados-section wow">Área acadêmica</h2>

    <div id="ta-premiados-menu" class="wow fadeIn" data-wow-delay="0.3s">
      <div class="ta-area-tematica ta-area-ciencias-exatas" data-area="CIÊNCIAS EXATAS E DA TERRA"></div>
      <div class="ta-area-tematica ta-area-ciencias-biologicas" data-area="CIÊNCIAS BIOLÓGICAS"></div>
      <div class="ta-area-tematica ta-area-engenharias" data-area="ENGENHARIAS"></div>
      <div class="ta-area-tematica ta-area-ciencias-da-saude" data-area="CIÊNCIAS DA SAÚDE"></div>
      <div class="ta-area-tematica ta-area-ciencias-agrarias" data-area="CIÊNCIAS AGRÁRIAS"></div>
      <div class="ta-area-tematica ta-area-ciencias-sociais-aplicadas" data-area="CIÊNCIAS SOCIAIS APLICADAS"></div>
      <div class="ta-area-tematica ta-area-ciencias-humanas" data-area="CIÊNCIAS HUMANAS"></div>
      <div class="ta-area-tematica ta-area-lla" data-area="LINGUÍSTICA, LETRAS E ARTES"></div>
      <div class="ta-area-tematica ta-area-multidisciplinar" data-area="MULTIDISCIPLINAR"></div>
    </div>

    <div id="ta-modalidades-menu" class="wow fadeIn">
      <div>
        <a class="ta-modalidade" href="javascript:;" id="BANNER">
          BANNER
          <img src="images/apresentacao_banner.png" />
        </a>
      </div>
      <div>
        <a class="ta-modalidade" href="javascript:;" id="ORAL">
          ORAL
          <img src="images/apresentacao_oral.png" />
        </a>
      </div>
    </div>

    <div id="ta-premiados-ranking">
    </div>

  </div><!-- .ta-hero-entry -->
</section><!-- .ta-hero -->

<?php include("footer.php"); ?>
