<?php
include_once("../../controller/includes.php");

$especialidade = new Especialidade();

//create
$tabela = 'especialidade';
$colunas = ['nomeEspecialidade, descricaoEspecialidade'];
$valores = ['"Tess"','"e@e.com"','"123"','"1"'];

$especialidade->setIdEspecialidade(1);
$especialidade->setNomeEspecialidade('especialidadeta');
$especialidade->setDescricaoEspecialidade("Testando");

$idEspecialidade = $especialidade->getIdEspecialidade();
$nomeEspecialidade = $especialidade->getNomeEspecialidade();
$descricaoEspecialidade = $especialidade->getDescricaoEspecialidade();

$especialidade->setTabela($tabela);
$especialidade->setColunas($colunas);
$especialidade->setValores($valores);

$especialidade->create($especialidade->getTabela(), $especialidade->getColunas(), $especialidade->getValores());


