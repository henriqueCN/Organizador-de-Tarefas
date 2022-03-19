<?php
include_once('includes.php');

class Equipe extends Crud{

	private $idEquipe;
	private $nomeEquipe;
	private $idUsuario;
	private $idUsuarioIntegrante;

	public function getIdEquipe()
    {
        return $this->idEspecialidade;
    }

    public function setIdEquipe($idEquipe): void
    {
        $this->idEquipe = $idEquipe;
    }

    public function getNomeEquipe()
    {
    	return $this->nomeEquipe;
    }

    public function setNomeEquipe($nomeEquipe): void
    {
    	$this->nomeEquipe = $nomeEquipe;
    }

    public function getIdUsuario()
    {
    	return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario): void
    {
    	$this->idUsuario = $idUsuario;
    }

    public function getIdUsuarioIntegrante()
    {
    	return $this->idUsuarioIntegrante;
    }

    public function setIdUsuarioIntegrante($idUsuarioIntegrante): void
    {
    	$this->idUsuarioIntegrante = $idUsuarioIntegrante;
    }
} 
?>