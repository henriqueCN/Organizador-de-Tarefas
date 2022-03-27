<?php session_start();
 require_once("inc/header.php");
  include_once('../../controller/tarefa.php');
  $tarefa = new Tarefa(); 
?>

<!doctype html>


  <style type="text/css">
    .td_ajuste{
      padding: 20px; 
      text-align: center;
    }
  </style>

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">

		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Minhas Tarefas</h1>
			</div>	
		</div><!--/.row-->   
  <div class="table-responsive" style="padding-bottom: 2%;">
    <p id="textoSobreSelect">Selecione um projeto para adicionar tarefas a ele.</p>
      <select class="form-control" id="selectProj" style="width: 50%; display: inline-block;" onchange="mostraAdicionarTarefa(this.value)" name="selectProjeto">
      <option value="">Escolha o projeto</option>
      </select>
      <br>
      <button style="margin: 5px; display: none;" value = "" id="botaoAdicionaTarefa"href="#" onclick="passaSelect(this.value)" data-toggle="modal" data-target="#exampleModal" class="btn btn-info">Adicionar Tarefa</button>
  </div>
    <div class="panel panel-container">
      <div class="row">
        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
          <div class="panel panel-teal panel-widget border-right">
            <div class="row no-padding"><em class="fa fa-xl fa-gift color-blue"></em>
              <div class="large" id="quantTarefasPendentes">0</div>             
              <div class="text">Tarefas Pendentes</div>
            </div>
          </div>
        </div>
        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
          <div class="panel panel-blue panel-widget border-right">
            <div class="row no-padding"><em class="fa fa-xl fa-clock-o color-orange"></em>
              <div class="large" id="quantTarefasEmAndamento">0</div>
              <div class="text" >Tarefas em andamento</div>
            </div>
          </div>
        </div>
        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
          <div class="panel panel-orange panel-widget border-right">
            <div class="row no-padding"><em style="color: green;" class="fa fa-xl fa-check-square-o color-orange"></em>
              <div class="large" id="quantTarefasConcluidas">0</div>
              <div class="text">Tarefas concluídas</div>
            </div>
          </div>
        </div>
        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
          <div class="panel panel-red panel-widget ">
            <div class="row no-padding"><em class="fa fa-xl fa-line-chart color-teal"></em> 
              <div id = "desempenho" class='large'>0</div> 
              <div class="text">Desempenho</div>
            </div>
          </div>
        </div>
      </div><!--/.row-->
    </div>


      <!-- Modal -->
      <div class="modal fade" id="modalInicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div>
              <h4 align="center">Iniciando a tarefa</h4>

            </div>
            <div style="padding: 5%;">
              <b style="color: green">Deseja Iniciar esta tarefa?</b>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-dismiss="modal" onclick="comecarTarefa(this.value)" name="botaoIniciar">Iniciar</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="modalConclusao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div>
              <h4 align="center">Finalizando a tarefa</h4>

            </div>
            <div style="padding: 5%;">
              <b style="color: green">Deseja finalizar esta tarefa?</b>
            </div>
            <div class="modal-footer">
              <button class="btn btn-success" onclick="concluirTarefa(this.value)" data-dismiss="modal" name="botaoConcluir">Concluir</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modalPendencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div>
              <h4 align="center">Tornar Tarefa Pendente</h4>

            </div>
            <div style="padding: 5%;">
              <b style="color: Grey">Deseja retornar o estado dessa tarefa para "Pendente"?</b>
            </div>
            <div class="modal-footer">
              <button class="btn btn-warning" onclick="tornarPendente(this.value)" data-dismiss="modal" name="botaoPendencia">Sim</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Não</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="modalDescricao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><b>Descrição da Tarefa</b></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div id="textoDescricao" style="padding: 5%;"></div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!--Modal Detahes-->
      <div class="modal fade" id="modalDetalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 align="center">Detalhes da Tarefa</h4>
            </div>
                        <div id="detalhesTarefa">
              <div class = "col-md-6"style="padding: 5%;">
              <strong>Nome da Tarefa:</strong><p id = "nomeTarefaDetalhes"></p>
              <strong>Status:</strong><p id = "statusTarefaDetalhes"></p>
              <strong>Prazo:</strong><p id = "prazoTarefaDetalhes"></p>
              <strong>Projeto do qual faz parte:</strong><p id ="projetoDetalhes"></p>
              </div>
              <div class = "col-md-6"style="padding: 5%;">
              <strong>Criado por</strong><p id="criadorDetalhes"></p>
              <strong>Data de Criação</strong><p id="dataCriacaoDetalhes"></p>
              <strong>Especialidade da Tarefa</strong><p id="especialidadeTarefaDetalhes"></p>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div> 

            
      <!-- Modal UPDATE-->

<div class="table-responsive">
  <h3><b>Tarefas Pendentes</b></h3>
  <div id="tabelaDeTarefas"></div>
  <table id="tarefasPendentes" class="table table-hover">


  </table>

  <h3><b>Tarefa em andamento</b></h3>
  <div id ="tabelaDeTarefasAndamento"></div>
  <table id="tarefasEmAndamento" class="table table-hover">
   
  </table>
</div>    

        <!-- Modal Editar -->
        <!--<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?php include_once('inc/modal-cadastro.php');?>
              <div class="modal-footer">
                <button type="submit" name="btn_editar_produto" class="btn btn-primary"><i class="fa fa-pencil" style="padding-right: 5px;"></i>Editar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              </div>
              </form>
            </div>
          </div>
        </div>-->

        <!-- Modal Excluir -->
        <!--<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Deletar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" style="text-align: center !important;">
                <form action="controller/excluir-produtos.php" method="POST">
                  <i class="fa fa-exclamation-circle" style="color: #f9243f; font-size: 4em;" aria-hidden="true"></i>
                  <h4>Você está prestes a <b>excluir</b> o produto <b>nome tarefa</b></h4>
                  <p>Tem certeza que deseja fazer isso?</p>
                  <input type="number" value="" name="id_produto" style="display: none;">
              </div>
              <div class="modal-footer">
                <button type="submit" name="btn_excluir_produto" class="btn btn-danger"><i class="fa fa-trash" style="padding-right: 5px;"></i>Sim, Deletar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              </div>
              </form>
            </div>
          </div>
        </div>-->
  </table>

</div>
<script>


</script>
<?php require_once("inc/footer.php"); ?>