<?php
session_start();

if (!isset($_SESSION["carrinho"])) {
  $_SESSION["carrinho"] = [];
}

function alterarCarrinho($acao, $nome, $preco, $quant = 1) {
  foreach ($_SESSION["carrinho"] as $i => $item) {
    if (!isset($item["produto"])) continue; // PREVINE WARNING

    if ($item["produto"] === $nome) {
      if ($acao === "add") {
        $_SESSION["carrinho"][$i]["quant"] += $quant;
      } elseif ($acao === "sub") {
        $_SESSION["carrinho"][$i]["quant"]--;
        if ($_SESSION["carrinho"][$i]["quant"] < 1) {
          unset($_SESSION["carrinho"][$i]);
          $_SESSION["carrinho"] = array_values($_SESSION["carrinho"]);
          return;
        }
      } elseif ($acao === "del") {
        unset($_SESSION["carrinho"][$i]);
        $_SESSION["carrinho"] = array_values($_SESSION["carrinho"]);
        return;
      }
      if (isset($_SESSION["carrinho"][$i])) {
        $_SESSION["carrinho"][$i]["subtotal"] = $_SESSION["carrinho"][$i]["quant"] * $preco;
      }
      return;
    }
  }

  if ($acao === "add") {
    $_SESSION["carrinho"][] = [
      "produto" => $nome,
      "valor" => $preco,
      "quant" => $quant,
      "subtotal" => $preco * $quant
    ];
  }
}

if (isset($_GET["acao"], $_GET["nome"], $_GET["preco"])) {
  $acao = $_GET["acao"];
  $nome = $_GET["nome"];
  $preco = floatval($_GET["preco"]);
  $quant = isset($_GET["quant"]) ? intval($_GET["quant"]) : 1;
  alterarCarrinho($acao, $nome, $preco, $quant);
}

$_SESSION["carrinho"] = array_values($_SESSION["carrinho"]);

$total = 0;
foreach ($_SESSION["carrinho"] as $item) {
  if (isset($item["subtotal"])) {
    $total += $item["subtotal"];
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Carrinho – Expresso Café</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9f6f1;
      color: #3e2723;
      margin: 0;
      padding: 20px;
      text-align: center;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: #fff8f0;
      padding: 20px;
      border-radius: 10px;
    }
    .logo img {
      max-width: 150px;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #ccc;
    }
    th {
      background-color: #5d4037;
      color: #fff;
    }
    .acoes a {
      margin: 0 5px;
      text-decoration: none;
      color: #6d4c41;
      font-weight: bold;
    }
    .acoes a:hover {
      text-decoration: underline;
    }
    .btn {
      display: inline-block;
      margin: 10px;
      padding: 10px 20px;
      background-color: #6d4c41;
      color: #fff;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .btn:hover {
      background-color: #8d6e63;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="logo">
      <img src="img/logo.png" alt="Logo Expresso Café">
    </div>

    <h1>Carrinho de Compras</h1>

    <?php if (empty($_SESSION["carrinho"])): ?>
      <p>Seu carrinho está vazio.</p>
      <a class="btn" href="index.php">← Voltar ao cardápio</a>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Produto</th>
            <th>Preço</th>
            <th>Quant.</th>
            <th>Subtotal</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($_SESSION["carrinho"] as $item): ?>
            <?php if (isset($item["produto"], $item["valor"], $item["quant"], $item["subtotal"])): ?>
              <tr>
                <td><?= htmlspecialchars($item["produto"]) ?></td>
                <td>R$ <?= number_format($item["valor"], 2, ',', '.') ?></td>
                <td><?= $item["quant"] ?></td>
                <td>R$ <?= number_format($item["subtotal"], 2, ',', '.') ?></td>
                <td class="acoes">
                  <a href="?acao=add&nome=<?= urlencode($item["produto"]) ?>&preco=<?= $item["valor"] ?>">[ + ]</a>
                  <a href="?acao=sub&nome=<?= urlencode($item["produto"]) ?>&preco=<?= $item["valor"] ?>">[ – ]</a>
                  <a href="?acao=del&nome=<?= urlencode($item["produto"]) ?>&preco=<?= $item["valor"] ?>">[ remover ]</a>
                </td>
              </tr>
            <?php endif; ?>
          <?php endforeach; ?>
        </tbody>
      </table>

      <h3>Total: R$ <?= number_format($total, 2, ',', '.') ?></h3>

      <a class="btn" href="index.php">← Continuar comprando</a>
      <a class="btn" href="finalizacao.php">Finalizar compra →</a>
    <?php endif; ?>
  </div>

</body>
</html>
