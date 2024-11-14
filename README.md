
# Projet Laravel API - Gestion de profils

Ce projet est une API REST développée en Laravel permettant de gérer des profils. Il inclut des fonctionnalités de création, modification, suppression de profils et une route publique pour récupérer les profils actifs.

---

## 🏁  Initialisation du projet

Suivez les étapes ci-dessous pour configurer et lancer le projet en local.

### Étape 1 : Copier le fichier d'environnement

1. Dupliquez le fichier `.env.example` en `.env`.
   ```bash
   cp .env.example .env
   ```
2. Ouvrez le fichier `.env` et renseignez les informations de connexion à votre base de données :
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nom_de_votre_base
   DB_USERNAME=nom_utilisateur
   DB_PASSWORD=mot_de_passe
   ```

### Étape 2 : Générer la clé de l'application

Exécutez la commande suivante pour générer une clé unique pour l'application :

```bash
php artisan key:generate
```

### Étape 3 : Créer le lien symbolique pour le stockage

Pour permettre l'accès aux fichiers téléchargés via le stockage public, créez un lien symbolique entre le répertoire de stockage et le répertoire public :

```bash
php artisan storage:link
```

### Étape 4 : Lancer les migrations

Créez les tables nécessaires en exécutant les migrations :

```bash
php artisan migrate
```

### Étape 5 : Seed de la base de données

Pour générer les données de base, y compris un utilisateur administrateur par défaut, lancez la commande de seeding :

```bash
php artisan db:seed
```

Un utilisateur administrateur par défaut sera créé avec les informations suivantes :
- **Email** : `admin@admin.com`
- **Mot de passe** : `password`

Vous pouvez utiliser cet utilisateur pour vous connecter et récupérer un token d'authentification.

---

## ℹ️  Informations sur le projet

### ⚙️ Fonctionnalités

L'API permet de :
- Créer, mettre à jour, et supprimer des profils (uniquement pour les administrateurs authentifiés).
- Récupérer les profils ayant le statut "actif" via une route publique.

### 🔐  Authentification

Pour effectuer des opérations de modification ou de suppression sur les profils, vous devez être authentifié en tant qu'administrateur.

- **Route de connexion** : `/api/login`
    - **Méthode** : POST
    - **Paramètres** :
        - `email` : l'email de l'administrateur (par défaut `admin@admin.com`)
        - `password` : le mot de passe (par défaut `password`)
    - **Exemple de réponse** :
      ```json
      {
          "token": "votre-token"
      }
      ```

Utilisez le token reçu dans l'en-tête `Authorization` de vos requêtes pour vous authentifier :
```
Authorization: Bearer votre-token
```

### 📄 Documentation de l'API

La documentation complète de l'API est disponible à l'URL suivante :
```
/docs/api
```

Vous retrouverez aussi un export d'une collection Insomnia dans les fichiers du projet :
```
storage/api/Insomnia_2024-11-14.json
```

---

## 🧪 Tests

Le projet inclut des tests pour valider les principales fonctionnalités de l'API. Pour exécuter les tests, utilisez la commande suivante :

```bash
php artisan test
```

---

## 🙍‍♂️ Auteur

Ce projet a été développé par Guillaume Ventura dans le cadre du test demandé par HelloCSE.
