<?php
require_once('pdo.php');
$db = DB::init();

$erros = array();
$downloads = array();

if(isset($_POST['email']) && isset($_POST['gerar'])){

  $email = $_POST['email'];
  $__user = $db->query("SELECT * FROM users WHERE email = '$email'")->fetch(PDO::FETCH_ASSOC);

  if($__user){

    // $check = $db->query("SELECT date_completed FROM review_assignments WHERE date_completed IS NOT NULL")->fetch(PDO::FETCH_ASSOC);

    $__ids = $db->query("SELECT paper_id FROM review_assignments WHERE reviewer_id = ".$__user['user_id'])->fetchAll(PDO::FETCH_ASSOC);
    $__titles = array();
    foreach($__ids as $id){
      $__titles[] = $db->query("SELECT setting_value FROM paper_settings WHERE paper_id = ".$id['paper_id']." AND setting_name = 'title'")->fetch(PDO::FETCH_ASSOC);
    }

    if(count($__titles) < 1){
      $erros[] = "Não foi encontrado <i>nenhum</i> artigo avaliado.";
    }

    if(count($erros) < 1){
      $nome_avaliador = strtoupper($__user['first_name'] . ' ' . $__user['middle_name'] . ' ' . $__user['last_name']);
      include_once("mpdf60/mpdf.php");
      $count=0;
      foreach($__titles as $title){
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->autoScriptToLang = true;
        $mpdf->SetDisplayMode('fullpage');
        $css = file_get_contents('cert/style.css');
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML("<html>
        <head></head>
        <body>
        <div style='padding:200px 10px 0 30px;text-align:center;'>
        Certificamos que <b>$nome_avaliador</b> avaliou o projeto intitulado <b>\"".strtoupper($title['setting_value'])."\"</b> submetido no XI CONNEPI – Congresso Norte Nordeste de Pesquisa e Inovação.
        <br><br><br>
        <b style='font-size:18px;'>Maceió, 10 de novembro de 2016</b>
        </div>
        </body></html>");
        $downloads[] = $filename = substr($email, 0, strpos($email, '@')).'__'.$count++;
        $mpdf->Output("cert/gerados/avaliador/$filename.pdf", "F");
      }
    }
    else {
      $erros[] = "O usuário não possui avaliação concluída.";
    }
  }
  else {
    $erros[] = "Usuário não encontrado.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>XI CONNEPI - Certificado de avaliador</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<style>
@keyframes loadingifal {
  0% {opacity: 1}
  50% {opacity: 0.1}
  100% {opacity: 0.9}
}
#carregando {display: none;}
.loading {
  width: 250px; margin: 0 auto;
  padding: 40px 0;
  animation-name: loadingifal;
  animation-iteration-count: infinite;
  animation-duration: 2s;
  text-align: center;
}
</style>
</head>
<body style="background:silver;">

<div style="max-width:820px;margin:60px auto 0 auto;">
  <h1 class="title">Gerar certificado para avaliador</h1>
  <hr />

  <div class="row">
    <form action="certificado.php" method="post" name="form-gerador">
      <div class="input-group">
        <input type="text" name="email" class="form-control" placeholder="E-mail do avaliador...">
        <span class="input-group-btn">
          <button class="btn btn-default" type="submit" name="gerar" value="gerar">Gerar!</button>
        </span>
      </div>
    </form>
  </div>

  <?php if(count($erros) >= 1): ?>
    <div class="row" style="margin-top:5px">
      <div class="alert alert-danger">
        <?php echo(implode('<hr />', $erros)); ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="row" id="carregando">
    <div class="loading">
      <img src="images/logo-3.png" width="100%" />
      <h3>Carregando, aguarde...</h3>
    </div>
  </div>

  <?php if(count($downloads) >= 1): ?>
    <div class="row" style="margin-top:5px" id="pdflist">
      <div class="list-group">
        <a class="list-group-item active">Download por artigo:</a>
        <?php $i=0; foreach($downloads as $filename): ?>
          <a href="cert/gerados/avaliador/<?php echo $filename; ?>.pdf" target="_blank" class="list-group-item"><?php echo strtoupper($__titles[$i++]['setting_value']); ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="row" style="margin-top:10px">
    <div class="well well-lg">
      1. Informe o e-mail cadastrado no OCS.<br>
      2. O certificado só será gerado para os usuários que realizaram avaliação no XI CONNEPI.<br>
      3. Em caso de dúvidas ou problemas, informe usando o formulário de <a href="https://goo.gl/forms/Bl1QUa5cddu5Snx72" target="_blank">suporte</a>.
    </div>
  </div>

</div><!-- container -->
<script src="js/vendor/jquery-1.10.2.min.js"></script>
<script src="js/certificado.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85059492-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
