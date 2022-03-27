

/*------------------------------------Funções Preparativas (Sem requisição ajax)--------------------------*/


var vetor=[];

function funcao(email, nome){

  if (document.getElementById("inputAdicionaPessoas").value == ''){
    alert("Por favor, Preencha o email da pessoa a ser adicionada...");
  }
  else{

    if( $.inArray(email, vetor) !== -1 ){
      alert("Você já está adicionando esse email");
    }
    else{        
      vetor.push(email);
    }

    document.getElementById("mostrarVetor").innerHTML = vetor;

    $('#inputAdicionaPessoas').val("");
    $('div[name=mostre]').empty();       
  }
}

function mostraAdicionarTarefa(valor){
  document.getElementById('textoSobreSelect').style.display = 'none';
  document.getElementById('botaoAdicionaTarefa').style.display = 'block';
  document.getElementById('botaoAdicionaTarefa').value = valor;
  if (valor == '') {
    document.getElementById('botaoAdicionaTarefa').style.display = 'none';
    document.getElementById('textoSobreSelect').style.display = 'block';
  }
}

function passaSelect(valorDoSelect){
  document.getElementById("idSelectProjetos").value = valorDoSelect;
  document.getElementById("ocultaSelectProjetos").style.display = 'none';
  var select = document.getElementById('idSelectProjetos');
  var text = select.options[select.selectedIndex].text; 
  document.getElementById("identificaProjeto").innerHTML = "O projeto selecionado é: <b>"+text+"</b>";
}


/*------------------------------------Funções Com Requisições Ajax------------------------------------*/

function enviarVetor(email){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'listarEmails', //Envia esse dado como GET para o webservice 
      email: email
    },
    dataType: 'json',
    success: function(data){
      console.log(data);
      $('div[name=mostre]').empty();
      for(i = 0; i < data.qtd; i++){        
        $('div[name=mostre]').append('<a style="margin: 2px;" onclick = "funcao(this.id, this.name)" class = "btn btn-info" name="'+data.nomeUsuario[i]+'" id="'+data.emailUsuario[i]+'">'+data.emailUsuario[i]+'</a>');
      }
    }
  });
} 

function inserirTarefa() {
  var nomeTarefa = document.getElementById("snomeTarefa").value;
  var especialidadeTarefa = document.getElementById("sselectEspecialidade").value;
  var descricaoTarefa = document.getElementById("sdescricaoTarefa").value;
  var prazoTarefa = document.getElementById("sprazoTarefa").value;
  var metaHorasMensal = document.getElementById("smetaHorasMensal").value;
  var selectTipoTarefa = document.getElementById("sselectTipoTarefa").value;

  //Pegando o valor do select para sabermos em qual projeto a tarefa a seguir será inserida
  var select = document.getElementById('idSelectProjetos');
  var valorSelect = select.options[select.selectedIndex].value;

  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'inserirTarefa',
      nomeTarefa: nomeTarefa,
      especialidadeTarefa: especialidadeTarefa,
      descricaoTarefa: descricaoTarefa,
      prazoTarefa: prazoTarefa,
      metaHorasMensal: metaHorasMensal,
      selectTipoTarefa: selectTipoTarefa,
      valorSelect: valorSelect
    },
    success: function(){
      var valorSelect = document.getElementById('selectProj').value;

      listarTarefasPendentes(valorSelect);
      listarTarefasConcluidas(valorSelect);
      listarTarefasEmAndamento(valorSelect);
      calcularProgresso(valorSelect);
    }
  }); 
}

function editarTarefa() {
  var nomeTarefa = document.getElementById("editarNomeTarefa").value;
  var descricaoTarefa = document.getElementById("editarDescricaoTarefa").value;
  var prazoTarefa = document.getElementById("editarPrazoTarefa").value;
  var metaHorasMensal = document.getElementById("editarMetaHoras").value;
  var idTarefa = document.getElementById("editarIdTarefa").value;

  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'atualizarInformacoes',
      idTarefa: idTarefa,
      nomeTarefa: nomeTarefa,
      descricaoTarefa: descricaoTarefa,
      prazoTarefa: prazoTarefa,
      metaHorasMensal: metaHorasMensal
    },
    success: function(){
      //-----------------Pegar o valor do dropdown-----------------//
      //-----------------------------------------------------------//
      var valorSelect = document.getElementById('selectProj').value;
      //-----------------------------------------------------------//
      listarTarefasPendentes(valorSelect);
      listarTarefasConcluidas(valorSelect);
      listarTarefasEmAndamento(valorSelect);
      calcularProgresso(valorSelect);
    }
  }); 
}

function inserirProjeto(){
  var nomeTarefa = document.getElementById("projnomeTarefa").value;
  var especialidadeTarefa = document.getElementById("projselectEspecialidade").value;
  var descricaoTarefa = document.getElementById("projdescricaoTarefa").value;
  var prazoTarefa = document.getElementById("projprazoTarefa").value;
  var metaHorasMensal = document.getElementById("projmetaHorasMensal").value;
  var selectTipoTarefa = document.getElementById("projselectTipoTarefa").value;

  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'inserirTarefa',
      nomeTarefa: nomeTarefa,
      especialidadeTarefa: especialidadeTarefa,
      descricaoTarefa: descricaoTarefa,
      prazoTarefa: prazoTarefa,
      metaHorasMensal: metaHorasMensal,
      selectTipoTarefa: selectTipoTarefa,
      valorSelect: null
    },
    dataType: 'json',
    success: function(data){
      console.log(data);
      alert("inserido");
    }
  });

}

