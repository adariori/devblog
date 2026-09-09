# DevBlog

Application de blog développée avec **Laravel 13**, réalisée au fil d'un cours (Modules 1 à 14) : du CRUD de base jusqu'à l'API REST sécurisée, les tests automatisés et le déploiement continu.

**Démo en ligne** : https://devblog-fob3.onrender.com

---

## Stack technique

| Domaine | Outil |
|---|---|
| Framework | Laravel 13.8 (PHP 8.3+) |
| Base de données | SQLite en local · PostgreSQL en production |
| Authentification web | Laravel Breeze (sessions) |
| Authentification API | Laravel Sanctum (jetons Bearer) |
| Tests | Pest 5 |
| Front | Blade + Tailwind CSS + Vite |
| Conteneurisation | Docker (nginx + php-fpm) |
| Hébergement | Render (plan gratuit) |
| CI/CD | GitHub Actions → Render Deploy Hook |

---

## Fonctionnalités

- **Articles** : CRUD complet, image de couverture (upload), extrait automatique.
- **Catégories & tags** : relations plusieurs-à-plusieurs.
- **Commentaires** : ajout public, suppression réservée aux **modérateurs** (`users.is_moderator`).
- **Comptes utilisateurs** : inscription, connexion, mots de passe hachés, vérification e-mail.
- **E-mail de bienvenue** envoyé à l'inscription, **mis en file d'attente** (queue).
- **Autorisations** :
  - `ArticlePolicy` — on ne modifie/supprime que ses propres articles.
  - `CommentPolicy` — seul un modérateur supprime un commentaire.
  - Middleware maison `EnsureUserIsAdmin` (alias `admin`) pour la zone d'administration.
- **API REST** sécurisée par jetons (voir plus bas).

---

## Installation en local

Prérequis : PHP 8.3+, Composer, Node 20+, SQLite.

```bash
# 1. Dépendances
composer install
npm install

# 2. Environnement
cp .env.example .env
php artisan key:generate

# 3. Base de données (SQLite)
touch database/database.sqlite
php artisan migrate --seed

# 4. Lien de stockage (images)
php artisan storage:link

# 5. Lancer
npm run dev          # assets, dans un terminal
php artisan serve    # serveur, dans un autre
php artisan queue:work   # worker pour les e-mails, dans un troisième
```

Application sur http://127.0.0.1:8000.

---

## Tests

```bash
php artisan test
```

Suite Pest (29 tests) couvrant la création d'articles, la validation, la protection des routes par `auth`, et l'affichage public.

Style de code :

```bash
vendor/bin/pint
```

---

## API REST

Base : `/api`. Toujours envoyer l'en-tête `Accept: application/json`.

### Authentification

| Méthode | URL | Auth | Description |
|---|---|---|---|
| `POST` | `/api/login` | — | `email` + `password` → `{ "token": "..." }` |
| `POST` | `/api/logout` | Bearer | Détruit le jeton courant |

### Articles

| Méthode | URL | Auth | Description |
|---|---|---|---|
| `GET` | `/api/articles` | — | Liste |
| `GET` | `/api/articles/{id}` | — | Détail |
| `POST` | `/api/articles` | Bearer | Créer (`titre`, `contenu`) |
| `PUT` | `/api/articles/{id}` | Bearer | Modifier |
| `DELETE` | `/api/articles/{id}` | Bearer | Supprimer |

### Commentaires

| Méthode | URL | Auth | Description |
|---|---|---|---|
| `GET` | `/api/articles/{article}/comments` | — | Commentaires d'un article |
| `POST` | `/api/articles/{article}/comments` | Bearer | Ajouter (`auteur`, `contenu`) |

Exemple :

```bash
# Obtenir un jeton
curl -X POST https://devblog-fob3.onrender.com/api/login \
  -H "Accept: application/json" \
  -d "email=user@example.com&password=secret"

# Créer un article
curl -X POST https://devblog-fob3.onrender.com/api/articles \
  -H "Accept: application/json" \
  -H "Authorization: Bearer 1|xxxxxxxx" \
  -d "titre=Bonjour API&contenu=Premier article via l'API"
```

---

## Déploiement & CI/CD

### Conteneur

Le projet se déploie via `Dockerfile` (build multi-étages : assets Vite → dépendances Composer → image finale nginx + php-fpm 8.4). Au démarrage, `docker/entrypoint.sh` exécute `migrate --force`, `storage:link` puis met en cache config/routes/vues.

### Pipeline

`.github/workflows/ci.yml` :

1. **`test`** — sur chaque push et chaque pull request :
   - `composer install`
   - `php artisan test` (SQLite en mémoire)
   - `vendor/bin/pint --test` (informatif)
2. **`deploy`** — uniquement sur `main`, **si `test` a réussi** :
   - appelle le Deploy Hook de Render (secret `RENDER_DEPLOY_HOOK`)

L'auto-déploiement natif de Render est **désactivé** : c'est la CI qui pilote la mise en ligne. Un test qui échoue = pas de déploiement.

### Variables d'environnement en production

`APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY`, `APP_URL`,
`DB_CONNECTION=pgsql`, `DB_URL`,
`SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=sync`,
`LOG_CHANNEL=stderr`, `MAIL_MAILER=log`.

> Sur le plan gratuit Render, le disque est éphémère : les images de couverture uploadées sont perdues au redéploiement (à migrer vers un stockage S3/R2 pour une vraie prod), et il n'y a pas de worker de queue (`QUEUE_CONNECTION=sync`).

Checklist complète : voir [`DEPLOIEMENT.md`](DEPLOIEMENT.md).

---

## Structure

```
app/
├─ Http/Controllers/        # web : Article, Category, Comment, Admin...
│  └─ Api/                   # API : Article, Comment
├─ Http/Requests/            # validation (StoreArticleRequest...)
├─ Http/Resources/           # transformation JSON (ArticleResource, CommentResource)
├─ Http/Middleware/          # EnsureUserIsAdmin
├─ Mail/                     # WelcomeMail
├─ Models/                   # Article, Category, Tag, Comment, User
└─ Policies/                 # ArticlePolicy, CommentPolicy
database/
├─ migrations/
├─ factories/
└─ seeders/
docker/                      # nginx.conf, supervisord.conf, entrypoint.sh
routes/
├─ web.php
└─ api.php
tests/Feature/               # Pest
.github/workflows/ci.yml     # pipeline CI/CD
```
