<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Back Office</title>
    <link rel="stylesheet" href="../../static/css/login.css">
</head>
<body>
    <div class="login-container">
        <h1>Back Office</h1>

        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php
                $error = $_GET['error'];
                if ($error === 'invalid') {
                    echo "Nom d'utilisateur ou mot de passe incorrect.";
                } elseif ($error === 'empty') {
                    echo "Veuillez remplir tous les champs.";
                } elseif ($error === 'db') {
                    echo "Erreur de connexion a la base de donnees.";
                }
                ?>
            </div>
        <?php endif; ?>

        <form action="login_process.php" method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" value="admin" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" value="adminpassword" required>
            </div>
            <button type="submit" class="btn">Se connecter</button>
        </form>
    </div>

    <script src="../../static/js/login.js"></script>
</body>
</html>