function inserirIntegrante(){
  var projetoEquipe = document.getElementById("projetoEquipe").value;
  var nomeEquipe = document.getElementById("equipe").value;

  for (var i = 0; i < vetor.length ; i++) {
    $.ajax({
      type: 'GET',
      url: 'requisicoes_assincronas/webservice.php',
      data: {
        acao: 'inserirIntegrante', //Envia esse dado como GET para o webservice 
        projeto: projetoEquipe,
        nomeEquipe: nomeEquipe,
        emailIntegrante: vetor[i]
      },
      dataType: 'json',
      success: function(data){
        console.log(data);
        alert("Inserido");
      }
    });
  }
  buscarEquipes();
  alert("Integrante(s) adicionados!");

  vetor = [];
  document.getElementById("mostrarVetor").innerHTML = vetor;

}

function dropdownCreate(){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
        acao: 'dropdownCreate' //Envia esse dado como GET para o webservice 
      },
      dataType: 'json',
      success: function(data){
        console.log(data);
        for(i = 0; i < data.qtd; i++){
          $('select[name=selectProjetos]').append('<option value="'+data.idTarefa[i]+'">'+data.nomeTarefa[i]+'</option>');
        }
      }
    });
} 

function dropdownTiposProjetos(){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
        acao: 'dropdownTipos' //Envia esse dado como GET para o webservice 
      },
      dataType: 'json',
      success: function(data){
        console.log(data);
        for(i = 0; i < data.qtd; i++){
          $('select[name=projselectTipoTarefa').append('<option value="'+data.idTipoTarefa[i]+'">'+data.nomeTipoTarefa[i]+'</option>');
        }
      }
    });
}

function dropdownTipos(){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
        acao: 'dropdownTipos' //Envia esse dado como GET para o webservice 
      },
      dataType: 'json',
      success: function(data){
        console.log(data);
        for(i = 0; i < data.qtd; i++){
          $('select[name=selectTipoTarefa').append('<option value="'+data.idTipoTarefa[i]+'">'+data.nomeTipoTarefa[i]+'</option>');
        }
      }
    });
}

function dropdownEspecialidadeProjetos(){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
        acao: 'dropdownEspecialidade' //Envia esse dado como GET para o webservice 
      },
      dataType: 'json',
      success: function(data){
        console.log(data);
        for(i = 0; i < data.qtd; i++){
          $('select[name=projselectEspecialidade').append('<option value="'+data.idEspecialidade[i]+'">'+data.nomeEspecialidade[i]+'</option>');
        }
      }
    });
}

function dropdownEspecialidade(){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
        acao: 'dropdownEspecialidade' //Envia esse dado como GET para o webservice 
      },
      dataType: 'json',
      success: function(data){
        console.log(data);
        for(i = 0; i < data.qtd; i++){
          $('select[name=selectEspecialidade').append('<option value="'+data.idEspecialidade[i]+'">'+data.nomeEspecialidade[i]+'</option>');
        }
      }
    });
}  

  //Função responsável por buscar on nomes dos PROJETOS para listar as tarefas do projeto selecionado
  function dropdownProjetos(){
    $.ajax({
      type: 'GET',
      url: 'requisicoes_assincronas/webservice.php',
      data: {
        acao: 'dropdownProjetos' //Envia esse dado como GET para o webservice 
      },
      dataType: 'json',
      success: function(data){
        console.log(data);
        for(i = 0; i < data.qtd; i++){
          $('select[name=selectProjeto]').append('<option value="'+data.idTarefa[i]+'">'+data.nomeTarefa[i]+'</option>');
        }
      }
    });
  }
//Função responsável por buscar on nomes dos PROJETOS para listar as tarefas do projeto selecionado.
function dropdownProjetosConcluidos(){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
        acao: 'dropdownProjetosConcluidos' //Envia esse dado como GET para o webservice.
      },
      dataType: 'json',
      success: function(data){
        console.log(data);
        for(i = 0; i < data.qtd; i++){
          $('select[name=selectProjetoConcluido]').append('<option value="'+data.idTarefa[i]+'">'+data.nomeTarefa[i]+'</option>');
        }
      }
    });
}

///A função a seguir será responsável por trazer as tarefas pendentes por ajax.
function contarTarefasAbertas(){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'contarTarefasAbertas',

    },
    dataType: 'json',
    beforeSend: function(){
      document.getElementById("contarTarefasAbertas").innerHTML = "--";
    },
    success: function(data){
      document.getElementById("contarTarefasAbertas").innerHTML = data.qtd;

    }
  });
}

  //A função a seguir será responsável por trazer as tarefas pendentes por ajax.
  function contarTarefasEmAndamento(){
    $.ajax({
      type: 'GET',
      url: 'requisicoes_assincronas/webservice.php',
      data: {
        acao: 'contarTarefasEmAndamento',

      },
      dataType: 'json',
      beforeSend: function(){
        document.getElementById("contarTarefasEmAndamento").innerHTML = "--";
      },
      success: function(data){
        document.getElementById("contarTarefasEmAndamento").innerHTML = data.qtd;

      }
    });
  }

  //A função a seguir será responsável por trazer as tarefas pendentes por ajax.
  function contarTarefasFinalizadas(){
    $.ajax({
      type: 'GET',
      url: 'requisicoes_assincronas/webservice.php',
      data: {
        acao: 'contarTarefasFinalizadas',

      },
      dataType: 'json',
      beforeSend: function(){
        document.getElementById("contarTarefasFinalizadas").innerHTML = "--";
      },
      success: function(data){
        document.getElementById("contarTarefasFinalizadas").innerHTML = data.qtd;

      }
    });
  }

  function calcularProgresso($idProjeto){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'calcularProgresso',
      id: $idProjeto

    },
    dataType: 'json',
    beforeSend: function(){
        document.getElementById("desempenho").innerHTML = "--";
      },
      success: function(data){
        document.getElementById("desempenho").innerHTML = data.resultado;

      }
    });
  }

