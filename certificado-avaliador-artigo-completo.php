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
    $artigos = array();
    foreach($__titles as $row){
      $artigos[] = $row['setting_value'];
    }

    if(count($__titles) < 1){
      $erros[] = "Não foi encontrado <i>nenhum</i> artigo avaliado.";
    }

    if(count($erros) < 1){
      $nome_avaliador = strtoupper($__user['first_name'] . ' ' . $__user['middle_name'] . ' ' . $__user['last_name']);
      include_once("mpdf60/mpdf.php");
      $mpdf = new mPDF('utf-8', 'A4-L');
      $mpdf->autoScriptToLang = true;
      $mpdf->SetDisplayMode('fullpage');
      $css = file_get_contents('cert/style2.css');
      $mpdf->WriteHTML($css, 1);
      $mpdf->WriteHTML(str_replace('{var_nome}', $nome_avaliador, file_get_contents('cert/modelo.html')));
      $mpdf->WriteHTML(str_replace('{var_artigos}', implode('<br><br>', $artigos), file_get_contents('cert/blank.html')));

      $downloads[] = $filename = substr($email, 0, strpos($email, '@'));
      $mpdf->Output("cert/gerados/avaliador-artigo/completo/$filename.pdf", "F");
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
<?php include("header.php");?>

<section class="pesquisa">
  <div style="max-width:820px;margin:60px auto 0 auto;">
    <h1 class="title">Gerar certificado para avaliador</h1>
    <hr />

    <div class="row">
      <form method="post" name="form-gerador">
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
          <a href="cert/gerados/avaliador-artigo/completo/<?php echo $filename; ?>.pdf" target="_blank" class="btn btn-info btn-block">
            Visualizar/Imprimir certificado
          </a>
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
</section>
<?php include("footer.php");?>
