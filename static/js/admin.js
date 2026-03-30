document.addEventListener('DOMContentLoaded', function() {
    initFileUpload();
    initDeleteConfirm();
    initImagePreview();
});

function initFileUpload() {
    const fileUploads = document.querySelectorAll('.file-upload');

    fileUploads.forEach(upload => {
        const input = upload.querySelector('input[type="file"]');
        if (!input) return;

        // Empecher la propagation quand on clique sur l'input directement
        input.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        // Clic sur le conteneur ouvre le selecteur de fichiers
        upload.addEventListener('click', (e) => {
            if (e.target !== input) {
                input.click();
            }
        });

        // Drag and drop
        upload.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.stopPropagation();
            upload.classList.add('dragover');
        });

        upload.addEventListener('dragleave', (e) => {
            e.preventDefault();
            e.stopPropagation();
            upload.classList.remove('dragover');
        });

        upload.addEventListener('drop', (e) => {
            e.preventDefault();
            e.stopPropagation();
            upload.classList.remove('dragover');

            const dt = new DataTransfer();
            Array.from(e.dataTransfer.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    dt.items.add(file);
                }
            });
            input.files = dt.files;
            handleFileSelect(input);
        });

        // Quand l'utilisateur selectionne des fichiers
        input.addEventListener('change', () => handleFileSelect(input));
    });
}

function handleFileSelect(input) {
    const previewContainer = document.getElementById(input.dataset.preview);
    if (!previewContainer) return;

    previewContainer.innerHTML = '';

    if (!input.files || input.files.length === 0) return;

    Array.from(input.files).forEach((file, index) => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            const item = document.createElement('div');
            item.className = 'preview-item';
            item.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
            `;
            previewContainer.appendChild(item);
        };
        reader.readAsDataURL(file);
    });

    // Afficher le nombre de fichiers selectionnes
    const label = input.closest('.file-upload').querySelector('.file-upload-label span:first-of-type');
    if (label && input.files.length > 0) {
        const originalText = label.dataset.original || label.textContent;
        label.dataset.original = originalText;
        label.textContent = `${input.files.length} fichier(s) selectionne(s)`;
        label.style.color = '#27ae60';
    }
}

function initDeleteConfirm() {
    document.querySelectorAll('[data-confirm]').forEach(element => {
        element.addEventListener('click', (e) => {
            const message = element.dataset.confirm || 'Etes-vous sur de vouloir supprimer cet element ?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
}

function initImagePreview() {
    const existingImages = document.querySelectorAll('.existing-image .remove-btn');
    existingImages.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            if (!confirm('Supprimer cette image ?')) return;

            const articleId = btn.dataset.articleId;
            const imageId = btn.dataset.imageId;

            try {
                const response = await fetch(`/TP_information_geurre/admins/articles/delete-image?article_id=${articleId}&image_id=${imageId}`);
                const data = await response.json();

                if (data.success) {
                    btn.closest('.preview-item').remove();
                } else {
                    alert('Erreur lors de la suppression');
                }
            } catch (error) {
                console.error(error);
                alert('Erreur lors de la suppression');
            }
        });
    });
}

function toggleStatus(articleId) {
    fetch(`/TP_information_geurre/admins/articles/toggle-status?id=${articleId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur lors du changement de statut');
            }
        })
        .catch(error => {
            console.error(error);
            alert('Erreur lors du changement de statut');
        });
}
