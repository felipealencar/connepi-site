<form class="form-horizontal" id="formulario" method="post">
  <h1>Pesquisa de satisfação</h1>
  <fieldset>

    <div class="form-group">
      <?php for($i=0; $i<count($formulario)-1; $i++):?>
      <label class="pergunta"><?php echo $i+1 . '. '. $formulario[$i]['titulo'];?></label>
        <?php if(is_array($formulario[$i]['opcoes'])): ?>
          <?php foreach($formulario[$i]['opcoes'] as $opcao):?>
            <div class="radio">
              <label class="opcoao-repsosta">
                <input value="<?php echo $opcao;?>" type="radio" name="pergunta<?php echo $i;?>" required>
                <span><?php echo $opcao;?></span>
              </label>
            </div>
          <?php endforeach;?>
        <?php else: ?>
          <input class="form-control" name="pergunta<?php echo $i;?>" required placeholder="Inserir texto">
        <?php endif; ?>
      <?php endfor;?>
    </div>
    <div class="form-group">
      <label class="pergunta"><?php echo $formulario[count($formulario)-1]['titulo'];?></label>
      <textarea class="form-control" name="pergunta<?php echo count($formulario)-1;?>" rows="3" required></textarea>
    </div>
    <div class="form-group">
      <button class="btn btn-success" type="submit" name="btnEnviar">Enviar</button>
      <button class="btn btn-default" type="reset" name="btnLimpar">Limpar</button>
    </div>

  </fieldset>
</form>

<div id="intro">
  <h1 class="text-center wow fadeInUp" style="margin:30px 0;">
    Antes de gerar o certificado, gostariamos que você respondesse algumas perguntas quanto ao XI CONNEPI.
  </h1>
  <div class="text-center">
    <a id="continuar" class="wow fadeInUp" data-wow-delay="0.5s">Certo, continuar...</a>
  </div>
</div>
