<?php

/*
ATENÇÃO:
As "Partes" escritas no 
projeto são para organizar
a documentação do mesmo, 
para conseguir a documentação
entre em contato comigo.
Email:
henriquecostadonascimento@gmail.com 
*/

//INCLUINDO O ARQUIVO CONEXÃO PARA PODER HERDAR DA CLASSE
include_once('functions.php');
//CRIANDO A CLASSE MODEL HERDANDO DA CLASSE CONEXÃO 
class Model extends Functions{
	private $functions;
	
    function __construct(){
        $this->conn = $this->conectar();
    }
	//FUNÇÃO RESPONSÁVEL POR TRAZER UM DADO ESPECÍFICO DE ACORDO COM OS PARÂMETRDOS
    function find($tabela/*Ex.:usuario*/, $condicao/*Ex.:id = 1*/){
		//TRATAMENTO DOS DADOS DOS PARÂMETROS
		try {
		    $stmt = $this->conn->prepare("SELECT * FROM $tabela WHERE $condicao");
		    $stmt->execute();
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
		    $valores = $stmt->fetch();
		    return $valores;
		}
		catch(PDOException $e) {
		    echo "Erro: " . $e->getMessage();
		}
		$this->closeConexao();
	}

	function findAutoIncrement($tabela/*Ex.:usuario*/, $chavePrimaria/*Ex.:id = 1*/){
		//TRATAMENTO DOS DADOS DOS PARÂMETROS
		try { 
		    $stmt = $this->conn->prepare("SELECT coalesce( max($chavePrimaria), 0) + 1 as contaId FROM $tabela");
		    $stmt->execute();
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
		    $valores = $stmt->fetch();
		    return $valores;
		}
		catch(PDOException $e) {
		    echo "Erro: " . $e->getMessage();
		}
		$this->closeConexao();
	}

	//Contará a quantidade de resultados retornados
	function contaResultados($tabela/*Ex.:usuario*/, $condicao/*Ex.:id = 1*/){
		//TRATAMENTO DOS DADOS DOS PARÂMETROS
		try {
		    $stmt = $this->conn->prepare("SELECT * FROM $tabela WHERE $condicao");
		    $stmt->execute();
		    $n = 0;
			$retorno['qtd'] = $stmt->rowCount();
			return $retorno['qtd'];
		}	
		catch(PDOException $e) {
		    echo "Erro: " . $e->getMessage();
		}
		$this->closeConexao();
	}


