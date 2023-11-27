<?php
// Estabelece a conexão com o banco de dados MySQL
$con = new PDO("mysql:host=localhost;dbname=pit", "root", "");

// Classe Pessoa
class Pessoa
{
    private $nome;
    private $senha;

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
    $login = $_POST['Nome'];
    $senha = $_POST['Senha'];

    // Prepara uma declaração SQL para selecionar uma linha da tabela "conta"
    // onde o nome é igual ao valor fornecido no login ou o email é igual ao valor fornecido no login
    $stmt = $con->prepare("SELECT * FROM conta WHERE nome = :login OR email = :login");

    // Vincula o valor do login à declaração preparada
    $stmt->bindParam(':login', $login);

    // Executa a declaração
    $stmt->execute();

    // Recupera o resultado como um array associativo
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o resultado é verdadeiro (uma linha foi encontrada no banco de dados)
    if ($result) {
        // Verifica se a senha fornecida coincide com a senha armazenada no banco de dados
        if ($senha == $result['Senha']) {
            // Iniciar a sessão
            session_start();

            // Armazenar as informações do usuário na sessão
            $_SESSION['nome'] = $result['Nome'];
            $_SESSION['sobrenome'] = $result['Sobrenome'];
            $_SESSION['email'] = $result['Email'];
            $_SESSION['info'] = $result['Informacao'];
            $_SESSION['tel'] = $result['tel'];
            $_SESSION['cpf'] = $result['cpf'];
            $_SESSION['tipo'] = $result['Tipo'];
            $_SESSION['user_id'] = $result['id'];

            // Redirecionar para a página inicial
            if ($result['tipo'] == 'Apoiador') {
                header("Location:pagina_inicial_A.php");
            } elseif ($result['tipo'] == 'Criador') {
                header("Location:pagina_inicial.php");
            } else {
                // Se o tipo não for "investidor" nem "criador", faça um redirecionamento padrão
                header("Location:pagina_inicial.php");
            }
            exit(); // Encerra o script
        } else {
            echo "<script type='text/javascript'>alert('Senha incorreta para o usuário ');";
            echo " javascript:window.location='login.html'</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Nome de usuário ou email não encontrado.');";
        echo " javascript:window.location='login.html'</script>";
    }
    
}

?>
