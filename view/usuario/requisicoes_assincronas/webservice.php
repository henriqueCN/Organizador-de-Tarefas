<?php session_start();
$dados = $_SESSION["dadosUsuario"];
$dados = $_SESSION['dadosUsuario'];

if (!(isset($_SESSION['dadosUsuario']))) {
    header("Location: inc/logout.php");
}else{
  $dados = $_SESSION['dadosUsuario'];
  foreach ($dados as $key => $value) {  
  }
}

require_once('config.php');
require_once('../../../model/model.php');

$idUsuario = $value["idUsuario"];
$nomeUser = $value["nomeUsuario"];
$emailUser = $value["emailUsuario"];
$retorno = array();

if($_GET['acao'] == 'inserirIntegrante'){

	//------------------------------Observação Importante Desta Função---------------------------------------//
					//==================A Tabela Equipe não pode ser AUTOINCREMENT================//


	//Nome da equipe passado pelo input
	$nomeEquipe = $_GET['nomeEquipe'];

	//Email recebido pelo input
	$emailIntegrante = $_GET['emailIntegrante'];

	//ID do projeto que vai receber um integrante
	$projetoEquipe = $_GET['projeto'];
	

	//Procura os dados com base no email passado (lembre-se que o email é único)
	$sql = $pdo->prepare("SELECT idUsuario, nomeUsuario, emailUsuario FROM usuario WHERE emailUsuario = :emailUsuario LIMIT 6");
	$sql->bindValue(":emailUsuario", $emailIntegrante, PDO::PARAM_STR);
	$sql->execute();	
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['emailUsuario'][$n] = $ln->emailUsuario;
		$retorno['idUsuario'][$n]    = $ln->idUsuario;
		$n++;
	}

	//Pegamos os dados do usuário para inserí-lo como integrante na tabela equipe
	$emailUsuario = $retorno["emailUsuario"][0];
	$idUsuarioIntegrante = $retorno["idUsuario"][0];

	//------------------------Variáveis de inserção na tabela Equipe-------------------------//
	//-----------------
	$tabela = 'equipe';
	//-----------------

	
	/*Inserir Dado na Tabela Equipe*/
	$tabelaEquipe = 'equipe';
	$colunaIdEquipe = 'idEquipe';

	//----Instânciando a Model
	$model = new Model();
	//-------------------

	//----Encontrando o próximo ID
	$autoIncrement = $model->findAutoIncrement($tabelaEquipe, $colunaIdEquipe);
	$idAtualEquipe = $autoIncrement["contaId"];
	//-------------------------------------------------------------------------//

	//---------------Definindo Parâmetros da Tabela Equipe--------------------//
	$colunasEquipe = ['idEquipe, nomeEquipe'];
	$parametrosEquipe = ['"'.$idAtualEquipe.'","'.$nomeEquipe.'"'];
	$model->create($tabela, $colunasEquipe, $parametrosEquipe);

	/*Inserir Dado na Tabela ListaEquipe*/
	$tabelaLista = 'listaequipe';

	if ($projetoEquipe == '0') {
		$colunas = ['idUsuario , idUsuarioIntegrante, idEquipe'];
		$parametrosDeCreateLista = ['"'.$idUsuario.'","'.$idUsuarioIntegrante.'","'.$idAtualEquipe.'"'];
	}else{
		$colunas = ['idUsuario , idUsuarioIntegrante, idEquipe, idTarefa'];
		$parametrosDeCreateLista = ['"'.$idUsuario.'","'.$idUsuarioIntegrante.'","'.$idAtualEquipe.'","'.$projetoEquipe.'"'];
	}
	
	

	//Instância da Classe Model
	$model = new Model();

		$model->create($tabelaLista, $colunas, $parametrosDeCreateLista);
		echo("Novo Integrante Inserido a Tabela de Lista de Equipes.");
	$sql = '';	
}


