<?php

include_once "./db/conn1.php";

$sql = $pdo->prepare("SELECT * FROM produtos ORDER BY id DESC");
$sql->execute();
$produtos = $sql->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
</head>
<body>
    <?php foreach($produtos as $key=>$value){ ?>
        <img src="./images/uploads/<?= $value['imagem'] ?>" alt="">
        <h1><?= $value['nome'] ?></h1>
        <p><?= $value['descricao'] ?></p>
    <?php } ?>
</body>
</html>