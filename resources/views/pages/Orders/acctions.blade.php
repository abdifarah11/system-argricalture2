<div class="dropdown">
    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-gear"></i> Actions
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <!-- View Action -->
        <li>
            <a class="dropdown-item" href="{{ route('orders.show', $row->id) }}">
                <i class="bi bi-eye text-info me-2"></i>View Details
            </a>
        </li>
        
        <!-- Edit Action -->
        <li>
            <a class="dropdown-item" href="{{ route('orders.edit', $row->id) }}">
                <i class="bi bi-pencil-square text-primary me-2"></i>Edit Order
            </a>
        </li>
        
        <li><hr class="dropdown-divider"></li>
        
        <!-- Delete Action -->
        <li>
            <form action="{{ route('orders.destroy', $row->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item text-danger" 
                        onclick="return confirm('Are you sure you want to delete this order?')">
                    <i class="bi bi-trash3 me-2"></i>Delete Order
                </button>
            </form>
        </li>
    </ul>
</div>