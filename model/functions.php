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

//Este caminho deve ser trocado para o link do servidor de hospedagem. C:/xampp/htdocs/projTarefas 
abstract class Conexao{
	protected $conn;
	//FUNÇÃO RESPONSÁVEL POR CONECTAR COM O BD
	protected function conectar(){
		include_once('../../conexao/config.php');
		try {
		    $this->conn = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
		    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    //Retorna a conexão estabelecida
		    return $this->conn;
		}
		catch(PDOException $e){
		    return $this->conn . "<br>" . $e->getMessage();//Retorna o erro de conexão se houver
		}
	}
	
    protected function closeConexao(){
        if($this->conn != null){        	
        	$this->conn = null;
        }
    }	
		
}

class Functions extends Conexao{

    function __construct(){
        $this->conn = $this->conectar();
    }

	//A FUNÇÃO A SEGUIR É RESPONSÁVEL POR EXTRAIR OS DADOS DO ARRAY E CONVERTÊ-LOS EM STRING
	function desmembrarArray($array){
		try {
			if(gettype($array) == "array"){
				$string = implode(', ', $array); //o implode transforma o array em string
				return $string;
			}else{
				$string = $array;
				return $string;
			}			
		} catch (Exception $e) {
			return $e;
		}		
	}
	//BUSCA A CHAVE PRIMÁRIA DA TABELA PASSADA POR PARÂMETRO
	function findPrimaryKey($tabela){
		try {
		    $stmt = $this->conn->prepare("SELECT information_schema.KEY_COLUMN_USAGE.COLUMN_NAME 
		    as COLUMN_NAME
			FROM information_schema.KEY_COLUMN_USAGE
			WHERE information_schema.KEY_COLUMN_USAGE.CONSTRAINT_NAME LIKE '%primary%' AND
			information_schema.KEY_COLUMN_USAGE.TABLE_SCHEMA LIKE '".DB_NAME."' AND
			information_schema.KEY_COLUMN_USAGE.TABLE_NAME LIKE '$tabela';"); 
		    $stmt->execute();
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
		    $values = $stmt->fetch();
			foreach ($values as $key => $value) {
				return $value;
			}
		}
		catch(PDOException $e) {
		    echo "Erro: " . $e->getMessage();
		}
		$this->conn = null;
	}
	//FUNÇÃO RESPONSÁVEL POR ACHAR AS TABELAS QUE REFERENCIAM A TABELA PASSADA POR PARAMETRO
	function encontrarRelacao($tabela){
		try {
		    $stmt = $this->conn->prepare("SELECT REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME, COLUMN_NAME
		    FROM information_schema.KEY_COLUMN_USAGE 
		    WHERE TABLE_SCHEMA = '".DB_NAME."'
		    AND TABLE_NAME = '$tabela' 
		    AND REFERENCED_TABLE_NAME IS NOT NULL;");
		    $stmt->execute();
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
		    $item = $stmt->fetchAll();
		    return $item;
		}	
		catch(PDOException $e) {
		    echo "Erro: " . $e->getMessage();
		}
		$this->conn = null;
	}
    //FUNÇÃO RESPONSÁVEL POR ACHAR AS TABELAS QUE REFERENCIAM A TABELA PASSADA POR PARAMETRO
    function listarColunas($tabela){
        try {
            $stmt = $this->conn->prepare("SHOW COLUMNS FROM $tabela;");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $item = $stmt->fetchAll();
            foreach($item as $valor){
                return $valor["Field"];
            }
        }
        catch(PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
        $this->conn = null;
    }
    //FUNÇÃO RESPONSAVEL POR GERAR UMA QUERY JUNTANDO AS TABELAS RELACIONADAS DENTRO DA TABELA ATUAL NO BD
	function gerarLeftJoins($tabela){
	$parametros = $this->encontrarRelacao($tabela);
	$resultados = $parametros;
	if ($resultados != NULL) {
		//Atribuindo valores iniciais às variáveis
			//Foreach para criar os left joins necessários
			foreach($resultados as $parametro) {
			//Atribuindo os valores encontrados ao procurar a estrutura da tabela	
			$TableName = $parametro["REFERENCED_TABLE_NAME"];
			$ColumnName = $parametro["COLUMN_NAME"];
			$ReferenceColumn = $parametro["REFERENCED_COLUMN_NAME"];
			//Criando a query de left join
			$leftjoins = " LEFT JOIN $TableName 
			on $tabela.$ColumnName = $TableName.$ReferenceColumn";
			//Retorna a string com todos os left joins 
			return $leftjoins;	
		}			
	}
	else {
		return "Nada Encontrado!";
	}
}		
	//BUSCA A CHAVE PRIMÁRIA DA TABELA PASSADA POR PARÂMETRO
	function findMaxPrimaryKeyG($tabela){
		try {
		    $stmt = $this->conn->prepare("SELECT MAX(id$tabela) from $tabela;"); 
		    $stmt->execute();
		    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
		    $values = $stmt->fetch();
		    var_dump($values);
		}
		catch(PDOException $e) {
		    echo "Erro: " . $e->getMessage();
		}
		$this->conn = null;
	}
	

}