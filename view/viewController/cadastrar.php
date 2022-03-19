<?php session_start();
require_once('../../controller/tarefa.php');
require_once('../../controller/usuario.php');
$tarefa = new Tarefa();
$usuario = new Usuario();

if (!(isset($_SESSION['dadosUsuario']))) {
    header("Location: inc/logout.php");
}else{
  $dados = $_SESSION['dadosUsuario'];
  foreach ($dados as $key => $value) {  
  }
}
if (isset($_POST['btn_cadastrar_tarefa'])) {

	$nomeTarefa = $_POST['nomeTarefa'];
	$especialidadeTarefa = $_POST['selectEspecialidade'];
	$descricaoTarefa = $_POST['descricaoTarefa'];
	$prazoTarefa = $_POST['prazoTarefa'];
	$metaHorasMensal = $_POST['metaHorasMensal'];
	$tipoTarefa = $_POST['selectTipoTarefa'];
	$projetoBase = $_POST['selectProjetos'];
	$idStatus = 1;
	$prazo = date('Y-m-d H:i:s', strtotime($prazoTarefa));
	$metaHoras = date('H:i:s', strtotime($metaHorasMensal));
	$idUsuario = $value["idUsuario"];
	$dataCriacao = date('Y-m-d H:i:s');


	//CREATE - Caso não haja Projeto, a tarefa em questão será um projeto principal
	if ($projetoBase == null) {

		$tabela = 'tarefa';
		$colunas = ['nomeTarefa, descricaoTarefa, dataCriacao, prazoTarefa, metaHorasMensal, idUsuario, idTipoTarefa, idStatus, idEspecialidade'];
		$valores = [''."'$nomeTarefa'".', '."'$descricaoTarefa'".', '."'$dataCriacao'".', '."'$prazo'".', '."'$metaHoras'".', '."'$idUsuario'".', '."'$tipoTarefa'".', '."'$idStatus'".', '."'$especialidadeTarefa'".''];
		$tarefa = new Tarefa();
		$tarefa->create($tabela, $colunas, $valores);
		header('Location: ../usuario/minhas-tarefas.php');
	}
	//CREATE - Caso haja um projeto, a tarefa em questão será uma tarefa referente ao projeto selecionado
	else{

		$tabela = 'tarefa';
		$colunas = ['nomeTarefa, descricaoTarefa, dataCriacao, prazoTarefa, metaHorasMensal, idUsuario, idTipoTarefa, idStatus, FK_idTarefa, idEspecialidade'];
		$valores = [''."'$nomeTarefa'".', '."'$descricaoTarefa'".', '."'$dataCriacao'".', '."'$prazo'".', '."'$metaHoras'".', '."'$idUsuario'".', '."'$tipoTarefa'".', '."'$idStatus'".','."'$projetoBase'".', '."'$especialidadeTarefa'".''];
		$tarefa = new Tarefa();
		$tarefa->create($tabela, $colunas, $valores);		
	}
	header('Location: ../usuario/minhas-tarefas.php');

}
elseif(isset($_POST['btn_cadastrar_usuario'])) {

	$nomeUsuario = $_POST['nomeUsuario'];
	$emailUsuario = $_POST['emailUsuario'];
	$senhaUsuario = sha1($_POST['senhaUsuario']);
	$idTipoUsuario = 1;

	//CREATE
	$tabela = 'usuario';
	$colunas = ['nomeUsuario, emailUsuario, senhaUsuario, idTipoUsuario'];
	$valores = [''."'$nomeUsuario'".', '."'$emailUsuario'".', '."'$senhaUsuario'".','."'$idTipoUsuario'".''];
	$usuario = new Usuario();

	if ($usuario->verificaExistencia($emailUsuario)) {
		try {
			$usuario->create($tabela, $colunas, $valores);
			header('Location: ../../index.php');

		} catch (Exception $e) {
			print($e);
		}
	}else{
		print("Usuario já cadastrado!");
	}

}


if (isset($_POST['btn-adiciona-especialidade'])) {

	$idUsuario = $_POST['idUsuario'];

	$idEspecialidade = $_POST['selectEspecialidade'];


	$senha = sha1($_POST['senha']);

	$tabela = 'usuario';
	$condicao = 'idUsuario = "'.$idUsuario.'"';
	$valores = $usuario->find($tabela, $condicao);

	if ($senha == $valores['senhaUsuario']) {
		//VERIFICAR SE A ESPECIALIDADE JÁ ESTÁ CADASTRADA
		$tabela = 'listaespecialidade';
		$condicao = 'idEspecialidade = "'.$idEspecialidade.'" AND idUsuario = "'.$idUsuario.'"';
		$valores = $tarefa->find($tabela, $condicao);
		if ($valores) {
			echo "O usuário já tem essa especialidade.";
		}

		else{
			try {
			$model = new Model();
			$tabela = 'listaespecialidade';
			//Parâmetros do find
			$condicao2 = 'idUsuario = "'.$idUsuario.'"';
			//Parâmetros do create
			$colunas = ['idEspecialidade, idUsuario'];
			$valores = ["'$idEspecialidade'".','."'$idUsuario'"];

			$contaResultados = $model->contaResultados($tabela, $condicao2);
			if ($contaResultados >= 5) {
				echo("Você só pode ter 5 especialidades...");
			}else{
				$model->create($tabela, $colunas, $valores);
				header('Location: ../usuario/meu-perfil.php');	
			}

		} catch (Exception $e) {
			echo $e;
		}

		}		
	}else{
		echo "A senha não confere";
	}	


}
