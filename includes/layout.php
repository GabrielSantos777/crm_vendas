<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

    <?php include 'includes/header.php'; ?>

    <main class="container mt-4">
        <?php include $view; ?>
    </main>

    <?php include 'includes/footer.php'; ?>

</body>

</html>