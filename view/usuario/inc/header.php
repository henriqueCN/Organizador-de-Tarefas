<? session_start(); ?>
<?php include_once('../../controller/usuario.php'); ?>
<?php

if (!(isset($_SESSION['dadosUsuario']))) {
  header("Location: inc/logout.php");
}else{
  $dados = $_SESSION['dadosUsuario'];
  foreach ($dados as $key => $value) {  
  }
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $value["nomeUsuario"]; ?></title>
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
	<!-- <link href="../assets/css/font-awesome.min.css" rel="stylesheet"> -->
	<link href="../assets/css/datepicker3.css" rel="stylesheet">
	<link href="../assets/css/styles.css" rel="stylesheet">
  <link rel="shortcut icon" href="../imagens/icone-gerenciamento-de-projetos-logo-altenada.png" >
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
  <!--Custom Font-->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  
  <style type="text/css">

  </style>
  
  <script type="text/javascript">
    function mostraSelect(){
      if (document.getElementById("checa").checked) {
        document.getElementById("divSelect").style.display = 'block';
      }else{
        document.getElementById("divSelect").style.display = 'none';
      }
      
    }
  </script>

</head>
<body>


<div class="modal fade" id="modalVinculaPessoa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>       
        <h4 align="center"><b>Adicionar novo integrante </b><i class="fa fa-at"></i></h4>
      </div>
      <div class="modal-body">
    <form action="../viewController/cadastrar.php" method="POST" autocomplete="off">
    <div style="display: inline-block;">

    <Label>Digite o endereço eletrônico do novo integrante</Label>
    <input type="text" value = "" class="form-control" onkeyup="enviarVetor(this.value)"  id = "inputAdicionaPessoas" name="" placeholder="nome@gmail.com">

    <div name = "mostre">
      
    </div>
    <p name = "des"  id = "mostrarVetor"></p>

    </div>
    <div >
    <br>
    </div>
    
    <br>
    </div>
         <div class="modal-footer">
        <input type="button" name="btn_cadastrar_tarefa" onclick = "inserirIntegrante()" class="btn btn-success" value="Cadastrar">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
      </form>          
    </div>

    </div>
  </div>
</div> 

<div class="modal fade" id="modalAdicionarPessoas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>       
        <h4 align="center"><b>Nova Equipe </b><i class="fa fa-at"></i></h4>
      </div>
      <div class="modal-body">
        <form action="../viewController/cadastrar.php" method="POST" autocomplete="off">
          <div style="display: inline-block;">

            <label>Digite o nome da equipe</label>
            <input name="equipe" id="equipe" class = "form-control" placeholder="Nome da Equipe">
            <br>
            <Label>Digite o endereço eletrônico do novo integrante</Label>
            <input type="text" value = "" class="form-control" onkeyup="enviarVetor(this.value)"  id = "inputAdicionaPessoas" name="" placeholder="nome@gmail.com">

            <div name = "mostre">

            </div>
            <p name = "des"  id = "mostrarVetor"></p>

          </div>
          <div >
            <br>
            <input type="checkbox" id="checa" onchange="mostraSelect()" >
            <label>Vincular um projeto a essa equipe?</label><br>  
            <div id = "divSelect" style="display: none;">
              <label>Projeto</label>       
              <select class="form-control" id="projetoEquipe" name="selectProjetos">
                <option value = '0'>Vazio</option>
              </select>
            </div>

            <br>
          </div>
          <div class="modal-footer">
            <input type="button" name="btn_cadastrar_tarefa" onclick = "inserirIntegrante()" class="btn btn-success" value="Cadastrar">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </form>          
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>      	
        <h4 align="center"><b>Cadastrar Tarefa  </b><i class="fa fa-calendar-plus-o"></i></h4>
      </div>
      <div class="modal-body">

      <!--<form action="../viewController/cadastrar.php" method="POST">-->
        <div style="display: inline-block;">
          <label>Nome da Tarefa</label>
          <input type="text" id = "snomeTarefa" style="margin-bottom: 2% ;  display: inline-block;" class="form-control" placeholder="Nome da tarefa" name="nomeTarefa">
          <label>Especialidade da Tarefa</label><a data-toggle="modal" data-target="#modalEspecialidade" style="margin-bottom: 1%;" class="btn btn-warning"><i class="fa fa-plus-square" aria-hidden="true"></i> Adicionar</a>
          <select class="form-control" style="display: inline-block; margin-bottom: 2%;" id="sselectEspecialidade" name="selectEspecialidade">
            <option >Especialidade da tarefa</option>
          </select>
          <br>
          <label>Descrição da Tarefa</label>
          <textarea rows="4" cols="30" name = "descricaoTarefa" id="sdescricaoTarefa" class="form-control" placeholder="Descricao">

          </textarea>
          <br>
          <label>Prazo</label>
          <input type="date" id = "sprazoTarefa" class="form-control" name="prazoTarefa">
          <label>Meta de Horas Mensais</label>
          <input type="time" id = "smetaHorasMensal" class="form-control" name="metaHorasMensal">
        </div>
        <div >
          <br>  
          <label>Tipo da Tarefa</label>       
          <select class="form-control" id="sselectTipoTarefa" name="selectTipoTarefa">
            <option value="">Tipo de Tarefa</option>
          </select>
          <br>
          <div id="ocultaSelectProjetos">
            <label>Projeto</label>
            <select class="form-control" name="selectProjetos" id = "idSelectProjetos" required="required">
              <option value="">Vazio</option>
            </select>
          </div>

          <div id="identificaProjeto">

          </div>

        </div>
        <div class="modal-footer">
          <button name="btn_cadastrar_tarefa" onclick = "inserirTarefa()" data-dismiss="modal" class="btn btn-primary">Inserir Tarefa</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>          
    </div>

  </div>
</div>
</div>

<!--Modal de edição-->
<div class="modal fade" id="modalEdicao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>              
        <h4 align="center">Editar Tarefa</h4>
      </div>
      <div id="detalhesTarefa">
          <div style="padding: 5%;">
            <p>Nome da Tarefa</p>
            <input id="editarNomeTarefa" name="editarNomeTarefa" class="form-control" type="">
            <br>
            <p>Descrição da Tarefa</p>
            <textarea id="editarDescricaoTarefa" class="form-control" name="editarDescricaoTarefa" rows="5" cols="74">
            </textarea>
            <br>
            <p>Prazo da Tarefa</p>
            <input id="editarPrazoTarefa" class="form-control" type="" name="editarPrazoTarefa">
            <br>
            <p>Meta de Horas</p>
            <input id="editarMetaHoras" class="form-control" type="" name="editarMetaHoras">
            <br>
            <input type="hidden" name="editarIdTarefa" id="editarIdTarefa">
            <h4 id="sucessoAoEditarTarefa"></h4>
          </div>
        </div>

        

        <div class="modal-footer">
          <button type="button" name = "atualizar" class="btn btn-success" onclick = "editarTarefa()" data-dismiss="Editar">Atualizar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      
    </div>
  </div>
</div>

            <!-- Modal de Exclusão -->
            <div class="modal fade" id="modalConfirmacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div>
              <h4 align="center">Confirmação</h4>

            </div>
            <div style="padding: 5%;">
              <b style="color: red">Deseja realmente excluir esta tarefa?</b>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="excluirERecarregar(this.value)" name="botaoExcluir">Excluir</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

<!--Modal de edição de equipe-->
<div class="modal fade" id="modalEdicaoEquipe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>              
        <h2 align="center">Editar Equipe</h2>
      </div>
      <div id="detalhesTarefa">
        <form method="GET" action="requisicoes_assincronas/webservice.php">
          <div style="padding: 5%;">
            <h3>Nome da Equipe</h3>
            <input id="editarNomeEquipe" name="editarNomeEquipe" class="form-control" type="">
            <br>
            <h3>Integrantes</h3>
            <div id="divIntegrantes">
              <p style="display: inline-block;">Usuario</p><a href="#" style="display: inline-block; margin-left: 2px;" class="fa fa-minus-circle"></a>
              
            </div>
            <br>
            <h3>Tarefas Vinculadas</h3>
            <p style="display: inline-block;">Tarefa</p><a href="#" style="display: inline-block; margin-left: 2px;" class="fa fa-minus-circle"></a>
            <br>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name = "atualizar" class="btn btn-success" data-dismiss="Editar">Concluir</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div> 

<div class="modal fade" id="modalProjeto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>       
        <h4 align="center"><b>Novo Projeto  </b><i class="fa fa-calendar-plus-o"></i></h4>
      </div>
      <div class="modal-body">
        <!--<form action="../viewController/cadastrar.php" method="POST">--> 
          <div style="display: inline-block;">
            <label>Nome do Projeto</label>
            <input type="text" style="margin-bottom: 2% ;  display: inline-block;" class="form-control" id = "projnomeTarefa" placeholder="Nome da tarefa" name="projnomeTarefa">
            <label>Especialidade Principal do Projeto   </label><a data-toggle="modal" data-target="#modalEspecialidade" style="margin-bottom: 1%;" class="btn btn-warning"><i class="fa fa-plus-square" aria-hidden="true"></i> Adicionar</a>
            <select class="form-control" style="display: inline-block; margin-bottom: 2%;" id = "projselectEspecialidade" name="projselectEspecialidade">
              <option >Especialidade da tarefa</option>
            </select>
            <br>
            <label>Descrição</label>
            <textarea rows="4" cols="30" name = "projdescricaoTarefa" id = "projdescricaoTarefa" class="form-control" placeholder="Descricao">

            </textarea>
            <br>
            <label>Prazo</label>
            <input type="date" class="form-control" id = "projprazoTarefa" name="projprazoTarefa">
            <label>Meta de Horas Mensais</label>
            <input type="time" class="form-control" id = "projmetaHorasMensal" name="projmetaHorasMensal">
          </div>
          <div >
            <br>  
            <label>Tipo de Projeto</label>       
            <select class="form-control" name="projselectTipoTarefa" id = "projselectTipoTarefa">
              <option value="">Tipo</option>
            </select>
            <br>
          </div>
          <div class="modal-footer">
            <button type="submit" name="proj_btn_cadastrar_tarefa" onclick = "inserirProjeto()" class="btn btn-primary">Cadastrar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        <!--</form>-->         
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modalDetalhesEquipe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 align="center">Detalhes da Tarefa</h4>
      </div>
      <div id="detalhesEquipe">
        <div class = "col-md-6"style="padding: 5%;">
          <strong>Nome da Tarefa:</strong><p id = ""></p>
          <strong>Status:</strong><p id = ""></p>
          <strong>Prazo:</strong><p id = ""></p>
          <strong>Projeto do qual faz parte:</strong><p id =""></p>
        </div>
        <div class = "col-md-6"style="padding: 5%;">
          <strong>Criado por</strong><p id=""></p>
          <strong>Data de Criação</strong><p id=""></p>
          <strong>Especialidade da Tarefa</strong><p id=""></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div> 

<div class="modal fade" id="modalEspecialidade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>              
        <h4 align="center">Inserir Nova Especialidade</h4>
      </div>
      <div id="detalhesTarefa">
        <form method="GET" action="requisicoes_assincronas/webservice.php">
          <div style="padding: 5%;">
            <p>Nome da Especialidade</p>
            <input id="nomeEspecialidade" name="nomeEspecialidade" class="form-control" type="">
            <br>
            <p>Descrição da Especialidade</p>
            <textarea id="descricaoEspecialidade" class="form-control" name="descricaoEspecialidade" rows="5" cols="74">
            </textarea>
            <br>
            <input type="hidden" name="acao" value="cadastrarEspecialidade">
            <h4 id="sucessoAoEditarTarefa"></h4>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name = "atualizar" class="btn btn-success" data-dismiss="Editar">Concluir</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modalExplicacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>       
        <h3 align="center"><b>Explicação do Sistema </b></h3>
      </div>
      <div class="modal-body">
        <p>Olá <?php echo $value["nomeUsuario"]; ?>, esse sistema tem como propósito ajudar na organização de <b>projetos</b> através da desmembração dos mesmos em <b>tarefas</b>, transformando um problema de escopo aberto em várias tarefas de escopo fechado. Para começar, crie um projeto principal, depois vá atribuindo as tarefas a ele.</p>
        <p><strong>Observação: </strong>O formulário para adicionar tarefas e projetos é o mesmo, a diferença de um projeto para uma tarefa é que o projeto não tem nenhum outro Projeto atrelado a ele.</p>
        <h4 ><b>Criando um Projeto</b></h4>
        <p>Vá na aba <b>"tarefas" > "nova tarefa"</b>, preencha os inputAdicionaPessoass <strong>exceto</strong> o <b>"Projeto"</b>.</p>
        <h4 ><b>Atribuindo uma Tarefa</b></h4>
        <p>Vá na aba <b>"tarefas" > "nova tarefa"</b>, preencha os inputAdicionaPessoass <strong>e selecione o projeto</strong> ao qual a tarefa a ser inserida irá fazer parte no seletor <b>"Projeto"</b>.</p>
        <h4 ><b>Listando as Tarefas</b></h4>
        <p>Para visualizar as tarefas, vá na aba <b>"tarefas" > "Todas as Tarefas"</b> e selecione o projeto a ser trabalhado no seletor <strong>"Escolha o Projeto"</strong>.</p>
        <h4 ><b>Relatório</b></h4>
        <p>Na aba <b>"Relatórios"</b> encontram-se os <strong>projetos</strong> e as <strong>tarefas concluídas</strong>.</p>
        <h4 ><b>Meu Perfil</b></h4>
        <p>Na aba <b>"Meu Perfil"</b> é possível trocar o <strong>nome</strong> e a <strong>senha</strong>.</p>
      </div>
    </div>

  </div>
</div>
</div>
</div>
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
  <div class="container-fluid">
   <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
     <span class="icon-bar"></span>
     <span class="icon-bar"></span>
     <span class="icon-bar"></span></button>
     <a class="navbar-brand" href="index.php"><span>Aimup</span></a>
   </li>
 </ul>
</div>
</div><!-- /.container-fluid -->
</nav>
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
  <div class="profile-sidebar">
   <div class="profile-userpic">
    <!--<img src="../imagens/avatar.png" class="img-responsive" alt="">-->
  </div>
  <div class="profile-usertitle">
    <div class="profile-usertitle-name"><?php echo $value["nomeUsuario"]; ?></div>
    <div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
  </div>
  <div class="clear"></div>
</div>
<div class="divider"></div>
<ul class="nav menu">
 <li><a href="index.php"><em class="fa fa-dashboard">&nbsp;</em> Principal</a></li>
 <li class="parent "><a data-toggle="collapse" href="#sub-item-1">
  <em class="fa fa-navicon">&nbsp;</em> Tarefas <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
</a>
<ul class="children collapse" id="sub-item-1">
  <li><a class="" href="#" data-toggle="modal" data-target="#modalProjeto">
    <span class="fa fa-plus-square-o" onclick="dropdownCreate()">&nbsp;</span> Novo Projeto
  </a></li>
					<!--<li><a class="" href="#" data-toggle="modal" data-target="#exampleModal">
						<span class="fa fa-arrow-right" onclick="dropdownCreate()">&nbsp;</span> Nova Tarefa
					</a></li>-->
					<li><a class="" href="minhas-tarefas.php">
						<span class="fa fa-tasks">&nbsp;</span> Todas as Tarefas
					</a></li>
          <li><a class="" href="#" data-toggle = "modal" data-target="#modalEspecialidade">
						<span class="fa fa-briefcase">&nbsp;</span> Nova Especialidade
					</a></li>
          <li><a class="" href="meus-relatorios.php">
						<span class="fa fa-check-square-o">&nbsp;</span> Tarefas Concluídas
					</a></li>
				</ul>
			</li>
      <li><a href="meu-perfil.php"><em class="fa fa-user">&nbsp;</em> Meu Perfil</a></li>
      <!--<li><a class="" href="#" data-toggle="modal" data-target="#modalAdicionarPessoas"><em class="fa fa-handshake-o">&nbsp;</em> Nova Equipe</a></li>-->
      <li><a href="#" data-toggle="modal" data-target="#modalExplicacao"><em class="fa fa-question">&nbsp;</em> Como funciona o sistema</a></li>
      <li><a href="inc/logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout </a></li>
    </ul>
  </div>