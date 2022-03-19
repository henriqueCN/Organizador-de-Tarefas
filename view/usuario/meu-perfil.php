<?php session_start();

require_once("inc/header.php"); 

?>
<style>
  #badge-alterar-nome:hover {
    cursor: pointer;
  }
</style>
   <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel"><b>Cadastrar Tarefa</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
<?php include_once('inc/model-cadastro.php'); ?>
            <div class="modal-footer">
              <button type="submit" name="btn_cadastrar_produto" class="btn btn-primary">Cadastrar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
            </form>
          </div>
        </div>
      </div>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">

		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Meu Perfil</h1>
			</div>	
		</div><!--/.row-->

    <!-- Modal Alterar Nome -->
    <div class="modal fade" id="alterar-nome" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Trocar nome</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4 style="text-align: center;">Olá <?php echo $value["nomeUsuario"]; ?>, altere seu nome aqui:</h4>
            <form method="post" action="../viewController/atualizar.php">
              <input type="text"  name="idUsuario" style = "display: none;" value = '<?php echo $value["idUsuario"]; ?>'>
              <input type="text" name="nome_para_alterar" class="form-control" placeholder="Digite seu novo nome" style="margin: 4% 0 1% 0;">
              <input type="text" name="senhaUsuario" class="form-control" placeholder="Digite sua senha" style="margin: 4% 0 1% 0;">
          </div>
          <div class="modal-footer">
            <button type="submit" name="btn-atualiza-nome" class="btn btn-primary"><i class="fa fa-pencil"></i>&nbsp;Alterar nome</button>
            </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="jumbotron" style="padding: 40px;">
      <h1 type="button" class="display-3">Olá <?php echo $value["nomeUsuario"]; ?> &nbsp;<span class="badge badge-primary" id="badge-alterar-nome" data-toggle="modal" data-target="#alterar-nome" style="border-radius: 2px; padding: 5px;">Alterar Nome</span></h1>
      <p class="lead">Nome: <?php echo $value["nomeUsuario"]; ?></p>
      <hr class="my-4">
      <p><i class="fa fa-envelope"></i>&nbsp;<?php echo $value["emailUsuario"]; ?></p>
      <p><i class="fa fa-address-card"></i>&nbsp;<?php echo $value["nomeTipoUsuario"]; ?></p>
      <p id="nomeEspecialidades"><i class="fa fa-certificate"></i></p>
      
      <p class="lead">
        <a class="btn btn-primary btn-lg" href="#" role="button" data-toggle="modal" data-target="#trocarSenha">Trocar senha</a>
        <a class="btn btn-warning btn-lg" href="#" role="button" data-toggle="modal" data-target="#adicionarEspecialidade">Adicionar Especialidade</a>
      </p>
    </div>
    <!-- Modal Atualizar Senha -->
    <div class="modal fade" id="trocarSenha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Trocar senha</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3 style="text-align: center; margin-bottom: 2%;">Olá <?php echo $value["nomeUsuario"]; ?>, deseja trocar sua senha?</h3>
            <h5 style="text-align: center; margin-bottom: 20px !important;">Por razões de segurança, precisamos que você confirme sua antiga senha, assim, saberemos que é você mesmo.</h5>
            
            <form method="POST" action="../viewController/atualizar.php">
              <input type="text"  name="idUsuario" style = "display: none;" value = '<?php echo $value["idUsuario"]; ?>'>
              <input style="margin-bottom: 2%;" type="password" name="senha_antiga" placeholder="Senha Antiga" class="form-control">
              <input style="margin-bottom: 2%;" type="password" name="nova_senha" placeholder="Nova Senha" class="form-control">
              <input type="password" name="conf_nova_senha" placeholder="Confirme a nova senha" class="form-control">
          </div>
            <div class="modal-footer">
              <button type="submit" name="btn-atualiza-senha" class="btn btn-primary">Atualizar Senha</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <div class="modal fade" id="adicionarEspecialidade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Adicionar Especialidade</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3 style="text-align: center; margin-bottom: 2%;">Olá <?php echo $value["nomeUsuario"]; ?>, deseja trocar sua especialidade?</h3>
            <h5 style="text-align: center; margin-bottom: 20px !important;">Por razões de segurança, precisamos que você confirme sua senha.</h5>
            
            <form method="POST" action="../viewController/cadastrar.php">
              <input type="text"  name="idUsuario" style = "display: none;" value = '<?php echo $value["idUsuario"]; ?>'>
              <input style="margin-bottom: 2%;" type="password" name="senha" placeholder="Confirme sua senha" class="form-control">
              <select class="form-control" style="display: inline-block; margin-bottom: 2%;" name="selectEspecialidade">
                <option >Especialidade</option>
              </select>
          </div>
            <div class="modal-footer">
              <button type="submit" name="btn-adiciona-especialidade" class="btn btn-primary">Adicionar Especialidade</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
<?php require_once("inc/footer.php"); ?>