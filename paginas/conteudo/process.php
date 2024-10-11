<?php
// Inclui o arquivo de conexão com o banco de dados
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtendo dados do formulário
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $date = htmlspecialchars($_POST['date']);
    $description = htmlspecialchars($_POST['description']);

    // Prepara a instrução SQL
    $stmt = $conn->prepare("INSERT INTO donations (name, address, donation_date, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $address, $date, $description);

    // Executa a instrução SQL
    if ($stmt->execute()) {
        echo "Doação agendada com sucesso!";
    } else {
        echo "Erro ao salvar a doação: " . $stmt->error;
    }

    // Fecha a instrução e a conexão
    $stmt->close();
    $conn->close();
} else {
    echo "Método de requisição não permitido.";
}
?>
