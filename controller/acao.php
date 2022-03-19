<?php

class Acao extends Crud{
    private $idAcao;
    private $nomeAcao;

    public function setDados(){
      parent::setTabela('acao');
      parent::setCondicao($this->findPrimaryKey($this->getTabela())."=2");
      parent::setTabelaPai('?');
      parent::setTabelaFilha('?');
      parent::setColunas($this->listarColunas($this->getTabela()));
      parent::setValores('?');
      parent::setAtributos($this->findPrimaryKey($this->getTabela()));
    }
    public function getIdAcao()
    {
        return $this->idAcao;
    }

    public function setIdAcao($idAcao): void
    {
        $this->idAcao = $idAcao;
    }

    public function getNomeAcao()
    {
        return $this->nomeAcao;
    }

    public function setNomeAcao($nomeAcao): void
    {
        $this->nomeAcao = $nomeAcao;
    }


}
