/* ───────────── resources/views/pages/orders/partials/actions.blade.php ───────────── */
<div class="btn-group" role="group">
    <a href="{{ route('orders.edit', $row->id) }}" class="btn btn-sm btn-warning">Edit</a>
    <form action="{{ route('orders.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
    </form>
</div>
