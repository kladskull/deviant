{extends file='__layout.tpl'}
{block name=head}{/block}
{block name=body}

    <div class="container">
        <div class="">
            <h4>API Keys</h4>
            <p class="lead">
                Manage your API Keys.
            </p>

            <div style="margin-bottom: 15px;" class="container text-right">
                <button class="btn btn-primary" id="create">Create New API Key</button>
            </div>
            <div id="tableRecords">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Description</th>
                        <th>Locked</th>
                        <th>Access ID</th>
                        <th>Secret Key</th>
                        <th>Created</th>
                        <th>Last Used</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$apiRecords item=apiRecord}
                        {if $apiRecord['locked']}
                            <tr class="table-secondary">
                                {else}
                            <tr>
                        {/if}
                        <td>{$apiRecord['description']}</td>
                        <td align="center">
                            {if $apiRecord['locked']}
                                Yes
                            {else}
                                No
                            {/if}
                        </td>
                        <td>{$apiRecord['access_id']}</td>
                        <td>********************</td>
                        <td>{$apiRecord['date_created']}</td>
                        <td>{$apiRecord['last_used']}</td>
                        <td align="center">
                            <div class="container">
                                <div class="row">
                                    <div style="padding-right: 5px;">
                                        <form method="post" action="/users">
                                            {if $apiRecord['locked'] == 0}
                                                <input type="hidden" id="lock" name="lock"
                                                       value="lock-{$apiRecord['id']}">
                                                <input type="submit" class="btn btn-danger" value="Lock">
                                            {else}
                                                <input type="hidden" id="lock" name="lock"
                                                       value="unlock-{$apiRecord['id']}">
                                                <input type="submit" class="btn btn-dark" value="Unlock">
                                            {/if}
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                        </tr>
                        {foreachelse}
                        <tr>
                            <td colspan="6" align="center">
                                No API Keys.
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
{/block}
{block name=js}
    <script>
        $("#create").click(function () {
            //$(this).slideUp();
        });
    </script>
{/block}