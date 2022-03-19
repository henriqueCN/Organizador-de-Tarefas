<?php
include_once('includes.php');
class Especialidade extends Crud{
	//DADOS DA CLASSE
    private $idEspecialidade;
    private $nomeEspecialidade;
    private $descricaoEspecialidade;

    public function getIdEspecialidade()
    {
        return $this->idEspecialidade;
    }

    public function setIdEspecialidade($idEspecialidade): void
    {
        $this->idEspecialidade = $idEspecialidade;
    }

    public function getNomeEspecialidade()
    {
        return $this->nomeEspecialidade;
    }

    public function setNomeEspecialidade($nomeEspecialidade): void
    {
        $this->nomeEspecialidade = $nomeEspecialidade;
    }

    public function getDescricaoEspecialidade()
    {
        return $this->descricaoEspecialidade;
    }

    public function setDescricaoEspecialidade($descricaoEspecialidade): void
    {
        $this->descricaoEspecialidade = $descricaoEspecialidade;
    }
}
?>

