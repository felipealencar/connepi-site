<?php

class DB extends PDO
{
    private static $db = null;
    public static function init()
    {
        if (is_null(self::$db) === true)
        {
            self::$db = new PDO( "pgsql:dbname=ocs; user=sistema_ocs; password=10s#th7if@l; host=192.168.253.46; port=5432" );
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						// self::$db = new PDO("pgsql:dbname=ocs; user=postgres; password=postgres; host=localhost; port=5432");
        }
        return self::$db;
    }

    public static function resultado_pesquisa_satisfacao($tipo){
      $opcoes1 = array('Ótimo', 'Bom', 'Regular', 'Ruim', 'Péssimo');
      $opcoes2 = array('Mais que suficiente', 'Suficiente', 'Regular', 'Insuficiente');
      $opcoes3 = array('Sim', 'Não', 'Talvez');
      $opcoes4 = array('Pesquisa acadêmica', 'Pesquisa aplicada', 'Pesquisa acadêmica e aplicada');
      $opcoes5 = array('Palestras', 'Mesa redonda', 'Minicursos', 'Desafio de idéias', 'Mostra tecnológica', 'Mostra de banner', 'Apresentação oral');
      $opcoes6 = array('Sim', 'Não');

      if($tipo == 'minicurso'){
        $resultado = array(
          0 => array(
            'titulo' => "Qual a sua opinião sobre o minicurso no qual participou durante o XI CONNEPI?",
            'total' => array(
              'Ótimo' => 0,
              'Bom' => 0,
              'Regular' => 0,
              'Ruim' => 0,
              'Péssimo' => 0
            )
          ),
          1 => array(
            'titulo' => "Qual a sua opinião sobre as instalações físicas onde ocorreram o minicurso durante o XI CONNEPI?",
            'total' => array(
              'Ótimo' => 0,
              'Bom' => 0,
              'Regular' => 0,
              'Ruim' => 0,
              'Péssimo' => 0
            )
          ),
          2 => array(
            'titulo' => "Qual a sua opinião sobre o tempo de duração dos minicursos do XI CONNEPI?",
            'total' => array(
              'Ótimo' => 0,
              'Bom' => 0,
              'Regular' => 0,
              'Ruim' => 0,
              'Péssimo' => 0
            )
          ),
          3 => array(
            'titulo' => "De um modo geral, como você avalia as temáticas abordadas pelos minicursos ofertados XI CONNEPI?",
            'total' => array(
              'Ótimo' => 0,
              'Bom' => 0,
              'Regular' => 0,
              'Ruim' => 0,
              'Péssimo' => 0
            )
          ),
          4 => array(
            'titulo' => "Você se inscreveria novamente em minicursos ofertados pelo próximo CONNEPI?",
            'total' => array(
              'Sim' => 0,
              'Não' => 0
            )
          ),
          5 => array(
            'titulo' => "Por favor, insira neste campo suas críticas, seus elogios e sugestões para a comissão do XI CONNEPI:"
          )
        );
      }

      self::init();
      $sql = "SELECT dados FROM site_formularios WHERE tipo = '{$tipo}'";
      $stmt = self::$db->prepare($sql);
      if($stmt->execute()){
        $resultado_stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($resultado_stmt as $row__){
          $row = json_decode($row__['dados']);
          for($i = 0; $i < count($row)-1; $i++){
            $resultado[$i]['total'][$row[$i]->resposta] = $resultado[$i]['total'][$row[$i]->resposta] + 1;
          }
        }
      }

      $total = count($resultado_stmt);
      echo "
      <div class=\"alert alert-info\">
        Resultado da pesquisa de satisfação dos {$tipo}<br>
        Total de respostas até o momento: {$total}
      </div>
      ";
      for($i=0; $i < count($resultado)-1; $i++){
        echo "
        <div class=\"alert alert-success wow fadeInUp\">
        <h3 style=\"font-weight:bold;\">{$resultado[$i]['titulo']}</h3>
        <hr style=\"border-top:1px solid #bbb9b8;margin:20px 0;\">
        <table class=\"table table-striped table-hover\">
        <thead>
          <tr class=\"success\">
            <th>Opção</th>
            <th>Total</th>
            <th>Percentual</th>
          </tr>
        </thead>
        <tbody>
        ";
        foreach($resultado[$i]['total'] as $key => $value){
          $value_porcent = round((($value/$total)*100), 2);
          echo "<tr class=\"success\">";
            echo "<td>{$key}</td>";
            echo "<td>{$value}</td>";
            echo "<td>{$value_porcent}%</td>";
          echo "</tr>";
        }
        echo "</tbody></table></div>";
      }
    }
}

?>
