<?php 

Class Pessoa{
    //CONXÃO COM BD

    private $pdo;
  

    public function __construct($dbname, $localhost, 
    $user, $password)
    {
        try{


            $this->pdo = new PDO("mysql:host=$localhost;dbname=$dbname",$user,$password);



        } catch (PDOException $e) 
        {
            echo "Erro no banco de dados ".
            $e->getMessage();
            exit;
        }
        catch(Exception $e)
        {
            echo "Erro genérico ".
            $e->getMessage();
            exit;
        }



        
    }

    // MÉTODO PARA BUSCAR DADOS DO BD
    public function BuscarDados(){
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    //FUNÇÃO PARA CADASTRAR PESSOAS NO BD

    public function cadastrarPessoa($nome, $telefone, $email){

        //verificação se o email já está cadastrado

        $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();

        if($cmd->rowCount() > 0)//email já cadastrado
        {
            return false;
        }
        else //email não encontrado
        {
            $cmd = $this->pdo->prepare("INSERT INTO pessoa(nome, telefone, email) VALUES 
            (:n, :t, :e)");
            $cmd->bindValue(":n",$nome);
            $cmd->bindValue(":t",$telefone);
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            return true;
        }

    }

    public function excluirPessoa($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id= :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    public function buscarDadosPessoa($id)
    {
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id=:id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;

    }

    public function atualizarDados($id,$nome,$telefone,$email)
    {
        $cmd = $this->pdo->prepare("UPDATE pessoa 
        SET nome= :n, telefone= :t, email= :e WHERE id=:id");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":e", $email);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        

    }
}





?>