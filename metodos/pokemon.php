<?php
require __DIR__ . '/function.php';

$nome = strtolower(trim($_GET['name'] ?? ''));
$p = $nome !== '' ? api_get('pokemon/' . rawurlencode($nome)) : null;
if (!$p) http_response_code(404);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $p ? h(ucfirst($p['name'])) : 'Não encontrado' ?> • Pokédex</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header><h1><a href="index.php">Pokédex</a></h1></header>
  <main>
  <?php if (!$p): ?>
    <p class="erro">Pokémon “<?= h($nome) ?>” não encontrado.</p>
    <p><a href="index.php">← Voltar</a></p>
  <?php else: ?>
    <article class="detalhe">
      <img src="<?= imagem($p['id']) ?>" alt="<?= h($p['name']) ?>">
      <span class="num">#<?= str_pad($p['id'], 3, '0', STR_PAD_LEFT) ?></span>
      <h2><?= h(ucfirst($p['name'])) ?></h2>

      <div class="tipos">
        <?php foreach ($p['types'] as $t): $tipo = $t['type']['name']; ?>
          <span class="tipo <?= h($tipo) ?>"><?= h($tipo) ?></span>
        <?php endforeach; ?>
      </div>

      <p>Altura: <?= $p['height'] / 10 ?> m • Peso: <?= $p['weight'] / 10 ?> kg</p>
      <p>Habilidades:
        <?= h(implode(', ', array_map(fn($a) => $a['ability']['name'], $p['abilities']))) ?>
      </p>

      <h3>Status base</h3>
      <?php foreach ($p['stats'] as $s): $v = $s['base_stat']; ?>
        <div class="stat">
          <span><?= h($s['stat']['name']) ?></span>
          <div class="barra"><div style="width: <?= min(100, $v / 255 * 100) ?>%"></div></div>
          <b><?= $v ?></b>
        </div>
      <?php endforeach; ?>

      <p><a href="index.php">← Voltar à lista</a></p>
    </article>
  <?php endif; ?>
  </main>
</body>
</html>