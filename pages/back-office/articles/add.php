<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /TP_information_geurre/admins');
    exit;
}

require_once __DIR__ . '/../../../module/back-office/articles.php';
require_once __DIR__ . '/../../../module/back-office/auth.php';

$user = getSessionUser();
$currentPage = 'articles-add';
$basePath = '../';

$error = '';

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
            header('Location: /TP_information_geurre/admins/articles?msg=created');
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
    <meta name="description" content="Creation d'un nouvel article dans le Back Office avec gestion des images principales et supplementaires.">
    <meta name="robots" content="noindex, nofollow">
    <title>Nouvel Article - Back Office</title>
    <link rel="stylesheet" href="/TP_information_geurre/static/css/admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>

        <main class="main-content">
            <div class="page-header">
                <h2>Nouvel Article</h2>
                <a href="/TP_information_geurre/admins/articles" class="btn btn-secondary">
                    <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Retour
                </a>
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
                            <input type="text" id="titre" name="titre" class="form-control" value="<?php echo htmlspecialchars($_POST['titre'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="chapeau">Chapeau *</label>
                            <input type="text" id="chapeau" name="chapeau" class="form-control" value="<?php echo htmlspecialchars($_POST['chapeau'] ?? ''); ?>" required>
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
                                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
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
                                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    <span>Cliquez ou glissez plusieurs images</span>
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
                            <button type="submit" class="btn btn-primary">
                                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                Creer l'article
                            </button>
                            <a href="/TP_information_geurre/admins/articles" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="/TP_information_geurre/static/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#contenu',
            license_key: 'gpl',
            height: 400,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image | code | fullscreen',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 14px; }',
            branding: false,
            promotion: false,
            images_upload_url: '/TP_information_geurre/module/back-office/tinymce_upload.php',
            automatic_uploads: true,
            file_picker_types: 'image',
            images_reuse_filename: true,
            relative_urls: false,
            remove_script_host: true,
            convert_urls: true,
            setup: function(editor) {
                editor.on('change', function() {
                    tinymce.triggerSave();
                });
            }
        });
    </script>
    <script src="/TP_information_geurre/static/js/admin.js"></script>
</body>
</html>
