@extends('admin.layouts.app')
@section('page_title', __('Purchase Charges'))
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4 class="card-title">@lang('Purchase Charges Management')</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">@lang('Configure charges that will be applied to gold purchases such as GST, taxes, processing fees, etc.')</p>
                    
                    <!-- Add New Charge Form -->
                    <form action="{{ route('admin.purchase.charges.store') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="label">@lang('Charge Label')</label>
                                    <input type="text" name="label" id="label" class="form-control" placeholder="e.g., GST, Service Tax" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="type">@lang('Type')</label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="percentage">@lang('Percentage')</option>
                                        <option value="fixed">@lang('Fixed Amount')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="value">@lang('Value')</label>
                                    <input type="number" name="value" id="value" class="form-control" step="0.0001" min="0" placeholder="18 or 100" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="sort_order">@lang('Sort Order')</label>
                                    <input type="number" name="sort_order" id="sort_order" class="form-control" min="0" value="0" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="status">@lang('Status')</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1">@lang('Active')</option>
                                        <option value="0">@lang('Inactive')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control">@lang('Add')</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Existing Charges Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>@lang('Label')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Value')</th>
                                    <th>@lang('Sort Order')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($charges as $charge)
                                <tr>
                                    <td>{{ $charge->label }}</td>
                                    <td>
                                        <span class="badge badge-{{ $charge->type == 'percentage' ? 'info' : 'warning' }}">
                                            {{ ucfirst($charge->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($charge->type == 'percentage')
                                            {{ $charge->value }}%
                                        @else
                                            {{ getAmount($charge->value) }}
                                        @endif
                                    </td>
                                    <td>{{ $charge->sort_order }}</td>
                                    <td>
                                        <span class="badge badge-{{ $charge->status ? 'success' : 'danger' }}">
                                            {{ $charge->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="editCharge({{ $charge->id }}, '{{ $charge->label }}', '{{ $charge->type }}', {{ $charge->value }}, {{ $charge->sort_order }}, {{ $charge->status }})">
                                            @lang('Edit')
                                        </button>
                                        <a href="{{ route('admin.purchase.charges.destroy', $charge->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            @lang('Delete')
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">@lang('No purchase charges configured yet.')</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Purchase Charge')</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_label">@lang('Charge Label')</label>
                        <input type="text" name="label" id="edit_label" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_type">@lang('Type')</label>
                        <select name="type" id="edit_type" class="form-control" required>
                            <option value="percentage">@lang('Percentage')</option>
                            <option value="fixed">@lang('Fixed Amount')</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_value">@lang('Value')</label>
                        <input type="number" name="value" id="edit_value" class="form-control" step="0.0001" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_sort_order">@lang('Sort Order')</label>
                        <input type="number" name="sort_order" id="edit_sort_order" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">@lang('Status')</label>
                        <select name="status" id="edit_status" class="form-control" required>
                            <option value="1">@lang('Active')</option>
                            <option value="0">@lang('Inactive')</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</button>
                    <button type="submit" class="btn btn-primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
function editCharge(id, label, type, value, sortOrder, status) {
    document.getElementById('editForm').action = '{{ route("admin.purchase.charges.update", ":id") }}'.replace(':id', id);
    document.getElementById('edit_label').value = label;
    document.getElementById('edit_type').value = type;
    document.getElementById('edit_value').value = value;
    document.getElementById('edit_sort_order').value = sortOrder;
    document.getElementById('edit_status').value = status;
    $('#editModal').modal('show');
}
</script>
@endpush 