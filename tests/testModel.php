<?php
/*
ATENÇÃO:
As "Partes" escritas no 
projeto são para organizar
a documentação do mesmo, 
para conseguir a documentação
entre em contato comigo.

Email:
henriquecostadonascimento@gmail.com 
*/

//Parte 12  --Testes de Unidade, TIRE AS TAGS "/**/" PARA TESTAR--
include_once("../model/model.php");
/*
$tabela = 'especiaaalidade';
$atributos = ['nomeEspecialidade = "ORACLE"'];
$condicao = ['idEspecialidade = 5 and nomeEspecialidade = "UHU"'];
$model = new Model();
$model->update($tabela, $atributos, $condicao);*/
//CREATE
/*$tabela = 'tarefa';
$colunas = ['nomeTarefa, descricaoTarefa, idUsuario, idStatus'];
$valores = ['"teste", "jjjjj","1", "2"'];
$model = new Model();
$model->create($tabela, $colunas, $valores);

//UPDATE
$tabela = 'especialidade';
$atributos = ['nomeEspecialidade = "ORACLE"'];
$condicao = ['idEspecialidade = 5 and nomeEspecialidade = "UHU"'];
$model = new Model();
$model->update($tabela, $atributos, $condicao);

//DELETE
/*$tabela = 'especialidade';
$condicao = 'idEspecialidade = "6"';
$model = new Model();
$model->delete($tabela, $condicao);*/

//FIND

$tabela = 'especialidade';
$condicao = 'idEspecialidade = 1';
$model = new Model();
$valores = $model->find($tabela, $condicao);
var_dump($valores);

//FINDALL
/*$tabela = 'especialidade';
$model = new Model();
$model->findAll($tabela);*/

//FIND COM LEFT JOIN 
/*$tabelaPai = 'especialidade';
$tabelaFilha = 'listaespecialidade';
$condicao = "nomeEspecialidade like '%'";
$model = new Model();
$model->findLeftJoinEstatico($tabelaPai, $tabelaFilha, $condicao);*/

//FINDLEFTJOINGENERICO
/*$tabela = 'usuario'; 
$condicao = "emailUsuario = 'henriquecostadonascimento@gg.com'";
$model = new Model();
$model->findLeftJoinGenerico($tabela, $condicao);*/

//FINDALLLEFTJOINGENERICO
/*$tabela = 'tarefa'; 
$model = new Model();
$model->findAllLeftJoinGenerico($tabela);*/


