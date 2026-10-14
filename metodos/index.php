<?php
require __DIR__ . '/function.php';

$limite = 12;
$pagina = max(1, (int)($_GET['page'] ?? 1));   // GET ?page=2
$offset = ($pagina - 1) * $limite;

$dados = api_get("pokemon?limit=$limite&offset=$offset");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pokédex</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Pokédex</h1>
    <form action="pokemon.php" method="get">
      <input type="text" name="name" placeholder="Nome ou número (ex: pikachu)" required>
      <button>Buscar</button>
    </form>
  </header>

  <main>
  <?php if (!$dados): ?>
    <p class="erro">Não foi possível carregar a API. Tente novamente.</p>
  <?php else: ?>
    <div class="grid">
      <?php foreach ($dados['results'] as $p):
          // a URL termina com o id: .../pokemon/25/
          preg_match('#/pokemon/(\d+)/?$#', $p['url'], $m);
          $id = (int)$m[1]; ?>
        <a class="card" href="pokemon.php?name=<?= h($p['name']) ?>">
          <span class="sprite">
            <img class="normal" src="<?= sprite($id) ?>" alt="<?= h($p['name']) ?>" loading="lazy">
            <img class="shiny" src="<?= sprite_shiny($id) ?>" alt="" loading="lazy">
          </span>
          <span class="num">#<?= str_pad($id, 3, '0', STR_PAD_LEFT) ?></span>
          <h2><?= h(ucfirst($p['name'])) ?></h2>
        </a>
      <?php endforeach; ?>
    </div>

    <nav class="paginacao">
      <?php if ($pagina > 1): ?><a href="?page=<?= $pagina - 1 ?>">← Anterior</a><?php endif; ?>
      <span>Página <?= $pagina ?></span>
      <?php if ($dados['next']): ?><a href="?page=<?= $pagina + 1 ?>">Próxima →</a><?php endif; ?>
    </nav>
  <?php endif; ?>
  </main>
</body>
</html>