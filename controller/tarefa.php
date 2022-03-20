<?php
include_once('crud.php');
class Tarefa extends Crud{
    private $idTarefa;
    private $nomeTarefa;
    private $descricaoTarefa;
    //ola


    public function getIdTarefa()
    {
        return $this->idTarefa;
    }

    public function setIdTarefa($idTarefa): void
    {
        $this->idTarefa = $idTarefa;
    }

    public function getNomeTarefa()
    {
        return $this->nomeTarefa;
    }

    public function setNomeTarefa($nomeTarefa): void
    {
        $this->nomeTarefa = $nomeTarefa;
    }

    public function getDescricaoTarefa()
    {
        return $this->descricaoTarefa;
    }

    public function setDescricaoTarefa($descricaoTarefa): void
    {
        $this->descricaoTarefa = $descricaoTarefa;
    }


}