<?php include("header.php"); ?>
<section class="pesquisa">
  <div class="container">

    <?php
    $data = json_decode(str_replace("][", ",", utf8_encode(file_get_contents("respostas-participante.txt"))));
    file_put_contents("respostas-participante.txt", json_encode($data));
    ?>

  </div>
</section>
<?php include("footer.php");?>
