<?php
session_start();

if (!isset($_SESSION["carrinho"])) {
  $_SESSION["carrinho"] = array();
}

$produtos = [
  "Cafés" => [
    "Café Sirius" => [
      "preco" => 6.00,
      "imagem" => "img/sirius.png",
      "descricao" => "Blend forte de grãos arábica torrados lentamente com toque de canela e pitadas de noz-moscada, trazendo um aroma intenso e um sabor marcante, perfeito para quem busca despertar com energia e ousadia."
    ],
    "Expresso de Hogwarts" => [
      "preco" => 7.50,
      "imagem" => "img/expresso.png",
      "descricao" => "Café expresso extraído com grãos especiais cultivados nas terras encantadas de Hogwarts, com notas de caramelo queimado e final levemente amargo, ideal para quem precisa de foco nas aulas e feitiços."
    ],
    "Café Noite na Floresta" => [
      "preco" => 8.00,
      "imagem" => "img/noite.png",
      "descricao" => "Café de torra escura, com infusão de baunilha e toque de cacau amargo, remetendo ao mistério e à profundidade da floresta proibida sob o luar."
    ]
  ],
  "Chás" => [
    "Chá da Sala Precisa" => [
      "preco" => 5.50,
      "imagem" => "img/sala.png",
      "descricao" => "Mistura delicada de camomila, hortelã-pimenta e lavanda, que acalma a mente e revitaliza o corpo, ideal para momentos em que se precisa de concentração e tranquilidade."
    ],
    "Infusão da Madame Pomfrey" => [
      "preco" => 6.00,
      "imagem" => "img/pomfrey.png",
      "descricao" => "Chá medicinal com gengibre, raiz de alcaçuz e mel de acácia, conhecido por suas propriedades curativas e capacidade de fortalecer o sistema imunológico."
    ],
    "Chá de Ervas Místicas" => [
      "preco" => 5.00,
      "imagem" => "img/ervas.png",
      "descricao" => "Combinação de folhas de erva-cidreira, alecrim e folhas de mirra, que proporcionam energia suave e estimulam a intuição mágica."
    ]
  ],
  "Doces" => [
    "Bolo da Ala Comunal" => [
      "preco" => 7.00,
      "imagem" => "img/bolo.png",
      "descricao" => "Bolo macio feito com especiarias como canela, cravo e noz-moscada, coberto com glacê de baunilha e decorado com confeitos mágicos coloridos."
    ],
    "Pão de queijo encantado" => [
      "preco" => 4.00,
      "imagem" => "img/pao.png",
      "descricao" => "Pão de queijo com queijo Minas artesanal, manteiga fresca e uma pitada de ervas finas, mantido quente por encantamento para um sabor sempre fresco."
    ],
    "Torta de Abóbora" => [
      "preco" => 6.50,
      "imagem" => "img/torta.png",
      "descricao" => "Torta feita com abóbora orgânica, açúcar mascavo e especiarias tradicionais como canela e gengibre, finalizada com uma crosta crocante amanteigada."
    ]
  ]
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Expresso Café</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<div class="container">
  <header>
    <img src="img/logo.png" alt="Logo Expresso Café" class="logo" />
    <h1>Expresso Café</h1>
    <h2>Sabores que transportam você direto para Hogwarts</h2>
  </header>

  <div class="filtros">
    <button type="button" data-categoria="Cafés" class="btn-filtro">Cafés</button>
    <button type="button" data-categoria="Chás" class="btn-filtro">Chás</button>
    <button type="button" data-categoria="Doces" class="btn-filtro">Doces</button>
    <button type="button" data-categoria="Todos" class="btn-filtro">Todos</button>
  </div>

  <input type="search" placeholder="Pesquisar produto..." class="pesquisa" id="pesquisa" />

  <?php foreach ($produtos as $categoria => $itens): ?>
    <div class="categoria-produtos" data-categoria="<?= $categoria ?>">
      <h3><?= $categoria ?></h3>
      <div class="cards">
        <?php foreach ($itens as $nome => $detalhes): ?>
          <div class="card" data-nome="<?= strtolower($nome) ?>">
            <img src="<?= $detalhes['imagem'] ?>" alt="<?= $nome ?>">
            <h4><?= $nome ?></h4>
            <p>R$ <?= number_format($detalhes['preco'], 2, ',', '.') ?></p>
            <a href="produto.php?nome=<?= urlencode($nome) ?>">Saiba mais</a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>

  <?php if (count($_SESSION["carrinho"]) > 0): ?>
    <div class="carrinho-link">
      <a href="carrinho.php">Ver Carrinho (<?= count($_SESSION["carrinho"]) ?> itens)</a>
    </div>
  <?php endif; ?>
</div>

<script>
  const botoes = document.querySelectorAll('.btn-filtro');
  const categorias = document.querySelectorAll('.categoria-produtos');
  const inputPesquisa = document.getElementById('pesquisa');

  botoes.forEach(botao => {
    botao.addEventListener('click', () => {
      const categoriaSelecionada = botao.getAttribute('data-categoria').trim();

      categorias.forEach(divCat => {
        const catDiv = divCat.getAttribute('data-categoria').trim();
        if (categoriaSelecionada === 'Todos' || catDiv === categoriaSelecionada) {
          divCat.style.display = 'block';
        } else {
          divCat.style.display = 'none';
        }
      });
    });
  });

  inputPesquisa.addEventListener('input', () => {
    const termo = inputPesquisa.value.toLowerCase();

    categorias.forEach(divCat => {
      let temProdutoVisivel = false;
      const cards = divCat.querySelectorAll('.card');

      cards.forEach(card => {
        const nome = card.getAttribute('data-nome');
        if (nome.includes(termo)) {
          card.style.display = 'block';
          temProdutoVisivel = true;
        } else {
          card.style.display = 'none';
        }
      });

      divCat.style.display = temProdutoVisivel ? 'block' : 'none';
    });
  });
</script>

</body>
</html>
