<!-- View Button -->
<a href="{{ route('crops.show', $row->id) }}" class="btn btn-sm btn-info">
    <i class="bi bi-eye"></i> 
</a>

<!-- Edit Button -->
<a href="{{ route('crops.edit', $row->id) }}" class="btn btn-sm btn-outline-primary me-1">
    <i class="bi bi-pencil-square"></i> 
</a>

<!-- Delete Button -->
<form action="{{ route('crops.delete', $row->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this crop?')">
        <i class="bi bi-trash3"></i> 
    </button>
</form>






