<?php
require("../../model/model.php");
class Crud extends Model{
    //VARIAVEIS PARA SEREM UTILIZADAS PELAS CLASSES FILHAS (só as classes que extenderem da model usarão estas variáveis)
    protected $tabela;
    protected $condicao;
    protected $tabelaPai;
    protected $tabelaFilha;
    protected $colunas;
    protected $valores;
    protected $atributos;
    /**
     * @return mixed
     */
    public function getTabela()
    {
        return $this->tabela;
    }

    /**
     * @param mixed $tabela
     */
    public function setTabela($tabela)
    {
        $this->tabela = $tabela;
    }

    /**
     * @return mixed
     */
    public function getCondicao()
    {
        return $this->condicao;
    }

    /**
     * @param mixed $condicao
     */
    public function setCondicao($condicao)
    {
        $this->condicao = $condicao;
    }

    /**
     * @return mixed
     */
    public function getTabelaPai()
    {
        return $this->tabelaPai;
    }

    /**
     * @param mixed $tabelaPai
     */
    public function setTabelaPai($tabelaPai)
    {
        $this->tabelaPai = $tabelaPai;
    }

    /**
     * @return mixed
     */
    public function getTabelaFilha()
    {
        return $this->tabelaFilha;
    }

    /**
     * @param mixed $tabelaFilha
     */
    public function setTabelaFilha($tabelaFilha)
    {
        $this->tabelaFilha = $tabelaFilha;
    }

    /**
     * @return mixed
     */
    public function getColunas()
    {
        return $this->colunas;
    }

    /**
     * @param mixed $colunas
     */
    public function setColunas($colunas)
    {
        $this->colunas = $colunas;
    }

    /**
     * @return mixed
     */
    public function getValores()
    {
        return $this->valores;
    }

    /**
     * @param mixed $valores
     */
    public function setValores($valores)
    {
        $this->valores = $valores;
    }

    /**
     * @return mixed
     */
    public function getAtributos()
    {
        return $this->atributos;
    }

    /**
     * @param mixed $atributos
     */
    public function setAtributos($atributos)
    {
        $this->atributos = $atributos;
    }

    //GETS E SETS


    //FUNÇÕES
    public function find($tabela, $condicao)
    {
        return parent::find($tabela, $condicao);
    }
    public function findAll($tabela)
    {
        return parent::findAll($this->tabela);
    }
    public function findLeftJoinEstatico($tabelaPai, $tabelaFilha, $condicao)
    {
        return parent::findLeftJoinEstatico($tabelaPai, $tabelaFilha, $condicao);
    }
    public function findAllLeftJoinEstatico($tabelaPai, $tabelaFilha)
    {
        return parent::findAllLeftJoinEstatico($tabelaPai, $tabelaFilha);
    }
    public function findLeftJoinGenerico($tabela, $condicao)
    {
        return parent::findLeftJoinGenerico($this->tabela, $condicao);
    }
    public function findAllLeftJoinGenerico($tabela)
    {
        return parent::findAllLeftJoinGenerico($this->tabela);
    }
    public function create($tabela, $colunas, $valores)
    {
        parent::create($tabela, $colunas, $valores);
    }
    public function update($tabela, $atributos, $condicao)
    {
        parent::update($tabela, $atributos, $condicao);
    }
}
?>