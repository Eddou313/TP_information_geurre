<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /TP_information_geurre/admins');
    exit;
}

require_once __DIR__ . '/../../../module/back-office/articles.php';
require_once __DIR__ . '/../../../module/back-office/auth.php';

$user = getSessionUser();
$currentPage = 'articles-edit';
$basePath = '../';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$article = getArticleForEdit($id);

if (!$article) {
    header('Location: /TP_information_geurre/admins/articles');
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
            header('Location: /TP_information_geurre/admins/articles?msg=updated');
            exit;
        } else {
            $error = $result['message'];
        }
    }

    $article = getArticleForEdit($id);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Modification d'un article Back Office avec mise a jour du contenu, du statut et des images associees.">
    <meta name="robots" content="noindex, nofollow">
    <title>Modifier Article - Back Office</title>
    <link rel="stylesheet" href="/TP_information_geurre/static/css/admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="page-header">
                <h2>Modifier l'Article</h2>
                <div style="display:flex;gap:10px;">
                    <a href="/TP_information_geurre/admins/articles/view-<?php echo $id; ?>" class="btn btn-secondary">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Voir
                    </a>
                    <a href="/TP_information_geurre/admins/articles" class="btn btn-secondary">
                        <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Retour
                    </a>
                </div>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="titre">Titre *</label>
                            <input type="text" id="titre" name="titre" class="form-control" value="<?php echo htmlspecialchars($article['titre']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="chapeau">Chapeau *</label>
                            <input type="text" id="chapeau" name="chapeau" class="form-control" value="<?php echo htmlspecialchars($article['chapeau']); ?>" required>
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
                                        <img src="/TP_information_geurre/<?php echo htmlspecialchars($article['image_principale']); ?>" alt="Image principale actuelle de l'article <?php echo htmlspecialchars($article['titre']); ?>">
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
                                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
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
                                            <img src="/TP_information_geurre/<?php echo htmlspecialchars($img['chemin']); ?>" alt="Image supplementaire <?php echo htmlspecialchars($img['nom_fichier']); ?> de l'article <?php echo htmlspecialchars($article['titre']); ?>">
                                            <button type="button" class="remove-btn" data-article-id="<?php echo $id; ?>" data-image-id="<?php echo $img['id']; ?>">x</button>
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
                                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
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
                            <button type="submit" class="btn btn-primary">
                                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                Enregistrer
                            </button>
                            <a href="/TP_information_geurre/admins/articles" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="/TP_information_geurre/static/js/admin.js"></script>
</body>
</html>
