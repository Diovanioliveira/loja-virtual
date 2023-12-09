<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obter os dados do formulário
    $productName = $_POST["productName"];
    $sizes = isset($_POST["sizes"]) ? $_POST["sizes"] : [];

    // Aqui você pode salvar os dados em um banco de dados ou fazer o que for necessário
    // Por enquanto, apenas exibiremos no console para fins de demonstração
    echo "Nome do Produto: " . $productName . "<br>";
    echo "Tamanhos Disponíveis: " . implode(', ', $sizes);
} else {
    // Redirecionar se alguém tentar acessar este arquivo diretamente sem enviar dados via formulário
    header("Location: index.html");
    exit();
}
?>