<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../../module/back-office/articles.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'titre' => trim($_POST['titre'] ?? ''),
        'chapeau' => trim($_POST['chapeau'] ?? ''),
        'contenu' => trim($_POST['contenu'] ?? ''),
        'author_id' => $_SESSION['user_id'],
        'status' => (int)($_POST['status'] ?? 0)
    ];

    if (empty($data['titre']) || empty($data['chapeau']) || empty($data['contenu'])) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        $result = createArticle($data, $_FILES);
        if ($result['success']) {
            header('Location: list.php?msg=created');
            exit;
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel Article - Back Office</title>
    <link rel="stylesheet" href="../../../static/css/admin.css">
</head>
<body>
    <nav class="admin-navbar">
        <h1>Back Office</h1>
        <div class="nav-links">
            <a href="../home.php">Tableau de bord</a>
            <a href="list.php" class="active">Articles</a>
            <a href="../logout.php" class="btn-logout">Deconnexion</a>
        </div>
    </nav>

    <div class="admin-container">
        <div class="page-header">
            <h2>Nouvel Article</h2>
            <a href="list.php" class="btn btn-secondary">&#8592; Retour a la liste</a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="titre">Titre *</label>
                        <input type="text" id="titre" name="titre" class="form-control"
                               value="<?php echo htmlspecialchars($_POST['titre'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="chapeau">Chapeau *</label>
                        <input type="text" id="chapeau" name="chapeau" class="form-control"
                               value="<?php echo htmlspecialchars($_POST['chapeau'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="contenu">Contenu *</label>
                        <textarea id="contenu" name="contenu" class="form-control" required><?php echo htmlspecialchars($_POST['contenu'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Image principale</label>
                        <div class="file-upload">
                            <input type="file" name="image_principale" accept="image/*" data-preview="preview-principale">
                            <label class="file-upload-label">
                                <span class="icon">&#128247;</span>
                                <span>Cliquez ou glissez une image ici</span>
                                <span style="font-size:12px;color:#999;">JPG, PNG, GIF - Max 5MB</span>
                            </label>
                        </div>
                        <div id="preview-principale" class="image-preview"></div>
                    </div>

                    <div class="form-group">
                        <label>Images supplementaires</label>
                        <div class="file-upload">
                            <input type="file" name="images_supplementaires[]" accept="image/*" multiple data-preview="preview-supplementaires">
                            <label class="file-upload-label">
                                <span class="icon">&#128248;</span>
                                <span>Cliquez ou glissez plusieurs images ici</span>
                                <span style="font-size:12px;color:#999;">Vous pouvez selectionner plusieurs fichiers</span>
                            </label>
                        </div>
                        <div id="preview-supplementaires" class="image-preview"></div>
                    </div>

                    <div class="form-group">
                        <label for="status">Statut</label>
                        <select id="status" name="status" class="form-control">
                            <option value="0">Brouillon</option>
                            <option value="1">Publie</option>
                        </select>
                    </div>

                    <div style="display:flex;gap:15px;margin-top:30px;">
                        <button type="submit" class="btn btn-primary">Creer l'article</button>
                        <a href="list.php" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../../../static/js/admin.js"></script>
</body>
</html>
