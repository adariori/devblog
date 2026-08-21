<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>{{ $titre ?? 'DevBlog' }}</title>
</head>

<body>
    <header>
        <h2>📝 DevBlog</h2>
        <nav>
            <a href="/articles">Articles</a> |
            <a href="/contact">Contact</a> |
            <a href="/a-propos">À propos</a>
        </nav>
        <hr>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <hr>
        <p>© 2026 DevBlog — fait avec Laravel.</p>
    </footer>
</body>

</html>
