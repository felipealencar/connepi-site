<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Certificados da avaliação parcial Pibic/Pibiti 2016-2017" />
    <meta name="author" content="Anilson Lopes (@quilamcz)">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <title>Avaliação parcial Pibic/Pibiti 2016-2017</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  </head>
  <body>

  <section class="container-fluid">
    <div>

      <h3>Gerar Certificado</h3>
      <p>Tente buscar seu certificado tanto com letras maiúsculas como minúsculas.</p>

      <?php if(count($erros)): ?>
      <ul class="alert alert-danger">
      <?php foreach($erros as $erro): ?>
        <li><?php echo $erro; ?></li>
      <?php endforeach; ?>
      </ul>
      <?php endif; ?>

      <?php if(count($gerou)): ?>
      <div class="row">
        <p>Certificado gerado com sucesso.
        <?php $aux = 1; ?>
        <?php if(count($gerou)): ?>
          <?php foreach($gerou as $link): ?>
            <p><a class="btn btn-default" href="<?php echo $link; ?>" target="_blank"><?php echo $aux; ?>. <span class="label label-info">Clique aqui para visualizar</span></a></p>
            <?php $aux++; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <?php endif; ?>

        <div class="row">
          <div class="col-md-6 col-offset-3">
            <form method="post" name="gerar-certificados-avaliadores">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="" name="avaliador" value="<?php (isset($_POST['avaliador'])) ? $_POST['avaliador'] : ''; ?>">
                <span class="input-group-btn">
                  <button class="btn btn-default" name="btnBuscar" type="submit" value="gerar">Go!</button>
                </span>
              </div><!-- /input-group -->
            </form>
          </div><!-- /.col-md-6 -->
        </div><!-- /.row -->
      </section>

  </body>
</html>