if($_GET['acao'] == 'inserirTarefa'){
	$nomeTarefa = $_GET['nomeTarefa'];
	$especialidadeTarefa = $_GET['especialidadeTarefa'];
	$descricaoTarefa = $_GET['descricaoTarefa'];
	$prazoTarefa = $_GET['prazoTarefa'];
	$metaHorasMensal = $_GET['metaHorasMensal'];
	$tipoTarefa = $_GET['selectTipoTarefa'];
	$projetoBase = $_GET['valorSelect'];
	$idStatus = 1;

	$prazo = date('Y-m-d H:i:s', strtotime($prazoTarefa));
	$metaHoras = date('H:i:s', strtotime($metaHorasMensal));
	$idUsuario = $value["idUsuario"];
	$dataCriacao = date('Y-m-d H:i:s');

	if ($projetoBase == null) {

		$tabela = 'tarefa';
		$colunas = ['nomeTarefa, descricaoTarefa, dataCriacao, prazoTarefa, metaHorasMensal, idUsuario, idTipoTarefa, idStatus, idEspecialidade'];
		$valores = [''."'$nomeTarefa'".', '."'$descricaoTarefa'".', '."'$dataCriacao'".', '."'$prazo'".', '."'$metaHoras'".', '."'$idUsuario'".', '."'$tipoTarefa'".', '."'$idStatus'".', '."'$especialidadeTarefa'".''];
		$model = new Model();
		$model->create($tabela, $colunas, $valores);
		echo"eita caceta";
	}
	//CREATE - Caso haja um projeto, a tarefa em questão será uma tarefa referente ao projeto selecionado
	else{

		$tabela = 'tarefa';
		$colunas = ['nomeTarefa, descricaoTarefa, dataCriacao, prazoTarefa, metaHorasMensal, idUsuario, idTipoTarefa, idStatus, FK_idTarefa, idEspecialidade'];
		$valores = [''."'$nomeTarefa'".', '."'$descricaoTarefa'".', '."'$dataCriacao'".', '."'$prazo'".', '."'$metaHoras'".', '."'$idUsuario'".', '."'$tipoTarefa'".', '."'$idStatus'".','."'$projetoBase'".', '."'$especialidadeTarefa'".''];
		$model = new Model();
		$model->create($tabela, $colunas, $valores);		
	}

	
}

if($_GET['acao'] == 'listarEmails'){
	$emailUsuario = $_GET['email'];
	if ($emailUsuario == '') {
		false;
	}
	else{
	$sql = $pdo->prepare("SELECT idUsuario, nomeUsuario, emailUsuario FROM usuario WHERE emailUsuario LIKE :emailUsuario LIMIT 6");
	$sql->bindValue(":emailUsuario", $emailUsuario."%", PDO::PARAM_STR);
	$sql->execute();	
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['nomeUsuario'][$n]  = $ln->nomeUsuario;
		$retorno['emailUsuario'][$n] = $ln->emailUsuario;
		$retorno['idUsuario'][$n]    = $ln->idUsuario;
		$n++;
	}
	$sql = '';	
	}
	
}


if($_GET['acao'] == 'dropdownProjetos'){
	$sql = $pdo->prepare("SELECT * FROM tarefa WHERE FK_idTarefa is null AND idUsuario = :idUsuario");
	$sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$sql->execute();	
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['nomeTarefa'][$n] = $ln->nomeTarefa;
		$retorno['idTarefa'][$n]   = $ln->idTarefa;
		$n++;
	}
	$sql = '';	
}
if($_GET['acao'] == 'dropdownProjetosConcluidos'){
	$sql = $pdo->prepare("SELECT * FROM tarefa WHERE FK_idTarefa is null AND idUsuario = :idUsuario");
	$sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$sql->execute();	
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['nomeTarefa'][$n] = $ln->nomeTarefa;
		$retorno['idTarefa'][$n]   = $ln->idTarefa;
		$n++;
	}
	$sql = '';	
}

if($_GET['acao'] == 'dropdownCreate'){
	$sql = $pdo->prepare("SELECT * FROM tarefa WHERE FK_idTarefa is null AND idUsuario = :idUsuario");
	$sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$sql->execute();	
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['nomeTarefa'][$n] = $ln->nomeTarefa;
		$retorno['idTarefa'][$n]   = $ln->idTarefa;
		$n++;
	}
	$sql = '';	
}

if($_GET['acao'] == 'dropdownTipos'){
	$sql = $pdo->prepare("SELECT * FROM tipotarefa");
	$sql->execute();	
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['nomeTipoTarefa'][$n] = $ln->nomeTipoTarefa;
		$retorno['idTipoTarefa'][$n]   = $ln->idTipoTarefa;
		$n++;
	}
	$sql = '';	
}

if($_GET['acao'] == 'dropdownEspecialidade'){
	$sql = $pdo->prepare("SELECT * FROM especialidade WHERE idUsuarioResponsavel = $idUsuario");
	$sql->execute();	
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['nomeEspecialidade'][$n] = $ln->nomeEspecialidade;
		$retorno['idEspecialidade'][$n]   = $ln->idEspecialidade;
		$n++;
	}
	$sql = '';	
}

