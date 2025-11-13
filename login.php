<?php
require __DIR__ . '/config/db.php';
require __DIR__ . '/functions/helpers.php';
require __DIR__ . '/functions/auth.php';

if (is_logged_in()) { header('Location: /php_mysql_media_starter/admin/dashboard.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $pass = $_POST['password'] ?? '';
  $user = fetchOne($pdo, "SELECT * FROM users WHERE email = ?", [$email]);
  if ($user && password_verify($pass, $user['password'])) {
    login($user);
    redirect('/php_mysql_media_starter/admin/dashboard.php');
  } else {
    $error = 'Email ose fjalëkalim i pasaktë.';
  }
}
include __DIR__ . '/partials/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <h3>Hyrje</h3>
    <?php if($error): ?><div class="alert alert-danger"><?= esc($error) ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Fjalëkalimi</label>
        <input class="form-control" type="password" name="password" required>
      </div>
      <button class="btn btn-primary">Kyçu</button>
      <a class="btn btn-link" href="/php_mysql_media_starter/index.php">Kreu</a>
    </form>
  </div>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>