//Busca as equipes que o usuario faz parte e mostra na tela inicial
function buscarEquipes(){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'buscarEquipes'
    },
    dataType: 'json',
    beforeSend: function(){
      $('#divMostraEquipe').append('<p>--</p>');
      $('#divMostraEquipe').empty();
    },
    success: function(data){
        $('#divMostraEquipe').empty(); //Criando os índices no html
        for(i = 0; i < data.qtd; i++){
          $("#divMostraEquipe").append('<div class="panel-body timeline-container col-md-4"><ul class="timeline"><li><div class="timeline-badge" style="background-color: #304D63;"><em class="fa fa-users"></em></div><div class="timeline-panel"><div class="timeline-heading"><h4 class="timeline-title" style="font-weight: 700;">'+data.nomeEquipe[i]+'</h4></div><div class="timeline-body"><p><button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalDetalhesEquipe"><i class="fa fa-eye"></i>&nbsp;Ver Detalhes</button><button type="button" style="margin-left:2px;" id="'+data.idEquipe[i]+'" class="btn btn-warning" data-toggle="modal" data-target="#modalEdicaoEquipe"><i class="fa fa-cog"></i></button><button type="button" style="margin-left:2px;" class="btn btn-danger" id="'+data.idEquipe[i]+'" data-toggle="modal" data-target="#"><i class="fa fa-user-times"></i></button><button type="button" style="margin-left:2px;" id="'+data.idEquipe[i]+'" class="btn btn-info" data-toggle="modal" data-target="#"><i class="fa fa-sign-out"></i></button></p><button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalVinculaPessoa"><i class="fa fa-user-plus"></i>&nbsp;Adicionar</button><button type="button" class="btn btn-default" style="margin-left:2px;" data-toggle="modal" data-target="#"><i class="fa fa-plus-square-o"></i>&nbsp; Adic. Projeto</button></div></div></li></ul></div>');       
        }
      }
    });

}


//A função a seguir será responsável por trazer as tarefas pendentes por ajax.
function listarEspecialidades(idProjeto){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'listarTarefasPendentes',
      id: idProjeto
    },
    dataType: 'json',
    beforeSend: function(){
      $('#tabelaDeTarefas').append('<p>--</p>');
      $('#tabelaDeTarefas').empty();
    },
    success: function(data){
      $('#tarefasPendentes').empty();
        $('#tarefasPendentes').append('<tr><th style="padding: 20px;">Nome da Tarefa</th><th style="padding: 20px;">Descrição da Tarefa</th><th style="padding: 20px;">Data Criação</th><th style="padding: 20px;">Prazo</th><th style="padding: 20px;">Fazer</th><th style="padding: 20px;">Detalhes</th><th style="padding: 20px;">Editar</th><th style="padding: 20px;">Excluir</th></tr>'); //Criando os índices no html
        for(i = 0; i < data.qtd; i++){
          $("#tarefasPendentes").append('<tr><td style="padding: 20px;" >'+data.nomeTarefa[i]+'</td><td style="padding: 20px;"><a id="'+data.idTarefa[i]+'" name="botaoDescricao" class="btn btn-primary" href="#" data-toggle="modal" onclick="buscarDescricao(this.id)" data-target="#modalDescricao">Ver descrição</a></td><td style="padding: 20px;" >'+data.dataCriacao[i]+'</td><td style="padding: 20px;" >'+data.prazoTarefa[i]+'</td><td class = "td_ajuste"><a id="'+data.idTarefa[i]+'" class="btn btn-info" onclick="confirmarInicio(this.id)" data-toggle="modal" data-target="#modalInicio"><i style="font-size: 1.2em;" class="fa fa-hand-o-left"></i></a></td><td class = "td_ajuste"><a href="#" data-toggle="modal" id = "'+data.idTarefa[i]+'"class="btn btn-primary" onclick="buscarTodosDetalhes(this.id)" data-target="#modalDetalhes" style="background-color: #4E5344; border-color: #4E5344"><i style="font-size: 1.2em;" class="fa fa-list-alt"></i></a></td><td class = "td_ajuste"><a href="#" id = "'+data.idTarefa[i]+'" class="btn btn-primary" data-toggle="modal"  data-target="#modalEdicao" onclick="buscarInformacoes(this.id)"><i style="font-size: 1.2em;" class="fa fa-pencil"></i></a></td><td class = "td_ajuste"><a class="btn btn-danger" id="'+data.idTarefa[i]+'" onclick="confirmarExclusao(this.id)" data-toggle="modal" data-target="#modalConfirmacao"><i style="font-size: 1.4em;" class="fa fa-trash"></i></a></td></tr>'); //Aqui está sendo criado uma linha de uma tabela a cada looping 
          document.getElementById("quantTarefasPendentes").innerHTML = data.qtd;      
        }
      }
    });
}

