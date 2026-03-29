document.addEventListener('DOMContentLoaded', function() {
    initFileUpload();
    initDeleteConfirm();
    initImagePreview();
});

function initFileUpload() {
    const fileUploads = document.querySelectorAll('.file-upload');

    fileUploads.forEach(upload => {
        const input = upload.querySelector('input[type="file"]');
        const label = upload.querySelector('.file-upload-label');

        upload.addEventListener('click', () => input.click());

        upload.addEventListener('dragover', (e) => {
            e.preventDefault();
            upload.classList.add('dragover');
        });

        upload.addEventListener('dragleave', () => {
            upload.classList.remove('dragover');
        });

        upload.addEventListener('drop', (e) => {
            e.preventDefault();
            upload.classList.remove('dragover');
            input.files = e.dataTransfer.files;
            handleFileSelect(input);
        });

        input.addEventListener('change', () => handleFileSelect(input));
    });
}

function handleFileSelect(input) {
    const previewContainer = document.getElementById(input.dataset.preview);
    if (!previewContainer) return;

    previewContainer.innerHTML = '';

    Array.from(input.files).forEach((file, index) => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            const item = document.createElement('div');
            item.className = 'preview-item';
            item.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="remove-btn" onclick="removePreview(this, ${index})">&times;</button>
            `;
            previewContainer.appendChild(item);
        };
        reader.readAsDataURL(file);
    });
}

function removePreview(btn, index) {
    const item = btn.parentElement;
    item.remove();
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
                const response = await fetch(`delete_image.php?article_id=${articleId}&image_id=${imageId}`);
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
    fetch(`toggle_status.php?id=${articleId}`)
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
