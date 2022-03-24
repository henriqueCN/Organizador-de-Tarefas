<?php session_start(); ?>
<?php
  $dados = $_SESSION["dadosUsuario"];
?>
<?php require_once("inc/header.php"); ?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Painel Principal</h1>
			</div>	
		</div><!--/.row-->
    <!-- Botões Principais -->
    <div class="row" style="margin-bottom: 2%;">
      <div class="col-xs-6 col-sm-6 col-md-2" style="margin-bottom: 2%;">
        <a data-toggle="modal" data-target="#exampleModal" href="#" class="btn btn-default">
          <div class="row">
            <div class="col-xs-12 text-center">
              <i class="fa fa-plus fa-5x"></i>
            </div>
            <div class="col-xs-12 text-center">
              <p>Nova Tarefa</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-2" style="margin-bottom: 2%;">
        <a href="minhas-tarefas.php" class="btn btn-default">
          <div class="row">
            <div class="col-xs-12 text-center">
              <i class="fa fa-list fa-5x"></i>
            </div>
            <div class="col-xs-12 text-center">
              <p>Listar Tarefas</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-2" style="margin-bottom: 2%;">
        <a href="meus-relatorios.php" class="btn btn-default">
          <div class="row">
            <div class="col-xs-12 text-center">
              <i class="fa fa-sitemap fa-5x"></i>
            </div>
            <div class="col-xs-12 text-center">
              <p>Ger. Projetos</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-2" style="margin-bottom: 0%;">
        <a href="meu-perfil.php" class="btn btn-default">
          <div class="row">
            <div class="col-xs-12 text-center">
              <i class="fa fa-user fa-5x"></i>
            </div>
            <div class="col-xs-12 text-center">
              <p>Meu Perfil</p>
            </div>
          </div>
        </a>
      </div>
    </div>

   <!-- <div class="row">
      <div class="col-lg-12">
        <h2>Suas Equipes</h2>
      </div>  
    </div><
    <div id="divMostraEquipe">
        
    </div> -->
      
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
    
  
</div>  
      <div class="modal-footer">
        <button type="submit" name="btn_cadastrar_produto" class="btn btn-primary">Cadastrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
      </form>
    </div>
    </div> 
</div> 
  </div>
</div>
</div>

		
<?php require_once("inc/footer.php"); ?>