//A função a seguir será responsável por trazer as tarefas pendentes por ajax.
function listarTarefasPendentes(idProjeto){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'listarTarefasPendentes',
      id: idProjeto
    },
    dataType: 'json',
    beforeSend: function(){
      $('#tabelaDeTarefas').append('<p>--</p>');
      $('#tabelaDeTarefas').empty();
    },
    success: function(data){
      $('#tarefasPendentes').empty();
      $('#quantTarefasPendentes').empty();
        $('#tarefasPendentes').append('<tr><th style="padding: 20px;">Nome da Tarefa</th><th style="padding: 20px;">Descrição da Tarefa</th><th style="padding: 20px;">Data Criação</th><th style="padding: 20px;">Prazo</th><th style="padding: 20px;">Fazer</th><th style="padding: 20px;">Detalhes</th><th style="padding: 20px;">Editar</th><th style="padding: 20px;">Excluir</th></tr>'); //Criando os índices no html
        for(i = 0; i < data.qtd; i++){
          $("#tarefasPendentes").append('<tr><td style="padding: 20px;" >'+data.nomeTarefa[i]+'</td><td style="padding: 20px;"><a id="'+data.idTarefa[i]+'" name="botaoDescricao" class="btn btn-primary" href="#" data-toggle="modal" onclick="buscarDescricao(this.id)" data-target="#modalDescricao">Ver descrição</a></td><td style="padding: 20px;" >'+data.dataCriacao[i]+'</td><td style="padding: 20px;" >'+data.prazoTarefa[i]+'</td><td class = "td_ajuste"><a id="'+data.idTarefa[i]+'" class="btn btn-info" onclick="confirmarInicio(this.id)" data-toggle="modal" data-target="#modalInicio"><i style="font-size: 1.2em;" class="fa fa-hand-o-left"></i></a></td><td class = "td_ajuste"><a href="#" data-toggle="modal" id = "'+data.idTarefa[i]+'"class="btn btn-primary" onclick="buscarTodosDetalhes(this.id)" data-target="#modalDetalhes" style="background-color: #4E5344; border-color: #4E5344"><i style="font-size: 1.2em;" class="fa fa-list-alt"></i></a></td><td class = "td_ajuste"><a href="#" id = "'+data.idTarefa[i]+'" class="btn btn-primary" data-toggle="modal"  data-target="#modalEdicao" onclick="buscarInformacoes(this.id)"><i style="font-size: 1.2em;" class="fa fa-pencil"></i></a></td><td class = "td_ajuste"><a class="btn btn-danger" id="'+data.idTarefa[i]+'" onclick="confirmarExclusao(this.id)" data-toggle="modal" data-target="#modalConfirmacao"><i style="font-size: 1.4em;" class="fa fa-trash"></i></a></td></tr>'); //Aqui está sendo criado uma linha de uma tabela a cada looping 
          document.getElementById("quantTarefasPendentes").innerHTML = data.qtd;      
        }
      }
    });
}

//A função a seguir será responsável por trazer as tarefas em andamento por ajax.
function listarTarefasEmAndamento(idProjeto){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'listarTarefasEmAndamento',
      id: idProjeto
    },
    dataType: 'json',
    beforeSend: function(){
      $('#tabelaDeTarefasAndamento').append('<p>--</p>');
      $('#tabelaDeTarefasAndamento').empty();
    },
    success: function(data){
      $('#tarefasEmAndamento').empty();
        $('#tarefasEmAndamento').append('<tr><th style="padding: 20px;">Nome da Tarefa</th><th style="padding: 20px;">Descrição da Tarefa</th><th style="padding: 20px;">Data Criação</th><th style="padding: 20px;">Prazo</th><th style="padding: 20px;">Concluir</th><th style="padding: 20px;">Pendente</th><th style="padding: 20px;">Detalhes</th><th style="padding: 20px;">Editar</th><th style="padding: 20px;">Excluir</th></tr>'); //Criando os índices no html
        for(i = 0; i < data.qtd; i++){
          $("#tarefasEmAndamento").append('<tr><td style="padding: 20px;" >'+data.nomeTarefa[i]+'</td><td style="padding: 20px;"><a id="'+data.idTarefa[i]+'" name="botaoDescricao" class="btn btn-primary" href="#" data-toggle="modal" onclick="buscarDescricao(this.id)" data-target="#modalDescricao">Ver descrição</a></td><td style="padding: 20px;" >'+data.dataCriacao[i]+'</td><td style="padding: 20px;" >'+data.prazoTarefa[i]+'</td><td class = "td_ajuste"><a id="'+data.idTarefa[i]+'" class="btn btn-success" onclick="confirmarConclusao(this.id)" data-toggle="modal" data-target="#modalConclusao"><i style="font-size: 1.2em;" class="fa fa-check"></i></a></td><td class = "td_ajuste"><a id="'+data.idTarefa[i]+'" class="btn btn-warning" onclick="confirmarPendencia(this.id)" data-toggle="modal" data-target="#modalPendencia"><i style="font-size: 1.2em;" class="fa fa-undo"></i></a></td><td class = "td_ajuste"><a href="#" data-toggle="modal" id = "'+data.idTarefa[i]+'"class="btn btn-primary" onclick="buscarTodosDetalhes(this.id)" data-target="#modalDetalhes" style="background-color: #4E5344; border-color: #4E5344"><i style="font-size: 1.2em;" class="fa fa-list-alt"></i></a></td><td class = "td_ajuste"><a href="#" id = "'+data.idTarefa[i]+'" class="btn btn-primary" data-toggle="modal"  data-target="#modalEdicao" onclick="buscarInformacoes(this.id)"><i style="font-size: 1.2em;" class="fa fa-pencil"></i></a></td><td class = "td_ajuste"><a class="btn btn-danger" id="'+data.idTarefa[i]+'" onclick="confirmarExclusao(this.id)" data-toggle="modal" data-target="#modalConfirmacao"><i style="font-size: 1.4em;" class="fa fa-trash"></i></a></td></tr>'); //Aqui está sendo criado uma linha de uma tabela a cada looping
          document.getElementById("quantTarefasEmAndamento").innerHTML = data.qtd;       
        }
      }
    });
}

