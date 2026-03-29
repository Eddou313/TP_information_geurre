<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/../../../module/back-office/articles.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$article = getArticleForEdit($id);

if (!$article) {
    header('Location: list.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'titre' => trim($_POST['titre'] ?? ''),
        'chapeau' => trim($_POST['chapeau'] ?? ''),
        'contenu' => trim($_POST['contenu'] ?? ''),
        'status' => (int)($_POST['status'] ?? 0),
        'current_image_id' => $article['image_id'],
        'date_publication' => $article['date_publication']
    ];

    if (empty($data['titre']) || empty($data['chapeau']) || empty($data['contenu'])) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        $result = updateArticle($id, $data, $_FILES);
        if ($result['success']) {
            header('Location: list.php?msg=updated');
            exit;
        } else {
            $error = $result['message'];
        }
    }

    // Refresh article data
    $article = getArticleForEdit($id);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Article - Back Office</title>
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
            <h2>Modifier l'Article</h2>
            <div style="display:flex;gap:10px;">
                <a href="view.php?id=<?php echo $id; ?>" class="btn btn-secondary">&#128065; Voir</a>
                <a href="list.php" class="btn btn-secondary">&#8592; Retour</a>
            </div>
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
                               value="<?php echo htmlspecialchars($article['titre']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="chapeau">Chapeau *</label>
                        <input type="text" id="chapeau" name="chapeau" class="form-control"
                               value="<?php echo htmlspecialchars($article['chapeau']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="contenu">Contenu *</label>
                        <textarea id="contenu" name="contenu" class="form-control" required><?php echo htmlspecialchars($article['contenu']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Image principale actuelle</label>
                        <?php if ($article['image_principale']): ?>
                            <div class="image-preview">
                                <div class="preview-item">
                                    <img src="../../../<?php echo htmlspecialchars($article['image_principale']); ?>" alt="">
                                </div>
                            </div>
                        <?php else: ?>
                            <p style="color:#888;">Aucune image principale</p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>Changer l'image principale</label>
                        <div class="file-upload">
                            <input type="file" name="image_principale" accept="image/*" data-preview="preview-principale">
                            <label class="file-upload-label">
                                <span class="icon">&#128247;</span>
                                <span>Cliquez ou glissez une nouvelle image</span>
                            </label>
                        </div>
                        <div id="preview-principale" class="image-preview"></div>
                    </div>

                    <div class="form-group">
                        <label>Images supplementaires actuelles</label>
                        <?php if (!empty($article['images'])): ?>
                            <div class="image-preview">
                                <?php foreach ($article['images'] as $img): ?>
                                    <div class="preview-item existing-image">
                                        <img src="../../../<?php echo htmlspecialchars($img['chemin']); ?>" alt="">
                                        <button type="button" class="remove-btn"
                                                data-article-id="<?php echo $id; ?>"
                                                data-image-id="<?php echo $img['id']; ?>">&times;</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p style="color:#888;">Aucune image supplementaire</p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>Ajouter des images supplementaires</label>
                        <div class="file-upload">
                            <input type="file" name="images_supplementaires[]" accept="image/*" multiple data-preview="preview-supplementaires">
                            <label class="file-upload-label">
                                <span class="icon">&#128248;</span>
                                <span>Cliquez ou glissez plusieurs images</span>
                            </label>
                        </div>
                        <div id="preview-supplementaires" class="image-preview"></div>
                    </div>

                    <div class="form-group">
                        <label for="status">Statut</label>
                        <select id="status" name="status" class="form-control">
                            <option value="0" <?php echo $article['status'] == 0 ? 'selected' : ''; ?>>Brouillon</option>
                            <option value="1" <?php echo $article['status'] == 1 ? 'selected' : ''; ?>>Publie</option>
                        </select>
                    </div>

                    <div style="display:flex;gap:15px;margin-top:30px;">
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        <a href="list.php" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../../../static/js/admin.js"></script>
</body>
</html>
