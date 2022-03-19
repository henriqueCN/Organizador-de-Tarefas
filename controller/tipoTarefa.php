<?php

class TipoTarefa extends Crud{

    private $idTipoTarefa;
    private $nomeTipoTarefa;


    public function getIdTipoTarefa()
    {
        return $this->idTipoTarefa;
    }

    public function setIdTipoTarefa($idTipoTarefa): void
    {
        $this->idTipoTarefa = $idTipoTarefa;
    }

    public function getNomeTipoTarefa()
    {
        return $this->nomeTipoTarefa;
    }

    public function setNomeTipoTarefa($nomeTipoTarefa): void
    {
        $this->nomeTipoTarefa = $nomeTipoTarefa;
    }

}