//A função a seguir será responsável por trazer as tarefas concluidas por ajax.
function listarTarefasConcluidas(idProjeto){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'listarTarefasConcluidas',
      id: idProjeto
    },
    dataType: 'json',
    beforeSend: function(){
      $('#tabelaDeTarefasConcluidas').append('<p>--</p>');
      $('#tabelaDeTarefasConcluidas').empty();
    },
    success: function(data){
      $('#tarefasConcluidas').empty();
      $('#quantTarefasConcluidas').empty();
        $('#tarefasConcluidas').append('<tr><th style="padding: 20px;">Nome da Tarefa</th><th style="padding: 20px;">Descrição da Tarefa</th><th style="padding: 20px;">Data Criação</th><th style="padding: 20px;">Prazo</th><th style="padding: 20px;">Renovar</th><th style="padding: 20px;">Detalhes</th><th style="padding: 20px;">Excluir</th></tr>'); //Criando os índices no html
        for(i = 0; i < data.qtd; i++){
          $("#tarefasConcluidas").append('<tr><td style="padding: 20px;" >'+data.nomeTarefa[i]+'</td><td style="padding: 20px;"><a id="'+data.idTarefa[i]+'" name = "botaoDescricao" class="btn btn-primary" href="#" value="" data-toggle="modal" onclick="buscarDescricao(this.id)" data-target="#modalDescricao">Ver descrição</a></td><td style="padding: 20px;" >'+data.dataCriacao[i]+'</td><td style="padding: 20px;" >'+data.prazoTarefa[i]+'</td><td class = "td_ajuste"><a id="'+data.idTarefa[i]+'" class="btn btn-info" onclick="confirmarInicio(this.id)" data-toggle="modal" data-target="#modalRenovacao"><i style="font-size: 1.2em;" class="fa fa-hand-o-left"></i></a></td><td class = "td_ajuste"><a href="#" data-toggle="modal" id = "'+data.idTarefa[i]+'" class="btn btn-primary" onclick="buscarTodosDetalhes(this.id)" data-target="#modalDetalhes" style="background-color: #4E5344; border-color: #4E5344"><i style="font-size: 1.2em;" class="fa fa-list-alt"></i></a></td><td class = "td_ajuste"><a class="btn btn-danger" id="'+data.idTarefa[i]+'" onclick="confirmarExclusao(this.id)" data-toggle="modal" data-target="#modalConfirmacao"><i style="font-size: 1.4em;" class="fa fa-trash"></i></a></td></tr>'); //Aqui está sendo criado uma linha de uma tabela a cada looping    
          document.getElementById("quantTarefasConcluidas").innerHTML = data.qtd;  
        }
      }
    });
}

//A função a seguir será responsável por trazer as tarefas concluidas por ajax.
function listarProjetos(idStatus){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'listarProjetos',
      id: idStatus
    },
    dataType: 'json',
    beforeSend: function(){
      $('#tabelaDeProjetos').append('<p>--</p>');
      $('#tabelaDeProjetos').empty();
    },
    success: function(data){
      if(idStatus == 1) {
        $('#tabelaDeProjetos').empty();
        $('#tabelaProjetos').empty();
          $('#tabelaProjetos').append('<tr><th style="padding: 20px;">Nome da Tarefa</th><th style="padding: 20px;">Descrição da Tarefa</th><th style="padding: 20px;">Data Criação</th><th style="padding: 20px;">Prazo</th><th style="padding: 20px;">Iniciar</th><th style="padding: 20px;">Detalhes</th><th style="padding: 20px;">Editar</th><th style="padding: 20px;">Excluir</th></tr>'); //Criando os índices no html
          for(i = 0; i < data.qtd; i++){
            $("#tabelaProjetos").append('<tr><td style="padding: 20px;" >'+data.nomeTarefa[i]+'</td><td style="padding: 20px;"><a id="'+data.idTarefa[i]+'" name="botaoDescricao" class="btn btn-primary" href="#" data-toggle="modal" onclick="buscarDescricao(this.id)" data-target="#modalDescricao">Ver descrição</a></td><td style="padding: 20px;" >'+data.dataCriacao[i]+'</td><td style="padding: 20px;" >'+data.prazoTarefa[i]+'</td><td class = "td_ajuste"><a id="'+data.idTarefa[i]+'" class="btn btn-info" onclick="confirmarInicio(this.id)" data-toggle="modal" data-target="#modalInicio"><i style="font-size: 1.2em;" class="fa fa-hand-o-left"></i></a></td><td class = "td_ajuste"><a href="#" data-toggle="modal" id = "'+data.idTarefa[i]+'"class="btn btn-primary" onclick="buscarTodosDetalhes(this.id)" data-target="#modalDetalhes" style="background-color: #4E5344; border-color: #4E5344"><i style="font-size: 1.2em;" class="fa fa-list-alt"></i></a></td><td class = "td_ajuste"><a href="#" id = "'+data.idTarefa[i]+'" class="btn btn-primary" data-toggle="modal"  data-target="#modalEdicao" onclick="buscarInformacoes(this.id)"><i style="font-size: 1.2em;" class="fa fa-pencil"></i></a></td><td class = "td_ajuste"><a class="btn btn-danger" id="'+data.idTarefa[i]+'" onclick="confirmarExclusao(this.id)" data-toggle="modal" data-target="#modalConfirmacao"><i style="font-size: 1.4em;" class="fa fa-trash"></i></a></td></tr>'); //Aqui está sendo criado uma linha de uma tabela a cada looping      
          }
        }
        else if(idStatus == 2) {
          $('#tabelaDeProjetos').empty();
          $('#tabelaProjetos').empty();
          $('#tabelaProjetos').append('<tr><th style="padding: 20px;">Nome da Tarefa</th><th style="padding: 20px;">Descrição da Tarefa</th><th style="padding: 20px;">Data Criação</th><th style="padding: 20px;">Prazo</th><th style="padding: 20px;">Concluir</th><th style="padding: 20px;">Detalhes</th><th style="padding: 20px;">Editar</th><th style="padding: 20px;">Excluir</th></tr>'); //Criando os índices no html
          for(i = 0; i < data.qtd; i++){
            $("#tabelaProjetos").append('<tr><td style="padding: 20px;" >'+data.nomeTarefa[i]+'</td><td style="padding: 20px;"><a id="'+data.idTarefa[i]+'" name="botaoDescricao" class="btn btn-primary" href="#" data-toggle="modal" onclick="buscarDescricao(this.id)" data-target="#modalDescricao">Ver descrição</a></td><td style="padding: 20px;" >'+data.dataCriacao[i]+'</td><td style="padding: 20px;" >'+data.prazoTarefa[i]+'</td><td class = "td_ajuste"><a id="'+data.idTarefa[i]+'" class="btn btn-info" onclick="confirmarConclusao(this.id)" data-toggle="modal" data-target="#modalConclusao"><i style="font-size: 1.2em;" class="fa fa-hand-o-left"></i></a></td><td class = "td_ajuste"><a href="#" data-toggle="modal" id = "'+data.idTarefa[i]+'"class="btn btn-primary" onclick="buscarTodosDetalhes(this.id)" data-target="#modalDetalhes" style="background-color: #4E5344; border-color: #4E5344"><i style="font-size: 1.2em;" class="fa fa-list-alt"></i></a></td><td class = "td_ajuste"><a href="#" id = "'+data.idTarefa[i]+'" class="btn btn-primary" data-toggle="modal"  data-target="#modalEdicao" onclick="buscarInformacoes(this.id)"><i style="font-size: 1.2em;" class="fa fa-pencil"></i></a></td><td class = "td_ajuste"><a class="btn btn-danger" id="'+data.idTarefa[i]+'" onclick="confirmarExclusao(this.id)" data-toggle="modal" data-target="#modalConfirmacao"><i style="font-size: 1.4em;" class="fa fa-trash"></i></a></td></tr>'); //Aqui está sendo criado uma linha de uma tabela a cada looping      
          }
        }
        else if(idStatus == 3){
          $('#tabelaDeProjetos').empty();
          $('#tabelaProjetos').empty();
          $('#tabelaProjetos').append('<tr><th style="padding: 20px;">Nome da Tarefa</th><th style="padding: 20px;">Descrição da Tarefa</th><th style="padding: 20px;">Data Criação</th><th style="padding: 20px;">Prazo</th><th style="padding: 20px;">Renovar</th><th style="padding: 20px;">Detalhes</th><th style="padding: 20px;">Editar</th><th style="padding: 20px;">Excluir</th></tr>'); //Criando os índices no html
          for(i = 0; i < data.qtd; i++){
            $("#tabelaProjetos").append('<tr><td style="padding: 20px;" >'+data.nomeTarefa[i]+'</td><td style="padding: 20px;"><a id="'+data.idTarefa[i]+'" name="botaoDescricao" class="btn btn-primary" href="#" data-toggle="modal" onclick="buscarDescricao(this.id)" data-target="#modalDescricao">Ver descrição</a></td><td style="padding: 20px;" >'+data.dataCriacao[i]+'</td><td style="padding: 20px;" >'+data.prazoTarefa[i]+'</td><td class = "td_ajuste"><a id="'+data.idTarefa[i]+'" class="btn btn-info" onclick="confirmarInicio(this.id)" data-toggle="modal" data-target="#modalInicio"><i style="font-size: 1.2em;" class="fa fa-hand-o-left"></i></a></td><td class = "td_ajuste"><a href="#" data-toggle="modal" id = "'+data.idTarefa[i]+'"class="btn btn-primary" onclick="buscarTodosDetalhes(this.id)" data-target="#modalDetalhes" style="background-color: #4E5344; border-color: #4E5344"><i style="font-size: 1.2em;" class="fa fa-list-alt"></i></a></td><td class = "td_ajuste"><a href="#" id = "'+data.idTarefa[i]+'" class="btn btn-primary" data-toggle="modal"  data-target="#modalEdicao" onclick="buscarInformacoes(this.id)"><i style="font-size: 1.2em;" class="fa fa-pencil"></i></a></td><td class = "td_ajuste"><a class="btn btn-danger" id="'+data.idTarefa[i]+'" onclick="confirmarExclusao(this.id)" data-toggle="modal" data-target="#modalConfirmacao"><i style="font-size: 1.4em;" class="fa fa-trash"></i></a></td></tr>'); //Aqui está sendo criado uma linha de uma tabela a cada looping      
          }          
        }
      }
    });
}