elseif($_GET['acao'] == 'buscarEquipes'){
	$value["nomeUsuario"];
	$sql = $pdo->prepare("SELECT equipe.idEquipe, nomeEquipe FROM equipe 
		inner JOIN listaequipe
		on equipe.idEquipe = listaequipe.idEquipe
		inner JOIN usuario on listaequipe.idUsuario = usuario.idUsuario
		WHERE USUARIO.idUsuario = :idUsuario;");
	$sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['idEquipe'][$n] 		= $ln->idEquipe; 
		$retorno['nomeEquipe'][$n] 		= $ln->nomeEquipe; 
		$n++;
	}
	$sql = '';
}


elseif($_GET['acao'] == 'listarTarefasPendentes'){
	$id = $_GET['id'];
	$value["nomeUsuario"];
	$sql = $pdo->prepare("SELECT * FROM tarefa 
	WHERE FK_idTarefa = :id AND idStatus = 1 AND idUsuario = :idUsuario");
	$sql->bindValue(":id", $id, PDO::PARAM_INT);
	$sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['idTarefa'][$n]   		= $ln->idTarefa;
		$retorno['nomeTarefa'][$n] 		= $ln->nomeTarefa; 
		$retorno['descricaoTarefa'][$n] = $ln->descricaoTarefa;
		$retorno['dataCriacao'][$n] 	= $ln->dataCriacao;
		$retorno['prazoTarefa'][$n]   	= $ln->prazoTarefa;
		$retorno['metaHorasMensal'][$n] = $ln->metaHorasMensal;
		$retorno['progressoTarefa'][$n] = $ln->progressoTarefa;
		$retorno['idUsuario'][$n] 		= $ln->idUsuario;
		$retorno['idTipoTarefa'][$n]   	= $ln->idTipoTarefa;
		$retorno['idStatus'][$n] 		= $ln->idStatus;
		$retorno['FK_idTarefa'][$n]   	= $ln->FK_idTarefa;
		$retorno['idEspecialidade'][$n] = $ln->idEspecialidade;
		$n++;
	}
	$sql = '';
}


elseif($_GET['acao'] == 'listarTarefasEmAndamento'){
	$id = $_GET['id'];
	$sql = $pdo->prepare("SELECT * FROM tarefa 
	WHERE FK_idTarefa = :id AND idStatus = 2 AND idUsuario = :idUsuario");
	$sql->bindValue(":id", $id, PDO::PARAM_INT);
	$sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['idTarefa'][$n]   		= $ln->idTarefa;
		$retorno['nomeTarefa'][$n] 		= $ln->nomeTarefa;
		$retorno['descricaoTarefa'][$n] = $ln->descricaoTarefa;
		$retorno['dataCriacao'][$n] 	= $ln->dataCriacao;
		$retorno['prazoTarefa'][$n]   	= $ln->prazoTarefa;
		$retorno['metaHorasMensal'][$n] = $ln->metaHorasMensal;
		$retorno['progressoTarefa'][$n] = $ln->progressoTarefa;
		$retorno['idUsuario'][$n] 		= $ln->idUsuario;
		$retorno['idTipoTarefa'][$n]   	= $ln->idTipoTarefa;
		$retorno['idStatus'][$n] 		= $ln->idStatus;
		$retorno['FK_idTarefa'][$n]   	= $ln->FK_idTarefa;
		$retorno['idEspecialidade'][$n] = $ln->idEspecialidade;
		$n++;
	}
	$sql = '';
}


elseif($_GET['acao'] == 'listarProjetos'){
	$id = $_GET['id'];
	$sql = $pdo->prepare("SELECT * FROM tarefa 
	WHERE idStatus = :id AND FK_idTarefa IS null AND idUsuario = :idUsuario");
	$sql->bindValue(":id", $id, PDO::PARAM_INT);
	$sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['idTarefa'][$n]   		= $ln->idTarefa;
		$retorno['nomeTarefa'][$n] 		= $ln->nomeTarefa;
		$retorno['descricaoTarefa'][$n] = $ln->descricaoTarefa;
		$retorno['dataCriacao'][$n] 	= $ln->dataCriacao;
		$retorno['prazoTarefa'][$n]   	= $ln->prazoTarefa;
		$retorno['metaHorasMensal'][$n] = $ln->metaHorasMensal;
		$retorno['progressoTarefa'][$n] = $ln->progressoTarefa;
		$retorno['idUsuario'][$n] 		= $ln->idUsuario;
		$retorno['idTipoTarefa'][$n]   	= $ln->idTipoTarefa;
		$retorno['idStatus'][$n] 		= $ln->idStatus;
		$retorno['FK_idTarefa'][$n]   	= $ln->FK_idTarefa;
		$retorno['idEspecialidade'][$n] = $ln->idEspecialidade;
		$n++;
	}
	$sql = '';
}


