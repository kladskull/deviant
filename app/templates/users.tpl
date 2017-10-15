{extends file='__layout.tpl'}
{block name=head}{/block}
{block name=body}
    <div class="container">
        <div class="">
            <h4>Users</h4>
            <p class="lead">
                Administer users here.
            </p>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Email Address</th>
                    <th>Locked</th>
                    <th>Administrator</th>
                    <th>Stored Keys</th>
                    <th>Storage Space</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$users item=user}
                    {if $user['locked']}
                        <tr class="table-secondary">
                            {else}
                        <tr>
                    {/if}
                    <td>{$user['email_address']}</td>
                    <td align="center">
                        {if $user['locked']}
                            Yes
                        {else}
                            No
                        {/if}
                    </td>
                    <td align="center">
                        {if $user['admin']}
                            Yes
                        {else}
                            No
                        {/if}
                    </td>
                    <td align="right">0</td>
                    <td align="right">0 KB</td>
                    <td align="center">
                        <div class="container">
                            <div class="row">
                                {if null !== $currentUser && $user['id'] !== $currentUser->id}
                                    <div style="padding-right: 5px;">
                                        <form method="post" action="/users">
                                            {if $user['locked'] == 0}
                                                <input type="hidden" id="lock" name="lock" value="lock-{$user['id']}">
                                                <input type="submit" class="btn btn-danger" value="Lock">
                                            {else}
                                                <input type="hidden" id="lock" name="lock" value="unlock-{$user['id']}">
                                                <input type="submit" class="btn btn-dark" value="Unlock">
                                            {/if}
                                        </form>
                                    </div>
                                    <div style="padding-right: 5px;">
                                        <form method="post" action="/users">
                                            {if $user['admin'] == 0}
                                                <input type="hidden" id="admin" name="admin"
                                                       value="admin-{$user['id']}">
                                                <input type="submit" class="btn btn-warning" value="+ Admin">
                                            {else}
                                                <input type="hidden" id="admin" name="admin"
                                                       value="unadmin-{$user['id']}">
                                                <input type="submit" class="btn btn-danger" value="- Admin">
                                            {/if}
                                        </form>
                                    </div>
                                    `
                                {/if}
                            </div>
                        </div>
                    </td>
                    </tr>
                    {foreachelse}
                    <tr>

                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
{/block}