//A função a seguir será responsável por trazer as tarefas na lixeira por ajax.
function listarTarefasExcluidas(idProjeto){
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'listarTarefasExcluidas',
      id: idProjeto
    },
    dataType: 'json',
    beforeSend: function(){
      $('#tabelaDeTarefasNaLixeira').append('<p>--</p>');
      $('#tabelaDeTarefasNaLixeira').empty();
    },
    success: function(data){
      $('#tarefasNaLixeira').empty();
        $('#tarefasNaLixeira').append('<tr><th style="padding: 20px;">Nome da Tarefa</th><th style="padding: 20px;">Descrição da Tarefa</th><th style="padding: 20px;">Data Criação</th><th style="padding: 20px;">Prazo</th><th style="padding: 20px;">Concluir</th><th style="padding: 20px;">Detalhes</th><th style="padding: 20px;">Editar</th><th style="padding: 20px;">Excluir</th></tr>'); //Criando os índices no html
        for(i = 0; i < data.qtd; i++){
          $("#tarefasEmAndamento").append('<tr><td style="padding: 20px;" >'+data.nomeTarefa[i]+'</td><td style="padding: 20px;"><a id="'+data.idTarefa[i]+'" name = "botaoDescricao" class="btn btn-primary" href="#" value="" data-toggle="modal" onclick="buscarDescricao(this.id)" data-target="#modalDescricao">Ver descrição</a></td><td style="padding: 20px;" >'+data.dataCriacao[i]+'</td><td style="padding: 20px;" >'+data.prazoTarefa[i]+'</td><td class = "td_ajuste"><a id="'+data.idTarefa[i]+'" class="btn btn-success" onclick="confirmarConclusao(this.id)" data-toggle="modal" data-target="#modalConclusao"><i style="font-size: 1.2em;" class="fa fa-thumbs-o-up"></i></a></td><td class = "td_ajuste"><a href="#" data-toggle="modal" id = "'+data.idTarefa[i]+'" class="btn btn-primary" onclick="buscarTodosDetalhes(this.id)" data-target="#modalDetalhes" style="background-color: #4E5344; border-color: #4E5344"><i style="font-size: 1.2em;" class="fa fa-list-alt"></i></a></td><td class = "td_ajuste"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalEdicao" id = "'+data.idTarefa[i]+'" onclick="buscarInformacoes(this.id)"><i style="font-size: 1.2em;" class="fa fa-pencil"></i></a></td><td class = "td_ajuste"><a class="btn btn-danger" id="'+data.idTarefa[i]+'" onclick="moverParaLixeira(this.id)" data-toggle="modal" data-target="#modalConfirmacao"><i style="font-size: 1.4em;" class="fa fa-trash"></i></a></td></tr>'); //Aqui está sendo criado uma linha de uma tabela a cada looping   
        }
      }
    });
}
  //A Função a seguir será responsável por buscar apenas a descrição da tarefa
  function buscarDescricao(idDescProjeto){ 
    $.ajax({
      type: 'GET',
      url: 'requisicoes_assincronas/webservice.php',
      data: {
        acao: 'buscarDescricao',
        id: idDescProjeto
      },
      dataType: 'json',
      beforeSend: function(){
        $('#textoDescricao').empty();
        $('#textoDescricao').append('<p>--</p>');
      },
      success: function(data){
        $('#textoDescricao').empty();
        for(i = 0; i < data.qtd; i++){
          $("#textoDescricao").append('<p>'+data.descricaoTarefa+'</p>'); //Aqui está sendo criado uma linha de uma tabela a cada looping       
        }
      }
    });
  }

  function buscarProjetoPai(id){ 
    $.ajax({
      type: 'GET',
      url: 'requisicoes_assincronas/webservice.php',
      data: {
        acao: 'buscarProjetoPai',
        id: id
      },
      dataType: 'json',
      success: function(data){
        document.getElementById("projetoDetalhes").innerHTML = data.FK_nomeTarefa;       
      }
    });
  }

