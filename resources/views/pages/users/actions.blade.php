<a href="{{ route('users.edit', $row) }}" class="btn btn-sm btn-outline-primary me-1">
    <i class="bi bi-pencil-square"></i>
</a>

<!-- Change Password Button -->
<a href="{{ route('users.changePasswordForm', $row) }}" class="btn btn-sm btn-outline-warning me-1">
    <i class="bi bi-key-fill"></i>
</a>

<form action="{{ route('users.delete', $row) }}" method="POST" class="d-inline">
    @csrf 
    @method('DELETE')
    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure to delete this user?')">
        <i class="bi bi-trash3"></i>
    </button>
</form>
