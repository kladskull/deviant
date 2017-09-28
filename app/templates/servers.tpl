<table id="table-servers" class="table table-bordered">
    <thead>
    <tr>
        <th>Server Name</th>
        <th>Status</th>
        <th>Memory</th>
        <th>CPU Count</th>
        <th>Disk Size</th>
        <th>Zone</th>
        <th>Public IP</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$servers item=server}
        {if isset($stored_data[$server['system_id']])}
            <tr id="server-row-{counter}" class="table-success">
                {else}
            <tr id="server-row-{counter}">
        {/if}
        <td id="searchField"
            hidden="true">{$server['hostname']} {$server['status']} {$server['memory'] / 1024} {$server['cpu_count']} {$server['disk_size']} {$server['zone']} {$server['public_ip']}</td>
        <td id="hostname">{$server['hostname']}</td>
        <td id="status">{$server['status']}</td>
        <td id="memory">{$server['memory'] / 1024}</td>
        <td id="cpu">{$server['cpu_count']}</td>
        <td id="disk">{$server['disk_size']}</td>
        <td id="zone">{$server['zone']}</td>
        <td id="ip">{$server['public_ip']}</td>
        <td id="action" align="center">
        {if isset($stored_data[$server['system_id']])}
            <button id="{$server['system_id']}" type="button" class="toggle btn btn-danger">
                Remove
            </button>

        {else}
            <button id="{$server['system_id']}" type="button" class="toggle btn btn-secondary">
                Select
            </button>

        {/if}
        </td>
        </tr>
    {/foreach}
    </tbody>
</table>
