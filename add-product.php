<?php 

    session_start();

    include_once "./db/conn1.php";
    include_once "./db/conn2.php";

    $sql1 = $pdo->prepare("SELECT * FROM categorias ORDER BY id DESC");
    $sql1->execute();
    $categorias = $sql1->fetchAll();

    // Receber os dados do formulário
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    // Acessa o IF quando o usuário clicar no botão
    if (!empty($dados['SendCadUser'])) {

        // QUERY cadastrar usuário no banco de dados
        $query_usuario = "INSERT INTO produtos (nome, categoria, descricao, valor, peso, largura, altura, comprimento, imagem, tamanhos, numeros) VALUES (:nome, :categoria, :descricao, :valor, :peso, :largura, :altura, :comprimento, :imagem, :tamanhos, :numeros)";

        // Preparar a QUERY
        $cad_usuario = $conn->prepare($query_usuario);

        $extensao2 = strtolower(substr($_FILES['imagem']['name'], -4));

        $novo_nome2 = md5(time()). $extensao2;

        $diretorio = "./images/uploads/";

        move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$novo_nome2);
        $tamanhos = isset($_POST["sizes"]) ? implode(', ', $_POST["sizes"]) : '';
        $numeros = isset($_POST["numbers"]) ? implode(', ', $_POST["numbers"]) : '';

        // Substituir os links pelos valores do formulário

        $cad_usuario->bindParam(':nome', $dados['nome']);
        $cad_usuario->bindParam(':categoria', $dados['categoria']);
        $cad_usuario->bindParam(':descricao', $dados['descricao']);
        $cad_usuario->bindParam(':valor', $dados['valor']);
        $cad_usuario->bindParam(':peso', $dados['peso']);
        $cad_usuario->bindParam(':largura', $dados['largura']);
        $cad_usuario->bindParam(':altura', $dados['altura']);
        $cad_usuario->bindParam(':comprimento', $dados['comprimento']);
        $cad_usuario->bindParam(':imagem', $novo_nome2);
        $cad_usuario->bindParam(':tamanhos', $tamanhos);
        $cad_usuario->bindParam(':numeros', $numeros);

        // Executar a QUERY
        $cad_usuario->execute();

        // Acessa o IF quando cadastrar o usuário no BD
        if ($cad_usuario->rowCount()) {

            // Receber o id do registro cadastrado
            $id_produto = $conn->lastInsertId();

            // Endereço do diretório
            $diretorio = "./images/$id_produto/";

            // Criar o diretório
            mkdir($diretorio, 0755);

            // Receber os arquivos do formulário
            $arquivo = $_FILES['imagens'];
            //var_dump($arquivo);

            // Ler o array de arquivos
            for ($cont = 0; $cont < count($arquivo['name']); $cont++) {

                // Receber nome da imagem
                $path = $arquivo['name'][$cont];

                // Criar o endereço de destino das imagens
                $destino = $diretorio . $arquivo['name'][$cont];
                // Acessa o IF quando realizar o upload corretamente
                if (move_uploaded_file($arquivo['tmp_name'][$cont], $destino)) {
                    $query_imagem = "INSERT INTO imagens (path, id_produto) VALUES (:path, :id_produto)";
                    $cad_imagem = $conn->prepare($query_imagem);
                    $cad_imagem->bindParam(':path', $path);
                    $cad_imagem->bindParam(':id_produto', $id_produto);
                    $cad_imagem->execute();

                    $_SESSION['msg'] = '<div class="alert-g"><i class="bx bx-check"></i><p>Veículo cadastrado com sucesso!</p></div>';
                    header('Location: ./index.php');
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style></style>
</head>
<body>
    <header>
        <h1>Adicionar Veículo</h1>
    </header>
    <main>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="imagem" id="imagem" required>
            <span id="previewImagem"></span>

            <input type="text" name="nome" id="nome" placeholder="nome" required>
            <select name="categoria" id="categoria">
                <?php foreach($categorias as $key=>$value){ ?>
                    <option value="<?= $value['nome'] ?>"><?= $value['nome'] ?></option>
                <?php } ?>
            </select>
            <textarea name="descricao" id="" cols="30" rows="10" placeholder="Descrição" required></textarea>
            <input type="number" name="valor" id="valor" placeholder="Valor" required>
            <input type="number" name="peso" id="peso" placeholder="Peso" required>
            <input type="number" name="largura" id="largura" placeholder="Largura" required>
            <input type="number" name="altura" id="altura" placeholder="Altura" required>
            <input type="number" name="comprimento" id="comprimento" placeholder="Comprimento" required>
            <input type="file" name="imagens[]" id="imagens" multiple="multiple" required>

            <label>Tamanhos Disponíveis:</label>
            
            <input type="checkbox" id="sizeSmall" name="sizes[]" value="P">
            <label for="sizeSmall">P</label>

            <input type="checkbox" id="sizeMedium" name="sizes[]" value="M">
            <label for="sizeMedium">M</label>

            <input type="checkbox" id="sizeLarge" name="sizes[]" value="G">
            <label for="sizeLarge">G</label>

            <input type="checkbox" id="sizeSmall" name="sizes[]" value="GG">
            <label for="sizeSmall">GG</label>

            <input type="checkbox" id="sizeMedium" name="sizes[]" value="M">
            <label for="sizeMedium">Sob Medida</label>

            <input type="checkbox" id="sizeLarge" name="sizes[]" value="G">
            <label for="sizeLarge">Sob Encomenda</label>

            <input type="checkbox" id="sizeSmall" name="sizes[]" value="P">
            <label for="sizeSmall">Tamanho Único</label>

            <label>Números Disponíveis:</label>
            
            <input type="checkbox" id="sizeSmall" name="numbers[]" value="34">
            <label for="sizeSmall">34</label>

            <input type="checkbox" id="sizeMedium" name="numbers[]" value="35">
            <label for="sizeMedium">35</label>

            <input type="checkbox" id="sizeLarge" name="numbers[]" value="36">
            <label for="sizeLarge">36</label>

            <input type="checkbox" id="sizeSmall" name="numbers[]" value="37">
            <label for="sizeSmall">37</label>

            <input type="checkbox" id="sizeMedium" name="numbers[]" value="38">
            <label for="sizeMedium">38</label>

            <input type="checkbox" id="sizeLarge" name="numbers[]" value="39">
            <label for="sizeLarge">39</label>

            <input type="checkbox" id="sizeSmall" name="numbers[]" value="40">
            <label for="sizeSmall">40</label>
            
            <input type="checkbox" id="sizeSmall" name="sizes[]" value="41">
            <label for="sizeSmall">41</label>

            <input type="checkbox" id="sizeMedium" name="sizes[]" value="42">
            <label for="sizeMedium">42</label>

            <input type="checkbox" id="sizeLarge" name="sizes[]" value="43">
            <label for="sizeLarge">43</label>

            <input type="checkbox" id="sizeSmall" name="sizes[]" value="44">
            <label for="sizeSmall">44</label>

            <input type="checkbox" id="sizeMedium" name="sizes[]" value="Sob Medida">
            <label for="sizeMedium">Sob Medida</label>

            <input type="checkbox" id="sizeLarge" name="sizes[]" value="Sob Encomenda">
            <label for="sizeLarge">Sob Encomenda</label>

            <div class="previews">
                <span id="previewImagem2"></span>
            </div>
            <input type="submit" name="SendCadUser" class="button_save" value="Salvar">
        </form>
    </main>
    <form>
  </form>

</body>
</html>

  <script>

    const inputImagens2 = document.getElementById("imagens");

        // Receber o seletor para enviar o preview das imagens
        const previewImagem2 = document.getElementById("previewImagem2");

        // Aguardar alteração no campo de imagens
        inputImagens2.addEventListener("change", function (e) {

            // Limpar o seletor que recebe o preview das imagens
            previewImagem2.innerHTML = "";

            // Percorrer a lista de arquivos selecionados
            for (const arquivo of e.target.files) {
                console.log(arquivo);

                // Criar a TAG <img>, no atributo src atribuir a imagem e no atributo alt o nome 
                const imagemHTML = `<img src="${URL.createObjectURL(arquivo)}" alt="${arquivo.name}" style="height: 200px; margin: 10px;margin-top: 30px;">`;

                // Enviar para o HTML a imagem, beforeend - adicionar a image no final
                previewImagem2.insertAdjacentHTML("beforeend", imagemHTML);
            }

        });

        const inputImagens = document.getElementById("imagem");

        // Receber o seletor para enviar o preview das imagens
        const previewImagem = document.getElementById("previewImagem");

        // Aguardar alteração no campo de imagens
        inputImagens.addEventListener("change", function (e) {

            // Limpar o seletor que recebe o preview das imagens
            previewImagem.innerHTML = "";

            // Percorrer a lista de arquivos selecionados
            for (const arquivo of e.target.files) {
                console.log(arquivo);

                // Criar a TAG <img>, no atributo src atribuir a imagem e no atributo alt o nome 
                const imagemHTML = `<img src="${URL.createObjectURL(arquivo)}" alt="${arquivo.name}" style="height: 200px; margin: 10px;margin-top: 30px;">`;

                // Enviar para o HTML a imagem, beforeend - adicionar a image no final
                previewImagem.insertAdjacentHTML("beforeend", imagemHTML);
            }

        });
        let filtro = document.querySelector('.container-filtrar');

        let openMenu = document.querySelector('#openMenu');
        let closeMenu = document.querySelector('#closeMenu');

        function ativarFiltro(){
            filtro.style.display = 'block';
        }
        function fecharFiltro(){
            filtro.style.display = 'none';
        }
  </script>