@extends('admin.layouts.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $pageTitle }}</h4>
                        <div class="alert alert-info">
                            <p>These configs control the three circular progress indicators shown on user dashboards. You can customize both the display name and the value for each indicator. Values can be any text up to 10 characters.</p>
                            <p><strong>Tip:</strong> Add a percentage sign (%) at the end of a value (e.g., "75%") to display it as a filled circular progress indicator. Non-percentage values will be displayed with an empty ring.</p>
                        </div>
                        <h4 class="mb-4">Tile Values</h4>
                        <form action="{{ route('admin.configs.update') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="row mt-4">
                                    <div class="col-md-4 mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Config 1 <small class="text-muted">(Left Position)</small></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="config_1_name">Display Name</label>
                                                    <input type="text" class="form-control" name="config_1_name" value="{{ $configs[0]->display_name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="config_1">Value</label>
                                                    <input type="text" class="form-control" name="config_1" value="{{ $configs[0]->value }}" required maxlength="10">
                                                    <small class="text-muted">Add % at the end to show as filled progress circle</small>
                                                    @error('config_1')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Config 2 <small class="text-muted">(Middle Position)</small></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="config_2_name">Display Name</label>
                                                    <input type="text" class="form-control" name="config_2_name" value="{{ $configs[1]->display_name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="config_2">Value</label>
                                                    <input type="text" class="form-control" name="config_2" value="{{ $configs[1]->value }}" required maxlength="10">
                                                    <small class="text-muted">Add % at the end to show as filled progress circle</small>
                                                    @error('config_2')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Config 3 <small class="text-muted">(Right Position)</small></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="config_3_name">Display Name</label>
                                                    <input type="text" class="form-control" name="config_3_name" value="{{ $configs[2]->display_name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="config_3">Value</label>
                                                    <input type="text" class="form-control" name="config_3" value="{{ $configs[2]->value }}" required maxlength="10">
                                                    <small class="text-muted">Add % at the end to show as filled progress circle</small>
                                                    @error('config_3')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                        <hr>
                        <h4 class="mb-4">Announcements</h4>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('admin.announcements.store') }}" method="POST" class="mb-4">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="text" class="form-control mb-2" placeholder="Announcement text" required>
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-control mb-2">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="start_date" class="form-control mb-2" placeholder="Start date">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="end_date" class="form-control mb-2" placeholder="End date">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Add Announcement</button>
                        </form>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Text</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Announcement::orderByDesc('created_at')->get() as $announcement)
                                    <tr>
                                        <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST">
                                            @csrf
                                            <td><input type="text" name="text" value="{{ $announcement->text }}" class="form-control" required></td>
                                            <td>
                                                <select name="status" class="form-control">
                                                    <option value="active" @if($announcement->status=='active') selected @endif>Active</option>
                                                    <option value="inactive" @if($announcement->status=='inactive') selected @endif>Inactive</option>
                                                </select>
                                            </td>
                                            <td><input type="date" name="start_date" value="{{ $announcement->start_date }}" class="form-control"></td>
                                            <td><input type="date" name="end_date" value="{{ $announcement->end_date }}" class="form-control"></td>
                                            <td>
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                        </form>
                                        <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this announcement?')">Delete</button>
                                        </form>
                                            </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 