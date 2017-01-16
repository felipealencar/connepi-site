<?php
require_once('pdo.php');
$db = DB::init();

$erros = array();
$downloads = array();

if(isset($_POST['email']) && isset($_POST['gerar'])){

  $email = trim($_POST['email']);
  $__user = $db->query("SELECT user_id, first_name, middle_name, last_name FROM users WHERE email = '$email'")->fetch(PDO::FETCH_ASSOC);

  if(!$__user){
    $erros[] = "Usuário não encontrado.";
  }
  else
  {
    // $check = $db->query("SELECT date_completed FROM review_assignments WHERE date_completed IS NOT NULL")->fetch(PDO::FETCH_ASSOC);
    $__ids = $db->query("SELECT paper_id FROM review_assignments WHERE reviewer_id = ".$__user['user_id'])->fetchAll(PDO::FETCH_ASSOC);
    $artigos = array();
    foreach($__ids as $id)
    {
      $_title = $db->query("SELECT setting_value FROM paper_settings WHERE paper_id = ".$id['paper_id']." AND setting_name = 'title'")->fetch(PDO::FETCH_ASSOC);
      $artigos[] = strtoupper($_title['setting_value']);
    }

    if(count($artigos) < 1){
      $erros[] = "Não foi encontrado <b>nenhum</b> artigo avaliado.";
    }

    if(count($erros) > 0){
      $erros[] = "O usuário não possui avaliação concluída.";
    }
    else
    {
      include_once("mpdf60/mpdf.php");
      $css = file_get_contents('cert/style2.css');
      $nome_avaliador = strtoupper($__user['first_name'] . ' ' . $__user['middle_name'] . ' ' . $__user['last_name']);
      $nicename = substr($email, 0, strpos($email, '@'));
      $count = 0;
      // Gera um certificado por título [{(o.o)}]
      foreach($artigos as $titulo_artigo)
      {
        $filename = $nicename.'_'.$count;
        $file_url = "cert/gerados/avaliador-artigo/normal/$filename.pdf";
        $downloads[$count]['titulo'] = $titulo_artigo;
        $downloads[$count]['url'] = $file_url;
        if(!file_exists($file_url))
        {
          $mpdf = new mPDF('utf-8', 'A4-L');
          $mpdf->autoScriptToLang = true;
          $mpdf->SetDisplayMode('fullpage');
          $mpdf->WriteHTML($css, 1);
          $mpdf->WriteHTML(str_replace(array('{var_nome}','{var_titulo}'), array($nome_avaliador, $titulo_artigo), file_get_contents('cert/modelo_single.html')));
          $mpdf->Output($file_url, "F");
        }
        $count++;
      }
    }
  }
}
?>
<?php include("header.php");?>

<section class="pesquisa">
  <div style="max-width:820px;margin:60px auto 0 auto;">
    <h1 class="title">Gerar certificado para avaliador de artigo</h1>
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
          <h3 style="color:white;margin:30px 0;">Os certificados abriram em uma nova aba.</h3>
          <div class="well well-lg">
          <?php foreach($downloads as $certificado):?>
              <a href="<?php echo $certificado['url'];?>" target="_blank"><?php echo($certificado['titulo']);?></a>
              <hr/>
          <?php endforeach;?>
        </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="row" style="margin-top:10px">
      <div class="well well-lg">
        1. Informe o <b>e-mail</b> cadastrado no OCS.<br>
        2. O certificado só será gerado para os usuários que realizaram avaliação no XI CONNEPI.<br>
        3. Em caso de dúvidas ou problemas, informe usando o <a href="https://goo.gl/forms/Bl1QUa5cddu5Snx72" target="_blank">formulário de suporte</a>.
      </div>
    </div>

  </div><!-- container -->
</section>
<?php include("footer.php");?>
