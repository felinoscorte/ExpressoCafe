<?php
session_start();

if (!isset($_SESSION["carrinho"])) {
  $_SESSION["carrinho"] = array();
}

$produtos = [
  "Café Sirius" => [
    "preco" => 6.00,
    "descricao" => "Blend forte de grãos arábica torrados lentamente com toque de canela e pitadas de noz-moscada, trazendo um aroma intenso e um sabor marcante, perfeito para quem busca despertar com energia e ousadia.",
    "imagem" => "img/sirius.png"
  ],
  "Expresso de Hogwarts" => [
    "preco" => 7.50,
    "descricao" => "Café expresso extraído com grãos especiais cultivados nas terras encantadas de Hogwarts, com notas de caramelo queimado e final levemente amargo, ideal para quem precisa de foco nas aulas e feitiços.",
    "imagem" => "img/expresso.png"
  ],
  "Café Noite na Floresta" => [
    "preco" => 8.00,
    "descricao" => "Café de torra escura, com infusão de baunilha e toque de cacau amargo, remetendo ao mistério e à profundidade da floresta proibida sob o luar.",
    "imagem" => "img/noite.png"
  ],
  "Chá da Sala Precisa" => [
    "preco" => 5.50,
    "descricao" => "Mistura delicada de camomila, hortelã-pimenta e lavanda, que acalma a mente e revitaliza o corpo, ideal para momentos em que se precisa de concentração e tranquilidade.",
    "imagem" => "img/sala.png"
  ],
  "Infusão da Madame Pomfrey" => [
    "preco" => 6.00,
    "descricao" => "Chá medicinal com gengibre, raiz de alcaçuz e mel de acácia, conhecido por suas propriedades curativas e capacidade de fortalecer o sistema imunológico.",
    "imagem" => "img/pomfrey.png"
  ],
  "Chá de Ervas Místicas" => [
    "preco" => 5.00,
    "descricao" => "Combinação de folhas de erva-cidreira, alecrim e folhas de mirra, que proporcionam energia suave e estimulam a intuição mágica.",
    "imagem" => "img/ervas.png"
  ],
  "Bolo da Ala Comunal" => [
    "preco" => 7.00,
    "descricao" => "Bolo macio feito com especiarias como canela, cravo e noz-moscada, coberto com glacê de baunilha e decorado com confeitos mágicos coloridos.",
    "imagem" => "img/bolo.png"
  ],
  "Pão de queijo encantado" => [
    "preco" => 4.00,
    "descricao" => "Pão de queijo com queijo Minas artesanal, manteiga fresca e uma pitada de ervas finas, mantido quente por encantamento para um sabor sempre fresco.",
    "imagem" => "img/pao.png"
  ],
  "Torta de Abóbora" => [
    "preco" => 6.50,
    "descricao" => "Torta feita com abóbora orgânica, açúcar mascavo e especiarias tradicionais como canela e gengibre, finalizada com uma crosta crocante amanteigada.",
    "imagem" => "img/torta.png"
  ],
];

if (isset($_GET["nome"])) {
  $nome = $_GET["nome"];
  if (isset($produtos[$nome])) {
    $produto = $produtos[$nome];
  } else {
    die("Produto não encontrado.");
  }
} else {
  die("Produto não especificado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($nome) ?> - Expresso Café</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css" />
  <style>
    .produto-detalhe {
      max-width: 600px;
      margin: 30px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(102,51,51,0.3);
      padding: 25px;
      text-align: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .produto-detalhe img {
      max-width: 100%;
      border-radius: 10px;
      margin-bottom: 20px;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
    .produto-detalhe h1 {
      margin-bottom: 15px;
      color: #5a2a2a;
      font-weight: 700;
    }
    .produto-detalhe p {
      font-size: 1.15em;
      color: #333;
      margin-bottom: 20px;
      line-height: 1.4;
    }
    .produto-detalhe .preco {
      font-weight: 700;
      font-size: 1.3em;
      color: #7b3f3f;
      margin-bottom: 25px;
    }
    form {
      margin-bottom: 15px;
    }
    form input[type="number"] {
      width: 60px;
      padding: 7px;
      font-size: 1em;
      border: 1px solid #c39b9b;
      border-radius: 5px;
      text-align: center;
      margin-right: 12px;
    }
    form input[type="submit"] {
      background-color: #7b3f3f;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 1em;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    form input[type="submit"]:hover {
      background-color: #a05a5a;
    }
    a.voltar {
      display: inline-block;
      margin-top: 20px;
      color: #7b3f3f;
      text-decoration: none;
      font-weight: 600;
    }
    a.voltar:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="produto-detalhe">
      <h1><?= htmlspecialchars($nome) ?></h1>
      <img src="<?= $produto['imagem'] ?>" alt="<?= htmlspecialchars($nome) ?>">
      <p><?= $produto["descricao"] ?></p>
      <div class="preco">Preço: R$ <?= number_format($produto["preco"], 2, ',', '.') ?></div>

      <form action="carrinho.php" method="get">
        <input type="hidden" name="acao" value="add" />
        <input type="hidden" name="nome" value="<?= htmlspecialchars($nome) ?>" />
        <input type="hidden" name="preco" value="<?= $produto["preco"] ?>" />
        <label for="quant">Quantidade:</label>
        <input type="number" id="quant" name="quant" value="1" min="1" max="10" />
        <input type="submit" value="Adicionar ao carrinho" />
      </form>

      <a href="index.php" class="voltar">← Voltar ao cardápio</a>
    </div>
  </div>

</body>
</html>
