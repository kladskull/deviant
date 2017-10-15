{extends file='__creds_layout.tpl'}
{block name=title}Login{/block}
{block name=head}
    <link href="/css/login.css" rel="stylesheet">
{/block}
{block name=body}
    {if isset($notifyMessage)}
        <div class="alert alert-success" role="alert">
            {$notifyMessage}
        </div>
    {/if}
    {if isset($errorMessage)}
        <div class="alert alert-danger" role="alert">
            {$errorMessage}
        </div>
    {/if}
    <form class="form-signin" method="post" action="/login">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required
               autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password"
               required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
{/block}