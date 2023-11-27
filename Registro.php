<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>





      

<?php
// Estabelece a conexão com o banco de dados MySQL
$con = new PDO("mysql:host=localhost;dbname=pit", "root", "");

// Classe Pessoa
class Pessoa
{
    private $nome;
    private $sobrenome;
    private $senha;
    private $confirmarSenha;
    private $email;
    private $info;
    private $tel;
    private $cpf;
    private $tipo;

    // Método para definir o valor de uma propriedade
    public function set($propriedade, $valor)
    {
        $this->$propriedade = $valor;
    }

    // Método para obter o valor de uma propriedade
    public function getPropriedades($propriedade)
    {
        return $this->$propriedade;
    }
}

// Instanciação da classe Pessoa
$obj = new Pessoa();

// Verifica se o formulário foi enviado via método POST
if (isset($_POST['enviar'])) {
    $obj->set("nome", $_POST['Nome']);
    $obj->set("sobrenome", $_POST['lastname']);
    $obj->set("senha", $_POST['Senha']);
    $obj->set("confirmarSenha", $_POST['Senha2']);
    $obj->set("email", $_POST['Email']);
    $obj->set("info", $_POST['Info']);
    $obj->set("tel", $_POST['Tel']);
    $obj->set("cpf", $_POST['CPF']);
    $obj->set("tipo", $_POST['Tipo']);
    $obj->set("renda", $_POST['Renda']);

    // Verifica se a senha e a confirmação de senha coincidem
    if ($obj->getPropriedades("senha") !== $obj->getPropriedades("confirmarSenha")) {
    
        echo "<script type='text/javascript'>alert('As senhas não coincidem. Por favor, tente novamente. ');";
                echo " javascript:window.location='cadastro.html'</script>";
    }

    // Prepara uma declaração SQL para selecionar emails semelhantes ao email fornecido no banco de dados
    $stmt = $con->prepare("SELECT email FROM conta WHERE email LIKE :email");
    $stmt->bindValue(':email', $obj->getPropriedades("email") . '%');
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        foreach ($result as $row) {
            // Verifica se um email idêntico já está cadastrado no banco de dados
            if ($row['email'] === $obj->getPropriedades("email")) {
                echo "<script type='text/javascript'>alert('Email semelhante já cadastrado: ');";
                echo " javascript:window.location='cadastro.html'</script>";
                
            }
        }
    }
    

    // Insere os dados no banco de dados
    $stmt = $con->prepare("INSERT INTO conta(nome, sobrenome, senha, email, Informacao, tel, cpf, tipo , renda) VALUES (?, ?, ?, ?, ?, ?, ?, ? , ?)");
    $stmt->execute([$obj->getPropriedades("nome"), $obj->getPropriedades("sobrenome"), $obj->getPropriedades("senha"), $obj->getPropriedades("email"), $obj->getPropriedades("info"), $obj->getPropriedades("tel"), $obj->getPropriedades("cpf"), $obj->getPropriedades("tipo"),$obj->getPropriedades("renda")]);
    echo "<script type='text/javascript'>alert(' Cadastro realizado com sucesso ');";
    echo " javascript:window.location='login.html'</script>";

    
}
?>




<html>
<body>
  <form method="POST" action="">
    <label for="Nome">Nome:</label>
    <input type="text" name="Nome" id="Nome" required> <br> <br>
    
    <label for="lastname">Sobrenome:</label>
    <input type="text" name="lastname" id="lastname" required>  <br> <br>
    
    <label for="Senha">Senha:</label>
    <input type="password" name="Senha" id="Senha" required>  <br> <br>
    
    <label for="Senha2">Confirmar Senha:</label>
    <input type="password" name="Senha2" id="Senha2" required>  <br> <br>
    
    <label for="Email">Email:</label>
    <input type="email" name="Email" id="Email" required>  <br> <br>
    
    <label for="Info">Informação:</label>
    <textarea  type="text" name="Info" id="Info"> </textarea>   <br> <br>
    
    <label for="Tel">Telefone:</label>
    <input type="tel" name="Tel" id="Tel">  <br> <br>
    
    <label for="CPF">CPF:</label>
    <input type="text" name="CPF" id="CPF" required>  <br> <br>

    <label for="Tipo">Tipo:</label><br>
    <input type="hid" name="Tipo" value="opcao1" required> Opção 1<br>
    <input type="radio" name="Tipo" value="opcao2" required> Opção 2<br>
    
    <input type="submit" name="enviar" value="Enviar">
    
  </form>
</body>
</html>

