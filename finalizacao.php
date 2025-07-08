<?php
session_start();

if (!isset($_SESSION["carrinho"]) || count($_SESSION["carrinho"]) === 0) {
  header("Location: index.php");
  exit;
}

// Calcula total
$total = 0;
foreach ($_SESSION["carrinho"] as $item) {
  $total += $item["subtotal"];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Finalizar Compra – Expresso Café</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9f6f1;
      color: #333;
    }

    .container {
      max-width: 500px;
      margin: 40px auto;
      background: #fff;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 8px;
    }

    h1, h2, h3 {
      text-align: center;
      color: #6b4f3b;
    }

    ul {
      list-style: none;
      padding: 0;
      margin-bottom: 20px;
    }

    li {
      border-bottom: 1px solid #eee;
      padding: 8px 0;
    }

    label {
      font-weight: bold;
      color: #6b4f3b;
    }

    input[type="text"],
    textarea,
    select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 14px;
    }

    input[type="submit"] {
      width: 100%;
      background-color: #6b4f3b;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
    }

    input[type="submit"]:hover {
      background-color: #5a3f31;
    }

    a {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #6b4f3b;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Finalizar Compra</h1>

    <h2>Resumo do pedido</h2>
    <ul>
      <?php foreach ($_SESSION["carrinho"] as $item): ?>
        <li><?= htmlspecialchars($item["produto"]) ?> — <?= $item["quant"] ?> x R$ <?= number_format($item["valor"],2,',','.') ?> = R$ <?= number_format($item["subtotal"],2,',','.') ?></li>
      <?php endforeach; ?>
    </ul>
    <h3>Total: R$ <?= number_format($total, 2, ',', '.') ?></h3>

    <form action="processa_pedido.php" method="post">
      <label for="nome">Nome completo:</label>
      <input type="text" id="nome" name="nome" required />

      <label for="numero">Número da mesa:</label>
      <textarea id="numero" name="numero" required></textarea>

      <label for="pagamento">Forma de pagamento:</label>
      <select id="pagamento" name="pagamento" required>
        <option value="">Selecione</option>
        <option value="cartao">Cartão de Crédito</option>
        <option value="boleto">Boleto Bancário</option>
        <option value="pix">PIX</option>
      </select>

      <input type="submit" value="Confirmar Pedido" />
    </form>

    <a href="carrinho.php">← Voltar ao Carrinho</a>
  </div>
</body>
</html>