elseif($_GET['acao'] == 'listarTarefasConcluidas'){
	$id = $_GET['id'];
	$sql = $pdo->prepare("SELECT * FROM tarefa 
	WHERE FK_idTarefa = :id AND idStatus = 3 AND idUsuario = :idUsuario");
	$sql->bindValue(":id", $id, PDO::PARAM_INT);
	$sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['idTarefa'][$n]   		= $ln->idTarefa;
		$retorno['nomeTarefa'][$n] 		= $ln->nomeTarefa;
		$retorno['descricaoTarefa'][$n] = $ln->descricaoTarefa;
		$retorno['dataCriacao'][$n] 	= $ln->dataCriacao;
		$retorno['prazoTarefa'][$n]   	= $ln->prazoTarefa;
		$retorno['metaHorasMensal'][$n] = $ln->metaHorasMensal;
		$retorno['progressoTarefa'][$n] = $ln->progressoTarefa;
		$retorno['idUsuario'][$n] 		= $ln->idUsuario;
		$retorno['idTipoTarefa'][$n]   	= $ln->idTipoTarefa;
		$retorno['idStatus'][$n] 		= $ln->idStatus;
		$retorno['FK_idTarefa'][$n]   	= $ln->FK_idTarefa;
		$retorno['idEspecialidade'][$n] = $ln->idEspecialidade;
		$n++;
	}
	$sql = '';
}

