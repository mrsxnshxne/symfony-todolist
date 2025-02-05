CONTAINER_ID=$(docker compose ps -q www)

if [ -z "$CONTAINER_ID" ]; then
  echo "Erreur : le conteneur 'www' n'est pas en cours d'exécution."
  exit 1
fi

[ ! -d "./src/vendor" ] && mkdir -p ./../src/vendor
docker cp "$CONTAINER_ID:/var/www/vendor" ./../src

if [ $? -eq 0 ]; then
  echo "Le dossier 'vendor' a été synchronisé avec succès !"
else
  echo "Erreur lors de la synchronisation du dossier 'vendor'."
  exit 1
fi