//Função responsável por excluir o registro da tarefa no banco de dados.
function excluirTarefa(id){ 
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'excluirTarefa',
      idTarefa: id
    },
    success: function(){
      var valorSelect = document.getElementById('selectProj').value;
        listarTarefasPendentes(valorSelect);
        listarTarefasConcluidas(valorSelect);
        listarTarefasEmAndamento(valorSelect);
        calcularProgresso(valorSelect); 
    }
  });
  var valo = document.getElementById('selectProjetosConcluidos').value;
  listarTarefasConcluidas(valo);
  calcularProgresso(valo);
} 


function excluirEspecialidade(id){ 
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'excluirEspecialidade',
      idEspecialidade: id
    },
    success: function(data){
      buscarEspecialidadeDoUsuario();       
    }
  });
  
} 
//Função responsável por mudar o status da tarefa para "em andamento".
function comecarTarefa(id){ 
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'comecarTarefa',
      id: id
    },
    dataType: 'json',
    success: function(){
      var valorSelect = document.getElementById('selectProj').value;

      listarTarefasPendentes(valorSelect);
      listarTarefasConcluidas(valorSelect);
      listarTarefasEmAndamento(valorSelect);
      calcularProgresso(valorSelect);
    }
  });
  var valo = document.getElementById('selectProjetosConcluidos').value;
  listarTarefasEmAndamento(valo);
  listarTarefasConcluidas(valo);
  contarTarefasAbertas(valo);
  contarTarefasFinalizadas(valo);
  calcularProgresso(valo);
   
}  
//Função responsável por mudar o status da tarefa para "concluído".


function concluirTarefa(id){ 
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'concluirTarefa',
      id: id
    },
    dataType: 'json',
    success: function(){
      var valorSelect = document.getElementById('selectProj').value;

      listarTarefasPendentes(valorSelect);
      listarTarefasEmAndamento(valorSelect);
      calcularProgresso(valorSelect);
    }
  });
}

function tornarPendente(id){ 
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'tornarPendente',
      id: id
    },
    dataType: 'json',
    success: function(){
      var valorSelect = document.getElementById('selectProj').value;
      listarTarefasPendentes(valorSelect);
      listarTarefasEmAndamento(valorSelect);
      calcularProgresso(valorSelect);
    }
  });
  

}
//Função responsável por mudar o status da tarefa para "na lixeira".
function moverParaLixeira(id){ 
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'moverParaLixeira',
      id: id
    },
    dataType: 'json',
  });
}     
  //A Função a seguir será responsável por buscar alguns detalhes da tarefa
  function buscarDetalhes(id){ 
    $.ajax({
      type: 'GET',
      url: 'requisicoes_assincronas/webservice.php',
      data: {
        acao: 'buscarDetalhes',
        id: id
      },
      dataType: 'json',

      success: function(data){
        document.getElementById("nomeTarefaDetalhes").innerHTML = data.nomeTarefa;
        document.getElementById("statusTarefaDetalhes").innerHTML = data.nomeStatus;
        document.getElementById("prazoTarefaDetalhes").innerHTML = data.prazoTarefa;
        document.getElementById("criadorDetalhes").innerHTML = data.nomeUsuario;
        document.getElementById("dataCriacaoDetalhes").innerHTML = data.dataCriacao;
        document.getElementById("especialidadeTarefaDetalhes").innerHTML = data.nomeEspecialidade;  
      }
    });
  }
  function dropdownProjetos(){
    $.ajax({
      type: 'GET',
      url: 'requisicoes_assincronas/webservice.php',
      data: {
        acao: 'dropdownProjetos' //Envia esse dado como GET para o webservice 
      },
      dataType: 'json',
      success: function(data){
        console.log(data);
        for(i = 0; i < data.qtd; i++){
          $('select[name=selectProjeto]').append('<option value="'+data.idTarefa[i]+'">'+data.nomeTarefa[i]+'</option>');
        }
      }
    });
  }
  function buscarEmails(){
    alert("Funcionou");
  }

  //A Função a seguir será responsável por buscar alguns detalhes da tarefa
  function buscarEspecialidadeDoUsuario(){ 
    $.ajax({
      type: 'GET',
      url: 'requisicoes_assincronas/webservice.php',
      data: {
        acao: 'listarEspecialidadesDoUsuario'
      },
      dataType: 'json',
      beforeSend: function(){
        $('#nomeEspecialidades').empty();
      },
      success: function(data){
        console.log(data);
        for(i = 0; i < data.qtd; i++){ 
          $('#nomeEspecialidades').append(' '+data.nomeEspecialidade[i]+' <span id="'+data.idEspecialidade[i]+'" onclick="excluirEspecialidade(this.id)"><i style = "color: red;" class="fa fa-minus-circle" aria-hidden="true></i>"</span> <spam style="color: black;">|</spam> ');   
        }
      }
    });
  }
  //Função responsável por confirmar a exclusão de uma tarefa através do modal.
  function confirmarExclusao(id){
    $('[name = botaoExcluir]').val(id);
  }
  //Função responsável por confirmar a conclusão de uma tarefa através do modal.
  function confirmarConclusao(id){
    $('[name = botaoConcluir]').val(id);
  }

  function confirmarPendencia(id){
    $('[name = botaoPendencia]').val(id);
  }
  //Função responsável por confirmar o início de uma tarefa através do modal.
  function confirmarInicio(id){
    $('[name = botaoIniciar]').val(id);
  }

