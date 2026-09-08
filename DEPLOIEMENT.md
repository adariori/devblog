# Checklist de mise en production — DevBlog

À parcourir **dans l'ordre** avant chaque mise en ligne. Rien ne part en prod tant que la suite de tests n'est pas verte.

---

## 0. Avant de pousser

- [ ] `php artisan test` → **tout vert**
- [ ] `./vendor/bin/pint` → code formaté
- [ ] `git status` propre, branche à jour, tag de version posé (`git tag vX.Y.Z`)
- [ ] Revue du `git diff` avec `main` : aucun `dd()`, `dump()`, `var_dump()`, `Log::debug()` oublié
- [ ] Aucun secret commité (`.env` bien dans `.gitignore`, chercher clés/tokens en dur)

## 1. Sécurité (règles d'or du Module 14)

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false` ← **le plus important** (sinon fuite de code + config sur chaque erreur)
- [ ] `APP_KEY` généré et **différent** de celui de dev (`php artisan key:generate`)
- [ ] `APP_URL` = la vraie URL https
- [ ] **HTTPS** actif (certificat valide) + redirection http → https
- [ ] `SESSION_SECURE_COOKIE=true`, cookies `HttpOnly` / `SameSite`
- [ ] Mots de passe hachés (déjà le cas : `password` cast `hashed`) — jamais en clair
- [ ] Middlewares en place : `auth` sur les routes sensibles, `admin` sur `/admin/*`, `auth:sanctum` sur l'API d'écriture
- [ ] Policies actives : `ArticlePolicy` (propriétaire), `CommentPolicy` (modérateur)
- [ ] Validation systématique via Form Requests (`StoreArticleRequest`, `UpdateArticleRequest`)
- [ ] Rate limiting sur `/login` et `/api/login` (brute force)
- [ ] Dépendances à jour : `composer audit`, `npm audit`
- [ ] Comptes de test / seeders de démo **non exécutés** en prod
- [ ] Le user `admin@devblog.test` du middleware : remplacer par un vrai mécanisme (colonne `is_admin` ou rôle) avant la vraie prod

## 2. Base de données

- [ ] `DB_CONNECTION` = base de prod (MySQL/PostgreSQL), **pas SQLite**, identifiants dédiés à droits limités
- [ ] Sauvegarde de la base **avant** migration
- [ ] `php artisan migrate --force` (le `--force` est obligatoire en prod, mode non interactif)
- [ ] Vérifier qu'aucune migration ne contient de `migrate:fresh` / `dropColumn` destructeur non voulu
- [ ] Toutes les migrations ont un `down()` correct (rollback possible)
- [ ] Pas de `Model::unguard()` ; `$fillable` à jour (`cover_path` inclus)
- [ ] Index sur les colonnes filtrées/jointes (`articles.user_id`, `comments.article_id`, clés des tables pivot)
- [ ] Politique de rétention / purge des `personal_access_tokens` et `failed_jobs`

## 3. Fichiers et stockage

- [ ] `php artisan storage:link` rejoué sur le serveur (lien `public/storage` → `storage/app/public`)
- [ ] Dossier `storage/` et `bootstrap/cache/` accessibles en écriture par le serveur web
- [ ] Uploads (`covers/`) sur un **disque persistant** ou S3 — pas sur un système de fichiers éphémère (sinon images perdues à chaque déploiement)
- [ ] `FILESYSTEM_DISK` configuré (`public` en local, `s3` conseillé en prod)
- [ ] Taille/type des uploads validés (`nullable|image|max:2048` — OK dans les Form Requests)
- [ ] Permissions fichiers : pas de `777`, propriétaire = utilisateur du serveur web
- [ ] `.env`, `.git/`, `tests/`, `storage/logs/` **non servis** publiquement (racine web = `public/` uniquement)

## 4. Mail et files d'attente

- [ ] `MAIL_MAILER` = vrai service (SMTP / Mailgun / SES), **pas `log`**
- [ ] Adresse d'expédition (`MAIL_FROM_ADDRESS`) valide, SPF/DKIM configurés
- [ ] `QUEUE_CONNECTION=database` (ou redis)
- [ ] Worker lancé et supervisé en permanence : `php artisan queue:work` sous **Supervisor** / systemd (redémarrage auto)
- [ ] `php artisan queue:restart` inclus dans le script de déploiement (recharge le code du worker)
- [ ] Table `failed_jobs` surveillée (alerte si elle grossit)
- [ ] Scheduler actif si besoin : entrée cron `* * * * * php artisan schedule:run`

## 5. Performance

- [ ] `composer install --no-dev --optimize-autoloader`
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`
- [ ] `php artisan event:cache` (si applicable)
- [ ] `npm ci && npm run build` (assets Vite compilés et versionnés)
- [ ] OPcache activé côté PHP
- [ ] Requêtes N+1 vérifiées : eager loading (`with('user', 'categories', 'tags', 'comments')`) sur les listes d'articles
- [ ] Pagination sur les listes longues (articles, commentaires) plutôt que `all()`
- [ ] Cache HTTP / CDN sur les assets statiques et images
- [ ] Gzip/Brotli activé sur le serveur web

## 6. Observabilité

- [ ] `LOG_CHANNEL` = `stack`/`daily` avec rotation ; niveau `error` en prod
- [ ] Remontée d'erreurs (Sentry / Flare / Bugsnag) branchée
- [ ] Route santé `/up` monitorée (uptime check externe)
- [ ] Sauvegardes automatiques de la base + du stockage, **restauration testée**

## 7. Après déploiement (fumée)

- [ ] Page d'accueil et `/articles` répondent en 200
- [ ] Inscription → e-mail de bienvenue reçu (worker OK)
- [ ] Connexion, création d'article avec image de couverture, édition, suppression
- [ ] `/admin/tableau-de-bord` : 403 pour un non-admin, 200 pour l'admin
- [ ] API : `POST /api/login` renvoie un token ; `POST /api/articles` refuse sans token (401) et accepte avec
- [ ] Une vraie 404 et une vraie 500 affichent une page propre (pas de stack trace)
- [ ] Plan de rollback prêt (image/commit précédent + restauration base)
