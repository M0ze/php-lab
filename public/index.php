<?php

use App\Contact;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$pdo = new PDO(
    'sqlite:' . ($_ENV['SQLITE_DATABASE'] ?? ':memory:'),
    null,
    null,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$contact = new Contact($pdo);

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name !== '' && $email !== '' && $message !== '') {
        $contact->save($name, $email, $message);
        $name = $email = $message = '';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Contact</title>
  <style>
    body { font-family: sans-serif; max-width: 600px; margin: 2rem auto; }
    .form-group { margin: 0.75rem 0; }
    label { display: block; margin-bottom: 0.25rem; }
    input, textarea { width: 100%; padding: 0.4rem; box-sizing: border-box; }
    button { padding: 0.4rem 1rem; cursor: pointer; }
    .success { color: #1a7a1a; }
    ul { list-style: none; padding: 0; }
    li { border-bottom: 1px solid #ddd; padding: 0.5rem 0; }
  </style>
</head>
<body>
  <h1>Contact</h1>

  <?php if ($message !== ''): ?>
    <p class="success">Saved. Thanks, <?= htmlspecialchars($name) ?>.</p>
  <?php endif; ?>

  <form method="post" action="">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
    </div>
    <div class="form-group">
      <label for="message">Message</label>
      <textarea id="message" name="message" rows="5"><?= htmlspecialchars($message) ?></textarea>
    </div>
    <button type="submit">Send</button>
  </form>

  <h2>Messages</h2>
  <?php foreach ($contact->all() as $row): ?>
    <li>
      <strong><?= htmlspecialchars($row['name']) ?></strong>
      &lt;<?= htmlspecialchars($row['email']) ?>&gt;
      <small><?= htmlspecialchars($row['created_at']) ?></small>
      <p style="margin:0.25rem 0 0; color:#444;"><?= htmlspecialchars($row['message']) ?></p>
    </li>
  <?php endforeach; ?>
</body>
</html>
