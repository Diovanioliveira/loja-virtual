

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inserir Produto</title>
</head>
<body>

  <form action="process.php" method="post">
    <label for="productName">Nome do Produto:</label>
    <input type="text" id="productName" name="productName" required>

    <label>Tamanhos Disponíveis:</label>
    <label for="sizeSmall">Pequeno</label>
    <input type="checkbox" id="sizeSmall" name="sizes[]" value="Pequeno">

    <label for="sizeMedium">Médio</label>
    <input type="checkbox" id="sizeMedium" name="sizes[]" value="Médio">

    <label for="sizeLarge">Grande</label>
    <input type="checkbox" id="sizeLarge" name="sizes[]" value="Grande">

    <!-- Adicione mais checkboxes conforme necessário -->

    <button type="submit">Salvar Produto</button>
  </form>

</body>
</html>
