
<?php
require_once('../../controller/usuario.php');
$usuario = new Usuario();
if (isset($_POST['btn-atualiza-nome'])) {


	$nomeUsuario = $_POST['nome_para_alterar'];
	$idUsuario = $_POST['idUsuario'];
	$senhaUsuario = sha1($_POST['senhaUsuario']);
	$tabela = 'usuario';

	$atributos = ['nomeUsuario = "'.$nomeUsuario.'"'];
	$condicao = ['idUsuario = "'.$idUsuario.'" and senhaUsuario = "'.$senhaUsuario.'"'];
	$usuario->update($tabela, $atributos, $condicao);
	header('Location: ../usuario/meu-perfil.php');
}

if (isset($_POST['btn-atualiza-senha'])) {


	$idUsuario = $_POST['idUsuario'];

	$senha_antiga = sha1($_POST['senha_antiga']);

	$nova_senha = sha1($_POST['nova_senha']);

	$conf_nova_senha = sha1($_POST['conf_nova_senha']);

	$tabela = 'usuario';
	$condicao = 'idUsuario = "'.$idUsuario.'"';
	$valores = $usuario->find($tabela, $condicao);

	if ($senha_antiga == $valores['senhaUsuario'] && $nova_senha == $conf_nova_senha) {
		try {
			$atributos = ['senhaUsuario = "'.$nova_senha.'"'];
			$condicao = ['idUsuario = "'.$idUsuario.'" and senhaUsuario = "'.$senha_antiga.'"'];
			$usuario->update($tabela, $atributos, $condicao);
			header('Location: ../usuario/meu-perfil.php');			
		} catch (Exception $e) {
			echo $e;
		}

	}

}







?>