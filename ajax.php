<?php  

require_once('pdo.php');
$db = DB::init();	

//apenas pra assegurar que o que vai entrar aqui é o formulário
if(count($_POST) && isset($_POST['form']) && $_POST['form'] == 'avaliador')
{
	$erroValidacao = array();

	$dados['nome'] 		= (isset($_POST['nome']) && !empty($_POST['nome'])) 
		? $_POST['nome'] 
		: $erroValidacao['nome'] = 'required';

	$dados['email'] 		= (isset($_POST['email']) && !empty($_POST['email'])) 
		? $_POST['email'] 
		: $erroValidacao['email'] = 'required';	

	$dados['cpf'] 		= (isset($_POST['cpf']) && !empty($_POST['cpf']))
		? $_POST['cpf'] 
		: $erroValidacao['cpf'] = 'required';

	$dados['titulacao'] = (isset($_POST['titulacao']) && !empty($_POST['titulacao']))
		? $_POST['titulacao'] 
		: $erroValidacao['titulacao'] = 'required';

	$dados['lattes'] 	= (isset($_POST['lattes']) && !empty($_POST['lattes'])) 
		? $_POST['lattes'] 
		: $erroValidacao['lattes'] = 'required';

	$dados['grande_area'] 	= (isset($_POST['grande_area']) || !empty($_POST['grande_area']))
		? $_POST['grande_area'] 
		: $erroValidacao['grande_area'] = 'required';	

	$dados['area'] 	= (isset($_POST['area']) || !empty($_POST['area']))
		? $_POST['area'] 
		: $erroValidacao['area'] = 'required';	
	
	$dados['sub_area'] 	= (isset($_POST['sub_area']) && (count($_POST['sub_area']) || !empty($_POST['sub_area'])))
		? $_POST['sub_area'] 
		: $erroValidacao['sub_area'] = 'required';	
	
	$dados['especialidade'] 	= (isset($_POST['especialidade']) && (count($_POST['especialidade']) || !empty($_POST['especialidade'])))
		? $_POST['especialidade'] 
		: $erroValidacao['especialidade'] = 'required';	

	if(count($erroValidacao))
	{

		$msgsErro = array();
		$dicionarioDeCampos = array(
			'nome' => 'Nome',
			'cpf' => 'CPF',
			'titulacao' => 'Titulação',
			'lattes' => 'Lattes',
			'grande_area' => 'Grande Área',
			'email' => 'E-mail',
			'area' => 'Área de Conhecimento',
			'sub_area' => 'Sub Área',
			'especialidade' => 'Especialidades',
		);

		foreach($erroValidacao as $campo => $regra)
		{
			if($regra == 'required')
			{
				$msgsErro[]	= "O campo {$dicionarioDeCampos[$campo]} é obrigatório";
			}
		}

		header('Content-Type: application/json');
		header('Status', true, 422);
		echo json_encode(array('erros' => $msgsErro));
		exit(0);		
	}

	try{

		
		$sqlInsert = 'INSERT INTO site_avaliadores (nome, cpf, titulacao, lattes, criado_em, area, email) VALUES (?,?,?,?,?,?,?)';
		
		$objPDO = $db->prepare($sqlInsert);
		//$objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$objPDO->bindValue(1, $dados['nome']);
		$objPDO->bindValue(2, $dados['cpf']);
		$objPDO->bindValue(3, $dados['titulacao']);
		$objPDO->bindValue(4, $dados['lattes']);
		$objPDO->bindValue(5, date('Y-m-d'));

		$areas = array(
			'grande_area' => $dados['grande_area'],
			'area' => $dados['area'],
			'sub_areas' => $dados['sub_area'],
			'especialides' => $dados['especialidade']
		);
		
		$objPDO->bindValue(6, serialize($areas));
		
		$objPDO->bindValue(7, $dados['email']);

		$objPDO->execute();
		
		$avaliadorID = $db->lastInsertId();
		header('Content-Type: application/json');
		echo json_encode(array('sucesso' => 'Registro criado com sucesso!'));
		exit(0);


	}catch(Exception $e){

		header('Content-Type: application/json');
		echo json_encode(array('erros' => 'Não foi possível criar o registro.'));
		exit(0);

	}

}

if(isset($_GET['cod_grande_area'])){

	$sql = "select * from site_areas_conhecimento WHERE cod_grande_area = '{$_GET['cod_grande_area']}' ORDER BY nome_area ASC";

}elseif(isset($_GET['cod_area'])){

	$sql = "select * from site_sub_areas WHERE cod_area = '{$_GET['cod_area']}' ORDER BY nome_sub_area ASC";

}elseif(isset($_GET['cod_sub_area'])){
	
	$subareas = implode("','", $_GET['cod_sub_area']);
	$sql = "select * from site_especialidades WHERE cod_sub_area IN ('{$subareas}') ORDER BY nome_especialidade ASC";

}

$response = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($response);
exit(0);

?>