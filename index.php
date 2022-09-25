
<?php 

require_once 'pessoa.php';
$p = new Pessoa("loja", "localhost","root", "");

?>




<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro Pessoa</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <?php
    
    if(isset($_POST['nome']))
    {
        if(isset($_GET['id_up']))
        {
            //BUSCA O ID E BUSCA OS DADOS NESTE ID
            $id_update = addslashes($_GET['id_up']);
            $res = $p->buscarDadosPessoa($id_update);
            //RECEBE OS DADOS DO FORM E ATUALIZA
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if(!empty($nome) && !empty($telefone) && !empty($email))
            {
                //CADASTRAR PESSOAS
                $p->atualizarDados($id_update,$nome,$telefone,$email);
                header("location: index.php");
                    
            }
            else
            {
                ?>
                    <div class="aviso">
                        <h4>Preencha todos os campos!</h4>
                    </div>
                <?php
               
            }
        }
        else
        {
            //RECEBER DADOS DO FORM HTML
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            if(!empty($nome) && !empty($telefone) && !empty($email))
            {
                //CADASTRAR PESSOAS
                if(!$p->cadastrarPessoa($nome,$telefone,$email))
                {
                ?>
                    <div class="aviso">
                        <img src="exclamação1.png" class="image">
                        <h4>Email já cadastrado!</h4>
                    </div>
                <?php
                }
                
            }
            else
            {
                ?>
                    <div class="aviso">
                        <img src="exclamação1.png" class="image">
                        <h4>Preencha todos os campos!</h4>
                    </div>
                <?php
            }
        }
    }   

    
    ?>

    <?php 
    
    if(isset($_GET['id_up']))
    {
        $id_update = addslashes($_GET['id_up']);
        $res = $p->buscarDadosPessoa($id_update);
    }

    
    ?>



    <section id="esquerda">
        <form method="POST">
            <h2>CADASTRAR PESSOA</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" 
            value="<?php  if(isset($res)){echo $res['nome'];}?>">

            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" 
            value="<?php  if(isset($res)){echo $res['telefone'];}?>">

            <label for="email">Email</label>
            <input type="text" name="email" id="email"
            value="<?php  if(isset($res)){echo $res['email'];}?>">

            <input type="submit" value="<?php if(isset($res)){ echo "Atualizar";}
            else{echo "Cadastrar";}?>">
            
        </form>
    </section>
    <section id="direita">
        <table>
                <tr id="titulo">
                    <td>NOME</td>
                    <td>TELEFONE</td>
                    <td colspan="2">EMAIL</td>
                </tr>
        <?php
        
        $dados = $p->BuscarDados();
        if(count($dados) > 0)
        {
            for($i=0; $i < count($dados); $i++)
            {
                echo "<tr>";
                foreach($dados[$i] as $key => $value)
                {
                    if($key != "id")
                    {
                        echo "<td>".$value."</td>";
                    }
                }
        ?>
            <td><a href="index.php?id_up=<?php echo $dados[$i]['id'];?>" id="editar">Editar</a>
            <a href="index.php?id=<?php echo $dados[$i]['id'];?>" id="excluir">Excluir</a></td>
        <?php
                echo "</tr>";
            }

        }
        else
        {
            
        ?>

        </table>
        
                <div class="aviso">
                    <h4>Ainda não há cadastros!</h4>
                </div>
            <?php
        }
            ?>
    </section>


</body>



</html>

<?php

    if(isset($_GET['id']))
    {
        $id_pessoa = addslashes($_GET['id']);
        $p->excluirPessoa($id_pessoa);
        header("location: index.php");
    }


?>