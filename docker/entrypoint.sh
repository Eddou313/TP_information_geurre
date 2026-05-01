#!/usr/bin/env sh
set -eu

UPLOADS_DIR="/var/www/html/uploads"
CONTENT_DIR="/var/www/html/uploads/content"

# Création des répertoires
mkdir -p "$CONTENT_DIR"

# Mise à jour des permissions pour Apache
chown -R www-data:www-data "$UPLOADS_DIR"
chmod -R 775 "$UPLOADS_DIR"

# --- AJOUT DE LA MIGRATION NEON ---
echo "Lancement de la migration de la base de données..."
# On utilise le chemin absolu pour être sûr
php /var/www/html/migrate.php --rebuild
echo "Migration terminée avec succès."
# ----------------------------------

# Lance Apache (la commande passée dans CMD)
exec "$@"