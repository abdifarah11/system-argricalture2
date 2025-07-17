<a href="{{ route('payment_methods.edit', $row->id) }}" class="btn btn-sm btn-primary">
    <i class="bi bi-pencil-square"></i>
</a>

<form action="{{ route('payment_methods.delete', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
</form>
