<?php session_start() ?>
<?php require_once("inc/header.php"); ?>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">

	</div><!--/.row-->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Manipulação de Projetos</h1>
		</div>	
	</div><!--/.row-->

  <div class="row">
    <div class="col-xs-4 col-md-4">
      <div class="panel panel-default">
        <div class="panel-body easypiechart-panel">
          <h4>Tarefas Abertas</h4>
          <div class="easypiechart" id="easypiechart-blue" data-percent="100" ><span class="percent" id="quantTarefasPendentes"></span></div>
        </div>
      </div>
    </div>
      <div class="col-xs-4 col-md-4">
        <div class="panel panel-default">
          <div class="panel-body easypiechart-panel">
            <h4>Tarefas em Andamento</h4>
            <div class="easypiechart" id="easypiechart-orange" data-percent="100" ><span class="percent" id="quantTarefasEmAndamento"></span></div>
          </div>
        </div>
      </div>      
      <div class="col-xs-4 col-md-4">
        <div class="panel panel-default">
          <div class="panel-body easypiechart-panel">
            <h4>Tarefas Finalizadas</h4>
            <div class="easypiechart" id="easypiechart-teal" data-percent="100" ><span class="percent" id="quantTarefasConcluidas"></span></div>
          </div>
        </div>
      </div>

    </div>

       
    <!-- Fim dos Gráficos -->

<!-- Relatório Ripo Venda e Compra -->

<!-- Fim do Relatórios tipo venda e compra -->
<!-- <div class="col-md-12">
  <div class="panel panel-default ">
    <div style = "color:green" class="panel-heading">
      <b>Projetos</b>
      </div>
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
      <br>
      <div class="table-responsive" style="padding-bottom: 2%;">
        <select class="form-control"  style="width: 50%; display: inline-block;"  name="dropProjetos">
          <option value="">Escolha o status</option>
          <option value="1">Pendente</option>
          <option value="2">Em andamento</option>
          <option value="3">Concluído</option>
        </select>
        <br>
      </div>
    <div class="table-responsive">
      <div id="tabelaDeProjetos"></div>
      <table id="tabelaProjetos" class="table table-hover">
      </table>  
    </div> 
  </div>
</div> -->

<!-- Fim do Relatórios tipo venda e compra -->
<div class="col-md-12">
  <div class="panel panel-default ">
    <div  style = "color: #4682B4"  class="panel-heading">
      Tarefas <b>Concluídas</b>
      </div>
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
      <br>
    <div class="table-responsive" style="padding-bottom: 2%;">
      <select class="form-control"  style="width: 50%; display: inline-block;" id = "selectProjetosConcluidos"  name="selectProjetoConcluido">
      <option value="">Escolha o projeto</option>
      </select>
      <br>
  </div>

  <div class="table-responsive">
  <div id="tabelaDeTarefasConcluidas"></div>
  <table id="tarefasConcluidas" class="table table-hover">


  </table>  
</div> 
</div>
</div>


      <!-- Modal -->
      <div class="modal fade" id="modalRenovacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div>
              <h4 align="center">Renovar a tarefa</h4>

            </div>
            <div style="padding: 5%;">
              <b style="color: green">Deseja renovar esta tarefa?</b>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-dismiss="modal" onclick="comecarTarefa(this.value)" name="botaoIniciar">Iniciar</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>


            <!-- Modal -->
      <div class="modal fade" id="modalInicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div>
              <h4 align="center">Iniciar a tarefa</h4>

            </div>
            <div style="padding: 5%;">
              <b style="color: green">Deseja iniciar esta tarefa?</b>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-dismiss="modal" onclick="comecarTarefa(this.value)" name="botaoIniciar">Iniciar</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
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


  </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
    contarTarefasAbertas(); 
    contarTarefasEmAndamento(); 
    contarTarefasFinalizadas();
  });



</script>

<?php require_once("inc/footer.php"); ?>