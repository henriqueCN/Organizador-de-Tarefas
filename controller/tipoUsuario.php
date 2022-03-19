<?php

class TipoUsuario extends Crud{

    private $idTipoUsuario;
    private $nomeTipoUsuario;


    public function getIdTipoUsuario()
    {
        return $this->idTipoUsuario;
    }

    public function setIdTipoUsuario($idTipoUsuario): void
    {
        $this->idTipoUsuario = $idTipoUsuario;
    }

    public function getNomeTipoUsuario()
    {
        return $this->nomeTipoUsuario;
    }

    public function setNomeTipoUsuario($nomeTipoUsuario): void
    {
        $this->nomeTipoUsuario = $nomeTipoUsuario;
    }


}