<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Bibloteca Digital</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="../paginas/index.php">Home</a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item"><a class="nav-link" href="../paginas/camera.php">Câmera</a></li>
        <li class="nav-item"><a class="nav-link" href="../paginas/Ler.php">Lista de Leitura</a></li>
      <?php endif; ?>
      <?php if (isset($_SESSION['nivelPermissao']) && $_SESSION['nivelPermissao'] == 2): ?>
        <li class="nav-item"><a class="nav-link" href="../paginas/RegistroLivro.php">Cadastro Livro</a></li>
      <?php endif; ?>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item"><a class="nav-link" href="../login/logout.php">Logout</a></li>
      <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="../login/login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
