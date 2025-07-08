<?php
session_start();

if (!isset($_SESSION["carrinho"]) || count($_SESSION["carrinho"]) === 0) {
  header("Location: index.php");
  exit;
}

$campos = ['nome', 'numero', 'pagamento'];

$nome = htmlspecialchars(trim($_POST['nome']));
$numero = htmlspecialchars(trim($_POST['numero']));
$pagamento = htmlspecialchars(trim($_POST['pagamento']));

$total = 0;
foreach ($_SESSION["carrinho"] as $item) {
  $total += $item["subtotal"];
}

unset($_SESSION["carrinho"]);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Pedido Confirmado – Expresso Café</title>
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
      text-align: center;
    }

    h1 {
      color: #6b4f3b;
      margin-bottom: 20px;
    }

    h2, h3 {
      color: #6b4f3b;
      margin-top: 30px;
      margin-bottom: 10px;
    }

    p {
      font-size: 16px;
      line-height: 1.4;
    }

    ul {
      list-style: none;
      padding: 0;
      text-align: left;
    }

    li {
      border-bottom: 1px solid #eee;
      padding: 8px 0;
    }

    strong {
      color: #6b4f3b;
    }

    a {
      display: inline-block;
      margin-top: 30px;
      text-decoration: none;
      background-color: #6b4f3b;
      color: white;
      padding: 12px 20px;
      border-radius: 4px;
      font-size: 16px;
    }

    a:hover {
      background-color: #5a3f31;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Pedido Confirmado!<br> Aguarde enquanto geramos seu QRCode.</h1>
    <p>Obrigado, <strong><?= $nome ?></strong>, pelo seu pedido!</p>

    <h2>Resumo do Pedido</h2>
    <ul>
      <?php foreach ($_SESSION["carrinho"] ?? [] as $item): ?>
        <li><?= htmlspecialchars($item["produto"]) ?> — <?= $item["quant"] ?> x R$ <?= number_format($item["valor"], 2, ',', '.') ?> = R$ <?= number_format($item["subtotal"], 2, ',', '.') ?></li>
      <?php endforeach; ?>
    </ul>

    <h3>Total pago: R$ <?= number_format($total, 2, ',', '.') ?></h3>

    <p><strong>Número:</strong> <?= $numero ?></p>
    <p><strong>Forma de pagamento:</strong> <?= ucfirst($pagamento) ?></p>

    <a href="index.php">Voltar ao cardápio</a>
  </div>
</body>
</html>
