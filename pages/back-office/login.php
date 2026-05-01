<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connexion securisee a l'espace Back Office pour administrer les articles du site Information Mada.">
    
    <title>Connexion - Back Office</title>
    <link rel="stylesheet" href="/TP_information_geurre/static/css/login.css">
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

        <form action="/TP_information_geurre/admins/traitement" method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" value="admin" placeholder="nom utilisateur"  required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" value="adminpassword" placeholder="mot de passe"  required>
            </div>
            <button type="submit" class="btn">Se connecter</button>
        </form>
<br><br>
        <a href="/TP_information_geurre/"><< Voir les articles</a>

    </div>
    
    <script src="/TP_information_geurre/static/js/login.js"></script>
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            document.getElementById("username").value = "admin";
            document.getElementById("password").value = "adminpassword";
        });
</script>
</body>
</html>
