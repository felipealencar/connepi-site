<?php
  require_once('pdo.php');
  $db = DB::init(); 
  $grandeArea = $db->query('select * from site_grandes_areas ORDER BY nome_area ASC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>XI CONNEPI - Avaliadores</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Place favicon.ico  -->
  <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
  <!-- Fonts -->
  <!-- Lato -->
  <link href='http://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- CSS -->

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/owl.carousel.css">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/main.css">
  <!-- Responsive Stylesheet -->
  <link rel="stylesheet" href="css/responsive.css">
</head>

<body id="body">

 <div id="preloader">
  <div class="book">
    <div class="book__page"></div>
    <div class="book__page"></div>
    <div class="book__page"></div>
  </div>
</div>

    <!-- 
    Header start
    ==================== -->
    <div class="navbar-default navbar-fixed-top animated" id="navigation">
     <div class="container">
       <!-- Brand and toggle get grouped for better mobile display -->
       <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
           <span class="sr-only">Navegação</span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="index.html">
          <img class="logo-1" src="images/logo.png" alt="LOGO">
          <img class="logo-2" src="images/logo-2.png" alt="LOGO">
        </a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <nav class="collapse navbar-collapse" id="navbar">
       <ul class="nav navbar-nav navbar-right" id="top-nav">
         <li class="current"><a href="#body">Principal</a></li>
         <li><a href="#about">Sobre o evento</a></li>
         <li><a href="#location">Local do evento</a></li>
         <li><a href="#authors">Autores</a></li>
         <li><a href="#programacao">Programação</a></li>
         <li><a href="#">Inscrição</a></li>
       </ul>
     </nav><!-- /.navbar-collapse -->
   </div><!-- /.container-fluid -->
 </div>
 

 <section class="section" id="cadastro-de-avaliadores">
  <div class="container">

    <div class="retorno hidden">      
    </div>

    <form class="form-ajax" action="ajax.php" method="post">
      <div class="row">

        <div class="col-md-3">
          <div class="form-group">
            <label for="nome">Nome Completo <span>*</span></label>
            <input type="text" class="form-control input-lg" id="nome" name="nome">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="email">E-mail <span>*</span></label>
            <input type="text" class="form-control input-lg" id="email" name="email">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="cpf">CPF <span>*</span></label>    
            <input type="text" class="form-control input-lg" id="cpf" placeholder="999.999.999-99" name="cpf">
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="titulacao">Titulação <span>*</span></label>    
            <select class="form-control input-lg" name="titulacao">
              <option value="">Selecione</option>
              <option value="Mestre">Mestre</option>
              <option value="Doutor">Doutor</option>
            </select>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label for="lattes">Lattes <span>*</span></label>
            <textarea class="form-control" name="lattes" rows="3"></textarea>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="">Grande Área<span>*</span></label>
            <select class="form-control input-lg grandes-areas" name="grande_area">
              <?php if(count($grandeArea)): ?>
                <option value="">Selecione</option>
                <?php foreach($grandeArea as $area): ?>
                  <option value="<?php echo $area['cod_area'] ?>"><?php echo $area['nome_area'] ?></option> 
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="">Áreas de Conhecimento<span>*</span></label>
            <select class="form-control input-lg areas" name="area">
                <option value="">Selecionar - Grande Área</option>
            </select>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="">Sub Área de Conhecimento<span>*</span></label>
            <select class="form-control input-lg sub-areas" name="sub_area" multiple="5">
                <option value="">Selecionar - Área de Conhecimento</option>
            </select>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <label for="">Especialidades<span>*</span></label>
            <select class="form-control input-lg especialidades" name="especialidade" multiple="5">
                <option value="">Selecionar - Sua Área</option>
            </select>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <input type="hidden" name="form" value="avaliador">
            <button type="submit" class="btn btn-success btn-lg">Enviar</button>
          </div>
        </div>

      </div>
    </form>
  </div>
</section>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="block">
          <p>Coordenadoria de Informática (Campus Maceió) | Diretoria de Tecnologia da Informação | Pró-Reitoria de Pesquisa e Inovação</p>
        </div>
      </div>
    </div>
  </div>
</footer>


<!-- Js -->
<script src="js/vendor/modernizr-2.6.2.min.js"></script>
<script src="js/vendor/jquery-1.10.2.min.js"></script>
<script src="js/jquery.lwtCountdown-1.0.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/jquery.form.js"></script>
<script src="js/jquery.nav.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/plugins.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>