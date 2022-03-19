<?php

include_once('crud.php');
class Usuario extends Crud{

    private $idUsuario;
    private $nomeUsuario;
    private $emailUsuario;
    private $senhaUsuario;


    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function getNomeUsuario()
    {
        return $this->nomeUsuario;
    }

    public function setNomeUsuario($nomeUsuario): void
    {
        $this->nomeUsuario = $nomeUsuario;
    }

    public function getEmailUsuario()
    {
        return $this->emailUsuario;
    }

    public function setEmailUsuario($emailUsuario): void
    {
        $this->emailUsuario = $emailUsuario;
    }

    public function getSenhaUsuario()
    {
        return $this->senhaUsuario;
    }

    public function setSenhaUsuario($senhaUsuario): void
    {
        $this->senhaUsuario = $senhaUsuario;
    }
    //Função responsável por fazer o login usando as funções do crud
    public function logar($email, $senha){
        try {
            $this->tabela = 'usuario';
            $this->condicao = "emailUsuario = '$email' and senhaUsuario = '$senha';";
            $resultado = parent::find($this->tabela,$this->condicao);
            if ($resultado != null) {
                return true;
            }else{
                return false;
            }
                     
        } catch (Exception $e) {
            echo $e;
        }


    }
    public function verificaExistencia($email){
        try {
            $this->tabela = 'usuario';
            $this->condicao = "emailUsuario = '$email';";
            $resultado = parent::find($this->tabela,$this->condicao);
            if ($resultado != null) {
                return false;
            }else{
                return true;
            }
                     
        } catch (Exception $e) {
            return "Conta já cadastrada";
        }


    }    
}