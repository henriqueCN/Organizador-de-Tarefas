<?php

class Status extends Crud{

    private $idStatus;
    private $nomeStatus;


    public function getIdStatus()
    {
        return $this->idStatus;
    }

    public function setIdStatus($idStatus): void
    {
        $this->idStatus = $idStatus;
    }

    public function getNomeStatus()
    {
        return $this->nomeStatus;
    }

    public function setNomeStatus($nomeStatus): void
    {
        $this->nomeStatus = $nomeStatus;
    }


}