//Função para contar as tarefas abertas
elseif($_GET['acao'] == 'contarTarefasAbertas'){
	$sql = $pdo->prepare("SELECT idTarefa FROM tarefa 
	WHERE idStatus = 1 AND idUsuario = :idUsuario");
	$sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	$sql = '';
}

elseif($_GET['acao'] == 'contarTarefasEmAndamento'){
	$sql = $pdo->prepare("SELECT * FROM tarefa 
	WHERE idStatus = 2 AND idUsuario = :idUsuario");
	$sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	$sql = '';
}

elseif($_GET['acao'] == 'contarTarefasFinalizadas'){
	$sql = $pdo->prepare("SELECT * FROM tarefa 
	WHERE idStatus = 3 AND idUsuario = :idUsuario");
	$sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	$sql = '';
}

elseif($_GET['acao'] == 'calcularProgresso'){
	$idTarefa = $_GET['id'];
	$sql = $pdo->prepare("SELECT idStatus FROM tarefa 
	WHERE idUsuario = :idUsuario and FK_idTarefa = :idTarefa");
	$sql->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
	$sql->bindValue(":idTarefa", $idTarefa, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$contAbertas = 0;
	$contAndamento = 0;
	$contConcluida = 0;
	$retorno['qtd'] = $sql->rowCount();
	$quantTarefas = $retorno['qtd'];
	$valorTarefa = 100 / $quantTarefas;

	while ($ln = $sql->fetchObject()) {
		if ($ln->idStatus == 1) {
			$contAbertas ++;
		}
		elseif ($ln->idStatus == 2) {
			$contAndamento ++;
		}
		elseif ($ln->idStatus ==3) {
			$contConcluida ++;
		}
			
		$n++;
	}
	$calculofinal = ($valorTarefa * $contConcluida) + (($valorTarefa * $contAndamento)/2) - ($valorTarefa * $contAbertas); 
	

	if ($contAbertas == 0 && $contConcluida == 0 && $contAndamento == 0) {
		$calculofinal = 0;
	}
	else{
		$retorno['resultado'] = ($contConcluida - $contAbertas) / 100;
		if ($calculofinal < 0) {
			$calculofinal = 0;
		}
		elseif ($retorno['resultado'] > 100) {
			$calculofinal = 100;
		}
	}

	$retorno['resultado'] = round($calculofinal, 2)."%";
	$sql = '';
}


elseif($_GET['acao'] == 'atualizarInformacoes'){
	$idTarefa = $_GET['idTarefa'];
	$nomeTarefa = $_GET['nomeTarefa'];
	$descricaoTarefa = $_GET['descricaoTarefa'];
	$prazoTarefa = $_GET['prazoTarefa'];
	$metaHorasMensal=$_GET['metaHorasMensal'];

	$tabela = 'tarefa';
	$atributos = [
	   'nomeTarefa = "'.$nomeTarefa.'",
		descricaoTarefa = "'.$descricaoTarefa.'",
		prazoTarefa = "'.$prazoTarefa.'",
		metaHorasMensal = "'.$metaHorasMensal.'"'];
	$condicao = ['idTarefa = "'.$idTarefa.'"'];
	$model = new Model();
	$model->update($tabela, $atributos, $condicao);
}


elseif($_GET['acao'] == 'cadastrarEspecialidade'){
	$nomeEspecialidade = $_GET['nomeEspecialidade'];
	$descricaoEspecialidade = $_GET['descricaoEspecialidade'];

	$tabela = 'especialidade';
	$colunas = ['nomeEspecialidade, descricaoEspecialidade, idUsuarioResponsavel'];
	$valores = ['"'.$nomeEspecialidade.'","'.$descricaoEspecialidade.'","'.$idUsuario.'"'];
	$model = new Model();
	$model->create($tabela, $colunas, $valores);
	header("Location: ../meus-relatorios.php");
}

//Função responsável por listar as especialidades do usuário
elseif($_GET['acao'] == 'listarEspecialidadesDoUsuario'){
	$sql = $pdo->prepare("SELECT nomeEspecialidade, especialidade.idEspecialidade FROM usuario 
		Left join listaespecialidade 
		on usuario.idUsuario = listaespecialidade.idUsuario
		left join especialidade 
		on listaespecialidade.idEspecialidade = especialidade.idEspecialidade
		where usuario.idUsuario = :idusuario");
	$sql->bindValue(":idusuario", $idUsuario, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['nomeEspecialidade'][$n]	= $ln->nomeEspecialidade;
		$retorno['idEspecialidade'][$n]	= $ln->idEspecialidade;
		if ($retorno['idEspecialidade'][$n]	== null || $retorno['nomeEspecialidade'][$n] == null) {
			$retorno['idEspecialidade'][$n]	= "Sem especialidade";
			$retorno['nomeEspecialidade'][$n]	= "Sem especialidade";
		}
		$n++;
	}
	$sql = '';
}


//Função para excluir tarefa
elseif($_GET['acao'] == 'excluirTarefa'){
	$idTarefa = $_GET['idTarefa'];
	$tabela = 'tarefa';
	$condicao = 'idTarefa = "'.$idTarefa.'"';
	$model = new Model();
	$model->delete($tabela, $condicao);
}

//Função para excluir especialidade
elseif($_GET['acao'] == 'excluirEspecialidade'){
	$idEspecialidade = $_GET['idEspecialidade'];
	$tabela = 'listaespecialidade';
	$condicao = "idUsuario = $idUsuario AND idEspecialidade = $idEspecialidade";
	$model = new Model();
	$model->delete($tabela, $condicao);

}

//Função para listar as descrições das tarefas 
elseif($_GET['acao'] == 'buscarDescricao'){
	$id = $_GET['id'];
	$sql = $pdo->prepare("SELECT descricaoTarefa FROM tarefa 
	WHERE idTarefa = :id");
	$sql->bindValue(":id", $id, PDO::PARAM_INT);
	$sql->execute();
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['descricaoTarefa'] = $ln->descricaoTarefa;
	}	
	$sql = '';
}


elseif($_GET['acao'] == 'concluirTarefa'){
	try {
		$id = $_GET['id'];
		$sql = $pdo->prepare("UPDATE tarefa SET idStatus = 3 WHERE idTarefa = :id");
		$sql->bindValue(":id", $id, PDO::PARAM_INT);
		$sql->execute();
		//header('Location: ../minhas-tarefas.php');	
	} catch (Exception $e) {
		echo $e;
	}
}

elseif($_GET['acao'] == 'tornarPendente'){
	try {
		$id = $_GET['id'];
		$sql = $pdo->prepare("UPDATE tarefa SET idStatus = 1 WHERE idTarefa = :id");
		$sql->bindValue(":id", $id, PDO::PARAM_INT);
		$sql->execute();
		//header('Location: ../minhas-tarefas.php');	
	} catch (Exception $e) {
		echo $e;
	}
}

//Função responsável por mudar o status de "Pendente" para "Em andamento"
elseif($_GET['acao'] == 'comecarTarefa'){
	try {
		$id = $_GET['id'];
		$sql = $pdo->prepare("UPDATE tarefa SET idStatus = 2 WHERE idTarefa = :id");
		$sql->bindValue(":id", $id, PDO::PARAM_INT);
		$sql->execute();
		//header('Location: ../minhas-tarefas.php');	
	} catch (Exception $e) {
		echo $e;
	}
}


//Função responsável por disponibilizar as informações detalhadas no modal da tarefa
elseif($_GET['acao'] == 'buscarDetalhes'){
	$id = $_GET['id'];
	$sql = $pdo->prepare("SELECT * FROM tarefa 
		LEFT JOIN usuario 
		on tarefa.idUsuario = usuario.idUsuario
		LEFT JOIN especialidade
		on tarefa.idEspecialidade = especialidade.idEspecialidade
		LEFT JOIN status
		on tarefa.idStatus = status.idStatus
		LEFT JOIN tipousuario
		on usuario.idTipoUsuario = tipousuario.idTipoUsauario
		LEFT JOIN tipotarefa
		on tipotarefa.idTipoTarefa = tarefa.idTipoTarefa
		WHERE tarefa.idTarefa = :id");
	$sql->bindValue(":id", $id, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['nomeTarefa'] 			= $ln->nomeTarefa; //Explicação do utf8_encode no final
		$retorno['nomeStatus'] 			= $ln->nomeStatus;
		$retorno['prazoTarefa']			= $ln->prazoTarefa;
		$retorno['nomeUsuario']   		= $ln->nomeUsuario;
		$retorno['dataCriacao'] 		= $ln->dataCriacao;
		$retorno['nomeEspecialidade']	= $ln->nomeEspecialidade;

	}
	$sql = '';
}

elseif($_GET['acao'] == 'buscarInformacoes'){
	try {
			$id = $_GET['id'];
	$sql = $pdo->prepare("SELECT * FROM tarefa 
		LEFT JOIN usuario 
		on tarefa.idUsuario = usuario.idUsuario 
		LEFT JOIN especialidade 
		on tarefa.idEspecialidade = especialidade.idEspecialidade 
		LEFT JOIN status 
		on tarefa.idStatus = status.idStatus 
		LEFT JOIN tipousuario 
		on usuario.idTipoUsuario = tipousuario.idTipoUsauario
        LEFT JOIN tipotarefa
        on tipotarefa.idTipoTarefa = tarefa.idTipoTarefa
        WHERE tarefa.idTarefa = :id");
	
	$sql->bindValue(":id", $id, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['idTarefa'] 			= $id; //Explicação do utf8_encode no final
		$retorno['nomeTarefa'] 			= $ln->nomeTarefa;
		$retorno['descricaoTarefa'] 	= $ln->descricaoTarefa;
		$retorno['metaHorasMensal'] 	= date('H:i', strtotime($ln->metaHorasMensal));
		$retorno['nomeStatus'] 			= $ln->nomeStatus;
		$retorno['prazoTarefa']			= date('d/m/Y H:i', strtotime($ln->prazoTarefa));
		$retorno['nomeUsuario']   		= $ln->nomeUsuario;
		$retorno['dataCriacao'] 		= $ln->dataCriacao;
	}
	$sql = '';
	} catch (Exception $e) {

		echo $e;
	}

}

//Função responsável por buscar o nome do projeto pai da tarefa em questão
elseif($_GET['acao'] == 'buscarProjetoPai'){
	$id = $_GET['id'];
	$sql = $pdo->prepare("SELECT idTarefa, nomeTarefa 
		FROM tarefa WHERE idTarefa = (SELECT FK_idTarefa
		FROM tarefa WHERE idTarefa = :id)");
	$sql->bindValue(":id", $id, PDO::PARAM_INT);
	$sql->execute();
	$n = 0;
	$retorno['qtd'] = $sql->rowCount();
	while($ln = $sql->fetchObject()){
		$retorno['idTarefa'] = $ln->idTarefa;
		$retorno['FK_nomeTarefa'] = $ln->nomeTarefa;
	}
	$sql = '';
}



die(json_encode($retorno));

//o utf8_encode() serve para consertar a acentuação dos dados trazidos do bd, sem essa tag o json não retorna nada