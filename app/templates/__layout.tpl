<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>{block name=title}My Website{/block}</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/base-template.css" rel="stylesheet">
    {block name=head}{/block}
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">{block name=page_title}My Website{/block}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="nav navbar-nav mr-auto navbar-right">
            {if $loggedIn}
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Administration</a>
                    {if $admin}
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="/users">Users</a>
                        </div>
                    {/if}
                </li>
            {/if}
        </ul>
        <ul class="nav navbar-nav">
            {if $loggedIn}
                <form action="/logout" method="post">
                    <button type="submit" name="logout" value="logout" class="btn btn-dark">Logout</button>
                </form>
            {else}
                <a class="nav-link" href="/signup">Sign-up</a>
                <a class="nav-link" href="/login">Login</a>
            {/if}
        </ul>
    </div>
</nav>
{block name=body}{/block}
<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/ie10-viewport-bug-workaround.js"></script>
{block name=js}{/block}
</body>
</html>