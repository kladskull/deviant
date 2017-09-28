{extends file='__creds_layout.tpl'}
{block name=title}Account Registration{/block}
{block name=head}
    <link href="/css/register.css" rel="stylesheet">
{/block}
{block name=body}
    <div style="max-width: 660px;padding: 15px;margin: 0 auto;">
        <h2 class="form-register-heading">Welcome</h2>
        <p>
            Creating an account will register you, however an
            administrator will have to unlock your account.
        </p>
        <small>
            <p>
                <strong>We HIGHLY recommend that you use an auto generated
                    password from 1Password that is a minimum of 32 characters
                    long, contains at least 2 digits, and contains at least
                    2 symbols.
                </strong>
            </p>
        </small>
        {if isset($errorMessage)}
            <div class="alert alert-danger" role="alert">
                {$errorMessage}
            </div>
        {/if}
    </div>
    <form class="form-register" method="post" action="/signup">
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required
               autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password"
               required>
        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control"
               placeholder="Confirm Password"
               required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
    </form>
{/block}