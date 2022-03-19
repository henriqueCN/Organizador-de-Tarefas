<?php

class ListaAcao extends Crud{

    private $dataInicio;
    private $dataTermino;

    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    public function setDataInicio($dataInicio): void
    {
        $this->dataInicio = $dataInicio;
    }

    public function getDataTermino()
    {
        return $this->dataTermino;
    }

    public function setDataTermino($dataTermino): void
    {
        $this->dataTermino = $dataTermino;
    }

}