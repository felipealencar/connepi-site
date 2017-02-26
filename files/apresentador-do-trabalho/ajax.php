<?php

if(isset($_POST['apresentadores'])){
	$data = $_POST['apresentadores'];
	if(file_put_contents('dados-certificado-apresentadores.json', $data) !== false){
		echo 'Sucesso';
	} else {
		echo 'Erro';
	}
	exit(0);
}
