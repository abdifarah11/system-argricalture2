<a href="{{ route('crops.show', $row->id) }}" class="btn btn-sm btn-info">View</a>
<a href="{{ route('crops.edit', $row->id) }}" class="btn btn-sm btn-warning">✏️</a>

<form action="{{ route('crops.delete', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
</form>
