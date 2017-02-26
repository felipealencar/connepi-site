<?php

//from php.net
function utf8_fopen_read($fileName) {
    $fc = iconv('ISO-8859-1//TRANSLIT', 'utf-8', file_get_contents($fileName));
    $handle = fopen("php://memory", "rw");
    fwrite($handle, $fc);
    fseek($handle, 0);
    return $handle;
}

function readCSV($csvFile)
{
	$row = 1;
	$__return = array();
	if (($handle = utf8_fopen_read($csvFile, "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$num = count($data);
			for ($c=0; $c < $num; $c++) {
				$__return[$row] = $data;
			}
			$row++;
		}
		fclose ($handle);
		return $__return;
	}
}
$erros = array();
$downloads = array();

if(isset($_POST['inputName'])){

  $inputName = strtoupper($_POST['inputName']);

  $data = readCSV("files/participantes_crendeciamento.CSV");
  $nao_pode = array('4E400 DESIGN E GESTÃO EMPRESARIAL', 'ACOMPANHANTE', 'AUSENTE', 'AVALIADOR', 'C', 'CM CONSTRUÇÕES', 'CONVIDADO', 'EMBAIXADA DA FINLANDIA', 'EMPRESA FERNÃO VELHO',
  'F5 CONSULTORIA', 'FERNÃO VELHO', 'FILMART', 'FORTLINE CORP', 'FRM', '');

  $participantes = array();
  for($i=0; $i<count($data); $i++){
    if($i > 1 && !in_array($data[$i][1], $nao_pode)){
      $participantes[] = trim(strtoupper($data[$i][0]), ',');
    }
  }
  // ===========================================================================
  // Outros participantes
  $participantes[] = strtoupper('Maria Carolina Paiva Rodrigues'); // carol.rodrigues0807@hotmail.com
  $participantes[] = strtoupper('Leila Soares Viegas Barreto Chagas'); // leila_viegas@hotmail.com
  $participantes[] = strtoupper('Ayrton Pereira Correia de Barros Júnior'); // ayrtonbarros_jr@hotmail.com
  $participantes[] = strtoupper('João Ricardo Serique Bernardo'); // ayrtonbarros_jr@hotmail.com
  $participantes[] = strtoupper('MONICA SILVEIRA'); // monica.silveira@ifba.edu.br
  $participantes[] = strtoupper('FLÁVIO FABIANO PASCIÊNCIA TORRES'); // flavio.mat@hotmail.com
  $participantes[] = strtoupper('Ricardo José Ferreira'); // ricardo.jferreir@gmail.com
  $participantes[] = strtoupper('Pedro Henrique de Morais Martins'); // moraispeedro@gmail.com
  $participantes[] = strtoupper('Bismarc Lopes da Silva'); // bismarc.bjl@gmail.com
  $participantes[] = strtoupper('JOSEANE PINHEIRO DE LIMA'); // educador.geografia@hotmail.com
  $participantes[] = strtoupper('Francisco Eudes da Silva'); // eudessylva@hotmail.com
  $participantes[] = strtoupper('Antônia Isabela Soares Ximenes'); // isabelaximenes52@gmail.com
  $participantes[] = strtoupper('Mayára Gomes Targino'); // may.targino@gmail.com
  $participantes[] = strtoupper('Ayslanny Thuany Araújo de Oliveira'); // ayslannythuany@hotmail.com
  $participantes[] = strtoupper('Dalviane Ferreira Sousa'); // dfsousa.ifce.cb@gmail.com
  $participantes[] = strtoupper('Maria de Lordes da Paixão Santos'); // lourdinhapaixao@hotmail.com
  $participantes[] = strtoupper('PATRÍCIA PEREIRA DA SILVA '); // patthypds@gmail.com
  $participantes[] = strtoupper('Izaqueu Rodrigues da Silva'); // zaqueurs212@gmail.com
  $participantes[] = strtoupper('Marisvania Batista Lima'); // bl-marabatista12@hotmail.com
  $participantes[] = strtoupper('Maria Luciana da Silva Mesquita'); // lucianamesquita2013@gmail.com
  $participantes[] = strtoupper('Ricardo Barbosa Bitencourt'); // ricardo.bitencourt@gmail.com
  $participantes[] = strtoupper('Karla Rachel Jarsen de Melo Calheiros'); // karlaarachel@hotmail.com
  $participantes[] = strtoupper('Francisco de Assis Damasceno Alves Junior'); // juniormoreira60@gmail.com
  $participantes[] = strtoupper('Jiovane Anderson da Silva Ribeiro'); // jiovaneribeiro.ifro@gmail.com
  $participantes[] = strtoupper('Vinícius de Castro Santos'); // vinicius2014best@outlook.com
  $participantes[] = strtoupper('Thiago Gregorio de Oliveira'); // thiagogregorio7@live.com
  $participantes[] = strtoupper('Clênio Renê Kurz Böhmer'); // cleniob@gmail.com
  $participantes[] = strtoupper('Luciane de Paula Machado'); // luciane@ifto.edu.br
  $participantes[] = strtoupper('Josué Dantas Rodrigues da Silva'); // josuedantasete@hotmail.com
  $participantes[] = strtoupper('Juliana Protacio dos Santos'); // juliana-protacio-santos@hotmail.com
  $participantes[] = strtoupper('Rogério Mendes Murta'); // rogerio.murta@ifnmg.edu.br
  $participantes[] = strtoupper('Ana Paula Barbosa Silvestre'); // paulacpcg@hotmail.com
  $participantes[] = strtoupper('Thaylanne Alcântara Matos'); // thaylannematos@hotmail.com
  $participantes[] = strtoupper('GERONIMO BARBOSA ALEXANDRE'); // GERONIMO.ALEXANDRE@GARANHUNS.IFPE.EDU.BR
  $participantes[] = strtoupper('Juan Gabriel de Albuquerque Ramos'); // juanfne@gmail.com
  $participantes[] = strtoupper('Larissa Lira Guimarães'); // larisa_lira@hotmail.com
  $participantes[] = strtoupper('elba gomes dos santos'); // elbagomes@ifba.edu.br
  $participantes[] = strtoupper('Renata Gomes Pimentel'); // pimentel.ufal@gmail.com
  $participantes[] = strtoupper('Silvane Maria Monteiro de Sousa'); // silvane_sousa14@hotmail.com
  $participantes[] = strtoupper('MARIA APARECIDA GONÇALVES DOS SANTOS'); // aparecidagsantos94@gmail.com
  $participantes[] = strtoupper('MARIA FILOMENA SILVA HONORATO'); // filomenahonorato@gmail.com
  $participantes[] = strtoupper('Sebastião da Silva Malaquias '); // sabagatinho@hotmail.com
  $participantes[] = strtoupper('Clêiany Pereira de Sousa'); // cleianny156@gmail.com
  $participantes[] = strtoupper('LUKAS ANGELIM MATOS'); // lukasangelim95@gmail.com
  $participantes[] = strtoupper('VILSON LACERDA BRASILEIRO JUNIOR'); // vilson.brasileiro@ifpb.edu.br
  $participantes[] = strtoupper('FABRICIO CARVALHO DA SILVA'); // fabriciocarvalho44@hotmail.com
  $participantes[] = strtoupper('Ester Doanni da Silva Ferreira Dias'); // esterdoani@yahoo.com.br
  $participantes[] = strtoupper('JOSE OSVALDO HARRY'); // OSVALDOHARRY@GMAIL.COM
  $participantes[] = strtoupper('GERONIMO BARBOSA ALEXANDRE'); // GERONIMO.ALEXANDRE@EE.UFCG.EDU.BR
  $participantes[] = strtoupper('Maria Luciana da Silva Mesquita'); // lucianamesquita2013@gmail.com
  $participantes[] = strtoupper('Roberto Gil Rodrigues Almeida'); // gabinete.reitoria@iftm.edu.br
  $participantes[] = strtoupper('maria aparecida gonçalves dos santos'); // aparecidagsantos94@gmail.com
  $participantes[] = strtoupper('Iasmin Marques Rocha'); // iasminmarques14@gmail.com
  $participantes[] = strtoupper('Reinaldo Vinícius Morais Pereira'); // reinaldovinicius63@gmail.com
  $participantes[] = strtoupper('antônio francisco de Assis sobrinho'); // alagoasdgt@gmail.com
  $participantes[] = strtoupper('Edvânia Valério da Silva Cavalcante'); // edvaniacavalcante@hotmail.com.br
  $participantes[] = strtoupper('Edvania Kehrle Bezerra'); // edvaniakb@gmail.com
  $participantes[] = strtoupper('Hiago Oliveira de Jesus'); // hodj.lic@uea.edu.br
  $participantes[] = strtoupper('Ricardo Nascimento do Carmo'); // ricardo.nascimento@acad.ifma.edu.br
  $participantes[] = strtoupper('Thaylanne Alcântara Matos'); // thaylannematos@hotmail.com
  $participantes[] = strtoupper('Mírian Cavalcante Silva'); // miriancavalcantee@hotmail.com
  $participantes[] = strtoupper('Andressa Camilo de Souza'); // andressacamilosouza@hotmail.com
  $participantes[] = strtoupper('Carla Marina da Silva Tôrres de Sousa Dias'); // carlamarina@ifma.edu.br
  $participantes[] = strtoupper('Fabiana Santos da silva'); // santosfabiana802@gmail.com
  $participantes[] = strtoupper('Juliana Protacio dos Santos'); // juliana-protacio-santos@hotmail.com
  $participantes[] = strtoupper('ANA KAROLINY DE SOUZA GOMES'); // akaroliny98@gmail.com
  $participantes[] = strtoupper('Sérgio Luis Melo Viroli'); // prof.viroli@gmail.com
  $participantes[] = strtoupper('KARLA RACHEL JARSEN DE MELO CALHEIROS'); // karlaarachel@hotmail.com
  $participantes[] = strtoupper('arthur felipe graciano de andrade'); // arthurfelandrade@gmail.com
  $participantes[] = strtoupper('Gustavo Maciel Macário das Neves'); // guga.m.neves@gmail.com
  $participantes[] = strtoupper('Thiago de Loiola Araújo e Silva'); // engtiagolas@hotmail.com
  $participantes[] = strtoupper('Flávia Rhuana Pereira Sales'); // flavia.rhuana@outlook.com
  $participantes[] = strtoupper('SÓSTENES GOMES DE SOUSA'); // sostenes-sousa@hotmail.com
  $participantes[] = strtoupper('Edvânia Valério da Silva Cavalcante'); // edvaniacavalcante@hotmail.com.br
  $participantes[] = strtoupper('iuri nobre dos santos'); // urigomesbaiano@gmail.com
  $participantes[] = strtoupper('Paulo Ditarso Maciel Jr.'); // paulo.maciel@ifpb.edu.br
  $participantes[] = strtoupper('ALDO DA SILVA OLIVEIRA'); // aldobio17@gmail.com
  $participantes[] = strtoupper('VALMIR DOS SANTOS JÚNIOR'); // valmirjr.stos@outlook.com
  $participantes[] = strtoupper('jessica valesca benicio da nobrega'); // jercika_valesca@hotmail.com
  $participantes[] = strtoupper('José Dilton Lima dos Santos'); // diltonhistoria@bol.com.br
  $participantes[] = strtoupper('Maria de Fatima Oliveira da Silva '); // marya_cz@hotmail.com
  $participantes[] = strtoupper('Marina Duarte de Souza Rolim'); // marinaduartecz@gmail.com
  $participantes[] = strtoupper('MATHEUS BRENO DOS SANTOS MOURA'); // matheusb.brenos@gmail.com
  $participantes[] = strtoupper('Anna Karoliny Braga Moreira'); // annakarolinybm@gmail.com
  $participantes[] = strtoupper('Caio Braga Ferreira'); // caiobragaferreira@gmail.com
  $participantes[] = strtoupper('SAULO LOPES DE SOUSA'); // saulo.sousa@ifma.edu.br
  $participantes[] = strtoupper('JOSÉ RIBEIRO DA SILVA'); // jorinetos@gmail.com
  $participantes[] = strtoupper('Naidia Kessia Cavalcante Bezerra'); // naidiakessia@yahoo.com.br
  $participantes[] = strtoupper('Júlia Rafaela de Araújo Santana da Silva'); // j.rafaela14@gmail.com
  $participantes[] = strtoupper('Matheus Soares Limeira'); // msoareslimeira.msl@gmail.com
  $participantes[] = strtoupper('LUÍS GUSTAVO DE MATTOS BARBOSA'); // sarinhaaag@gmail.com
  $participantes[] = strtoupper('edvania valerio da silva cavalcante'); // edvaniacavalcante@hotmail.com.br
  $participantes[] = strtoupper('FRANCISCA ADRIANA MONTEIRO DE SOUSA'); // adriana.monteiro.cedro@hotmail.com
  $participantes[] = strtoupper('Ábner Lucas Alves Pereira'); // abner_l@hotmail.com
  $participantes[] = strtoupper('RENATA CIBELY FREIRE'); //
  $participantes[] = strtoupper('Erick Batalha Freitas'); // erickbatalha96@gmail.com
  $participantes[] = strtoupper('Camila Monteiro Penz'); // camilaapenz@gmail.com
  $participantes[] = strtoupper('FRANCISCA ADRIANA MONTEIRO DE SOUSA '); // adriana.monteiro.cedro@hotmail.com
  $participantes[] = strtoupper('Jéssica Valesca Benício da Nóbrega'); // jercika_valesca@hotmail.com
  $participantes[] = strtoupper('Thayara Ferreira Coimbra Lima'); // thayara@ifma.edu.br
  $participantes[] = strtoupper('Mery Angela Ramos de Andrade'); // merangela@hotmail.com
  $participantes[] = strtoupper('Antonio Jorlan Soares de Abreu'); // antonio.abreu@ifma.edu.br
  $participantes[] = strtoupper(''); //
  $participantes[] = strtoupper(''); //
  // ===========================================================================

  function buscaParticipante($inputName, $participantes){
    $out = array();
    foreach($participantes as $key => $value){
      if(strpos($value, $inputName) !== false){
        $out[] = $value;
      }
    }
    return $out;
  }

  $busca_resultado = (buscaParticipante($inputName, $participantes)) ? buscaParticipante($inputName, $participantes) : false;

  if($busca_resultado){
    include_once("mpdf60/mpdf.php");
    $css = file_get_contents('cert/style.css');

    $count = 0;
    foreach($busca_resultado as $participante){

      $filename = strtolower(str_replace(' ', '_', trim(iconv('UTF-8', 'ASCII//TRANSLIT', $participante), ',')));
      for($i=0; $i<strlen($filename); $i++){
        if(strpos("abcdefghijklmnopqrstuvxzwy0123456789_-", $filename[$i]) === false){
          $filename[$i] = '_';
        }
      }

      $link_download = "cert/gerados/participante/$filename.pdf";

      if(!file_exists($link_download)){
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->autoScriptToLang = true;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML("<html>
        <head></head>
        <body>
        <div style='padding:200px 10px 0 30px;text-align:center;'>
        Certificamos que <b>$participante</b> participou do XI CONNEPI – Congresso Norte Nordeste de Pesquisa e Inovação, que ocorreu no período de 06 a 09 de dezembro de 2016, no Hotel Ritz Lagoa da Anta, na cidade de Maceió - Alagoas.
        <br><br><br>
        <b style='font-size:18px;'>Maceió, 09 de dezembro de 2016.</b>
        </div>
        </body></html>");
        $mpdf->Output($link_download, "F");
      }
      $downloads[$count] = array();
      $downloads[$count]['nome'] = $participante;
      $downloads[$count]['linkDownload'] = $link_download;
      $count++;
    }
  } else {
    $erros[] = "Usuário não encontrado ou não possui instituição.";
  }
}
?>

<?php include("header.php"); ?>

<section class="pesquisa">
  <div style="max-width:820px;margin:60px auto 0 auto;">

    <h1 class="title">Gerar certificado</h1>
    <hr />

    <div class="row">
      <form action="certificado-participante.php" method="post" name="form-gerador">
        <div class="input-group">
          <input type="text" name="inputName" class="form-control" placeholder="Nome do participante">
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit" name="btnGerar" value="gerar">Buscar</button>
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

    <?php if(count($downloads) > 0): ?>
      <div class="row" style="margin-top:5px" id="pdflist">
        <div class="list-group">

          <?php if(count($downloads) > 1): ?>
          <a target="_blank" class="list-group-item active">Participantes encontrados:</a>
          <?php else: ?>
          <a target="_blank" class="list-group-item active">Participante encontrado:</a>
          <?php endif; ?>

          <?php foreach($downloads as $download): ?>
          <a href="<?php echo $download['linkDownload']; ?>" target="_blank" class="list-group-item"><?php echo $download['nome']; ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="row" style="margin-top:10px">
      <div class="well well-lg">
        1. Informe seu nome.<br>
        2. O certificado só será gerado para os usuários que participaram do XI CONNEPI.<br>
        3. Em caso de dúvidas ou problemas, informe usando o formulário de <a href="https://goo.gl/forms/Bl1QUa5cddu5Snx72" target="_blank">suporte</a>.
      </div>
    </div>
  </div>
</section><!-- container -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85059492-1', 'auto');
  ga('send', 'pageview');

</script>

<?php include("footer.php"); ?>
