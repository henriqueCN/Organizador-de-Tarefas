<?php
session_start();
include_once('../../controller/usuario.php');
//Chamando a classe Usuario para poder usar suas funções
$usuario = new Usuario();
//Caso o botão de logar seja acionado...
if (isset($_POST['btnLogar'])) {
	//envia o nome da tabela para a classe de usuario
    $usuario->setTabela('usuario');
    //Recebe os dados do formulário via POST
	$email = $_POST['email'];
	$senha = sha1($_POST['senha']);
	//As sessions de email e senha recebem os valores do formulário
	$_SESSION['email'] = $email;
	$_SESSION['senha'] = $senha;
	//Usamos a função de logar da classe usuario
	$log = $usuario->logar($email, $senha);
	if ($log){
		//A variável condição é o "WHERE" da query do select 
		$condicao = "emailUsuario = '$email' and senhaUsuario = '$senha'";
		//Realiza a consulta sql de acordo com a condição e tabela
		$dadosUsuario = $usuario->findLeftJoinGenerico($usuario->getTabela(), $condicao);
		//A session "dadosUsuario" ira armazenar por array os dados retornados pelo select
		$_SESSION["dadosUsuario"] = $dadosUsuario;
		//A session "usuarioLogado" tem a função de informar que o usuario logou com sucesso
		$_SESSION["usuarioLogado"] = true;
		//Redirecionamento para o arquivo index após logar
		header("location: ../usuario");
	}
	//Caso não encontre os dados para logar so select(caso usuario não exista)...
	else{echo "Erro ao procurar dados";}
}
//Caso não seja recebido nenhum dado via POST...
else{echo "Erro! dados do formulário não recebidos";}

?>