	//FUNÇÃO RESPONSÁVEL POR TRAZER TODOS OS DADOS DE UMA TABELA
	function findAll($tabela/*Ex.: usuario*/){
		try {
		    $stmt = $this->conn->prepare("SELECT * FROM $tabela"); 
		    $stmt->execute();
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
		    $valores = $stmt->fetchAll();
		    return $valores;
		}
		catch(PDOException $e) {
		    echo "Erro: " . $e->getMessage();
		}
		$this->closeConexao();
	}
	//FUNÇÃO RESPONSÁVEL POR TRAZER UM DADO ESPECÍFICO DE ACORDO COM OS PARÂMETROS
	function findLeftJoinEstatico($tabelaPai/*Ex.:usuario*/, $tabelaFilha/*Ex.:funcao*/, $condicao/*Ex.:nome like 'jo_o'*/ ){
		//ENCONTRANDO A CHAVE PRIMÁRIA DA TABELA PAI
		$chaveRelacional = parent::findPrimaryKey($tabelaPai);
		//FINALMENTE O SELECT DOS DADOS EXTRAÍDOS DO ARRAY	
		try {
		    $stmt = $this->conn->prepare("SELECT * 
		    FROM $tabelaPai LEFT JOIN $tabelaFilha 
		    on $tabelaPai.$chaveRelacional = $tabelaFilha.$chaveRelacional 
		    WHERE $condicao");//FIM DA QUERY
		    $stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    		foreach($stmt->fetchAll() as $k=>$v) { 
        		var_dump($v) ;
			}
		}
		catch(PDOException $e) {
		    echo "Erro: " . $e->getMessage();
		}

		$this->closeConexao();
	}			
	//FUNÇÃO RESPONSÁVEL POR TRAZER TODOS OS DADOS DE ACORDO COM OS PARÂMETRDOS COM LEFT JOIN
	function findAllLeftJoinEstatico($tabelaPai/*Ex.:usuario*/, $tabelaFilha/*Ex.:funcao*/){
		//ENCONTRANDO A CHAVE PRIMÁRIA DA TABELA PAI
		$functions = new Functions();
		$chaveRelacional = $functions->findPrimaryKey($tabelaPai);
		//FINALMENTE O SELECT DOS DADOS EXTRAÍDOS DO ARRAY	
		try {
		    $stmt = $this->conn->prepare("SELECT * 
		    FROM $tabelaPai LEFT JOIN $tabelaFilha on especialidade.$chaveRelacional
		    = listaespecialidade.$chaveRelacional");
		    $stmt->execute();
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
		    return var_dump($stmt->fetchAll());
		}
		catch(PDOException $e) {
		    echo "Erro: " . $e->getMessage();
		}
		$this->closeConexao();
	}
	//FUNÇÃO DE SELECT COM LEFT JOIN ONDE BUSCA OS DADOS DAS TABELAS RELACIONADAS COM A ATUAL DE ACORDO COM A CONDIÇÃO
	function findLeftJoinGenerico($tabela /*Ex.:usuario*/, $condicao /*Ex.:idTarefa = 1*/){			
		try {			
		    $stmt = $this->conn->prepare("SELECT * 
		    FROM $tabela".parent::gerarLeftJoins($tabela).
		    " WHERE $condicao;");//Tem que ter espaço antes do WHERE
		    $stmt->execute();
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
		    $valores = $stmt->fetchAll();
		    return $valores;
		}
		catch(PDOException $e) {
		    echo "Erro: " . $e->getMessage();
		}
		$this->closeConexao();
	}
	//FUNÇÃO DE SELECT COM LEFT JOIN ONDE BUSCA TODOS OS DADOS DAS TABELAS RELACIONADAS COM A TABELA ATUAL
	function findAllLeftJoinGenerico($tabela/*Ex.: usuario*/){
		try {			
		    $stmt = $this->conn->prepare("SELECT * 
		    FROM $tabela".parent::gerarLeftJoins($tabela));
		    $stmt->execute();
		    $valores = $stmt->fetchAll();
		    return $valores;
		}
		catch(PDOException $e) {
		    echo "Erro: " . $e->getMessage();
		}
		$this->closeConexao();
	}		
	//FUNÇÃO RESPONSÁVEL POR INSERIR VALORES DE ACORDO COM VALOERS NOS PARAMETROS
	function create($tabela/*Ex.: usuario*/,$colunas/*Ex.: nomeUsuario, idadeUsuario*/,$valores/*Ex.: João, 18*/){
		//TRATAMENTO DOS DADOS DOS PARÂMETROS
		$col = parent::desmembrarArray($colunas);
		$val = parent::desmembrarArray($valores);
		//FINALMENTE O INSERT DOS DADOS EXTRAÍDOS DO ARRAY			
		try {
			    $sql = "INSERT INTO $tabela ($col) VALUES ($val)"; //insere valores transformados em string nesta mesma função
			    $this->conn->exec($sql); //executa a query na conexão
			    echo "Novo dado inserido!";
		}
		catch(PDOException $e)
		    {
		    echo $sql . "<br>" . $e->getMessage();
		}
		$this->closeConexao();
	}
	//FUNÇÃO RESPONSÁVEL POR ATUALIZAR VALORES NO BD DE ACORDO COM VALOERS NOS PARAMETROS
	function update($tabela/*Ex.: usuario*/, $atributos/*Ex.:joão*/,$condicao/*Ex.: id = 2*/){
		//Transforma os arrays em strings para para que possam ser executadas na query
		$atr = parent::desmembrarArray($atributos);
		$cond = parent::desmembrarArray($condicao);
		echo $tabela;
		//FINALMENTE O UPDATE DOS DADOS EXTRAÍDOS DO ARRAY	
		try {
		    $sql = "UPDATE $tabela SET $atr WHERE $cond";
		    $this->conn->prepare($sql); //executa a query na conexão
		    $this->conn->exec($sql);
		    echo "Dados atualizados!";
		    }
		catch(PDOException $e)
		    {
		    echo $sql . "<br>" . $e->getMessage();
		    }
		$this->closeConexao();
	}
	//FUNÇÃO RESPONSÁVEL POR DELETAR VALORES NO BD DE ACORDO COM VALOERS NOS PARAMETROS	
	function delete($tabela/*Ex.: usuario*/,$condicao/*Ex.: id = 2*/){
	if ($condicao != null) {
		try {
		    $sql = "DELETE FROM $tabela WHERE $condicao";
		    $this->conn->prepare($sql); //executa a query na conexão
		    $this->conn->exec($sql);
		    echo "Dado deletado!";
		}
		catch(PDOException $e){
		    	echo $sql . "<br>" . $e->getMessage();
		}
	}
	else{
		echo "A condição é obrigatória!";
	}	
	$this->closeConexao();
		
	}

}


