<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('code') — DevBlog</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500|fraunces:600,700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fafaf9;
            color: #3f3f46;
            font-family: Figtree, ui-sans-serif, system-ui, sans-serif;
            padding: 2rem;
        }
        .box { max-width: 32rem; text-align: center; }
        .code {
            font-family: Fraunces, Georgia, serif;
            font-weight: 700;
            font-size: clamp(4rem, 18vw, 8rem);
            line-height: 1;
            color: #18181b;
            letter-spacing: -0.03em;
        }
        .code span { color: #ea580c; }
        h1 {
            font-family: Fraunces, Georgia, serif;
            font-weight: 600;
            font-size: 1.5rem;
            color: #18181b;
            margin: 1rem 0 0.5rem;
        }
        p { margin: 0 0 1.75rem; color: #52525b; }
        a.home {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #ea580c;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.6rem 1.1rem;
            border-radius: 0.5rem;
        }
        a.home:hover { background: #c2410c; }
    </style>
</head>

<body>
    <div class="box">
        <div class="code">@yield('code')<span>.</span></div>
        <h1>@yield('title')</h1>
        <p>@yield('message')</p>
        <a class="home" href="{{ url('/articles') }}">← Retour aux articles</a>
    </div>
</body>

</html>