//Função responsável por buscar as informações para fazer o update.
function buscarInformacoes(id){ 
  $.ajax({
    type: 'GET',
    url: 'requisicoes_assincronas/webservice.php',
    data: {
      acao: 'buscarInformacoes',
      id: id
    },
    dataType: 'json',

    success: function(data){
      $('#editarIdTarefa').val(data.idTarefa);
      $('#editarNomeTarefa').val(data.nomeTarefa);
      document.getElementById("editarDescricaoTarefa").innerHTML = data.descricaoTarefa;
      $('#editarPrazoTarefa').val(data.prazoTarefa);
      $('#editarMetaHoras').val(data.metaHorasMensal);
    }
  });
}

function buscarTodosDetalhes(id){
  buscarDetalhes(id);
  buscarProjetoPai(id);
}
  //A Função a seguir sersá responsável por listar as tarefas pendentes e em andamento de forma assíncrona   
  $('select[name=selectProjeto]').change(function(){
    var idDoProjeto = $(this).val();
    listarTarefasPendentes(idDoProjeto); 
    listarTarefasEmAndamento(idDoProjeto);
    listarTarefasConcluidas(idDoProjeto);
    calcularProgresso(idDoProjeto);

    //A variável idDoProjeto passa o id do dropbox para a requisicoes_assincronas/webservice.php para que seja feito o select das tarefas de acordo com o projeto selecionado
  });


  $('select[name=selectProjetoConcluido]').change(function(){
    var idDoProjeto = $(this).val();
    listarTarefasConcluidas(idDoProjeto);
    listarTarefasEmAndamento(idDoProjeto);
    listarTarefasPendentes(idDoProjeto);
    contar(idDoProjeto);
    //A variável idDoProjeto passa o id do dropbox para a requisicoes_assincronas/webservice.php para que seja feito o select das tarefas de acordo com o projeto selecionado
  });

  $('select[name=dropProjetos]').change(function(){
    $('#tabelaProjetos').empty();
    var idStatus= $(this).val();
    listarProjetos(idStatus);
    //A variável idDoProjeto passa o id do dropbox para a requisicoes_assincronas/webservice.php para que seja feito o select das tarefas de acordo com o projeto selecionado
  });

  function excluirERecarregar(id){
    excluirTarefa(id);
  }
  
  $('button[name=botaoIniciar]').click(function(){
    var valor= $(this).val();
    $.ajax({
      type: 'GET',
      url: 'requisicoes_assincronas/webservice.php',
      data: {
        acao: 'buscarProjetoPai',
        id: valor
      },
      dataType: 'json',
      success: function(data){
        var idPai = data.idTarefa;   
        //listarTarefasPendentes(idPai);
        //listarTarefasEmAndamento(idPai);
        //calcularProgresso(idPai);  
      }
    });
  });

  $('button[name=botaoExcluir]').click(function(){
    var valor= $(this).val();
    $.ajax({
      type: 'GET',
      url: 'requisicoes_assincronas/webservice.php',
      data: {
        acao: 'buscarProjetoPai',
        id: valor
      },
      dataType: 'json',
      success: function(data){
        var idPai = data.idTarefa;   
        //listarTarefasPendentes(idPai);
        //listarTarefasEmAndamento(idPai);
        //calcularProgresso(idPai);  
      }
    });
  });

  $('button[name=botaoConcluir]').click(function(){
    var valor= $(this).val();
    $.ajax({
      type: 'GET',
      url: 'requisicoes_assincronas/webservice.php',
      data: {
        acao: 'buscarProjetoPai',
        id: valor
      },
      dataType: 'json',
      success: function(data){
        var idPai = data.idTarefa;   
        //listarTarefasEmAndamento(idPai); 
        //calcularProgresso(idPai);  
      }
    });
  });


  //A Função a seguir será responsável por preencher o dropbox da seleção do projeto.
  $(document).ready(function(){
    dropdownCreate();
    dropdownTipos();
    dropdownTiposProjetos();
    dropdownEspecialidade();
    dropdownEspecialidadeProjetos();
    dropdownProjetos();
    dropdownProjetosConcluidos();
    buscarEspecialidadeDoUsuario();
    buscarEquipes();
  });