@extends('admin.layouts.app')

@section('title', 'Manual RGP Credit')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-sm mb-2 mb-sm-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-no-gutter">
                                <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.security.index') }}">Security</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manual RGP Credit</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manual RGP Credit</h3>
                    <p class="card-subtitle text-muted mb-0">Manually credit RGP points to a user's upline chain. Enter a username to find all parents up to the root.</p>
                </div>
                <div class="card-body">
                    <form id="findUserForm" class="form-inline mb-4">
                        <div class="form-group mr-3">
                            <label for="username" class="mr-2 font-weight-bold">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required placeholder="Enter username to search..." style="min-width: 200px;">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2" id="searchBtn">
                            <span class="btn-text">Find User</span>
                            <span class="btn-loading" style="display:none;">
                                <i class="fa fa-spinner fa-spin"></i> Searching...
                            </span>
                        </button>
                        <button type="button" class="btn btn-secondary" id="clearBtn">
                            <i class="fa fa-times"></i> Clear
                        </button>
                    </form>
                    
                    <div id="parentChainSection" style="display:none;">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i>
                            <strong>Parent Chain Found:</strong> Below are all the parents in the upline chain who will receive RGP points.
                        </div>
                        
                        <h5>Parent Chain</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>User ID</th>
                                        <th>Username</th>
                                        <th>Full Name</th>
                                        <th>Referral Node</th>
                                    </tr>
                                </thead>
                                <tbody id="parentChainTable"></tbody>
                            </table>
                        </div>
                        
                        <form id="creditRgpForm" class="form-inline mt-4">
                            <div class="form-group mr-3">
                                <label for="points" class="mr-2 font-weight-bold">RGP Points to Credit:</label>
                                <input type="number" step="0.01" min="0.01" class="form-control" id="points" name="points" required placeholder="Enter points amount">
                            </div>
                            <button type="submit" class="btn btn-success" id="creditBtn">
                                <span class="btn-text">Credit RGP</span>
                                <span class="btn-loading" style="display:none;">
                                    <i class="fa fa-spinner fa-spin"></i> Processing...
                                </span>
                            </button>
                        </form>
                    </div>
                    
                    <div id="creditedSummary" class="mt-4" style="display:none;"></div>
                    <div id="manualRgpError" class="alert alert-danger mt-3" style="display:none;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
    var searchTimeout;
    var usernameInput = $('#username');
    var searchBtn = $('#searchBtn');
    var creditBtn = $('#creditBtn');
    var clearBtn = $('#clearBtn');
    
    // Function to show/hide loading state
    function setLoading(button, isLoading) {
        if (isLoading) {
            button.find('.btn-text').hide();
            button.find('.btn-loading').show();
            button.prop('disabled', true);
        } else {
            button.find('.btn-text').show();
            button.find('.btn-loading').hide();
            button.prop('disabled', false);
        }
    }
    
    // Function to perform the search
    function performSearch() {
        var username = usernameInput.val().trim();
        if (!username) {
            $('#parentChainSection').hide();
            $('#manualRgpError').hide();
            return;
        }
        
        $('#manualRgpError').hide();
        $('#creditedSummary').hide();
        setLoading(searchBtn, true);
        
        $.post({
            url: '{{ route('admin.security.manual_rgp_credit.find_parents') }}',
            data: { username: username, _token: '{{ csrf_token() }}' },
            success: function(res) {
                setLoading(searchBtn, false);
                if (res.parents && res.parents.length > 0) {
                    var rows = '';
                    res.parents.forEach(function(parent, idx) {
                        rows += `<tr><td>${idx+1}</td><td>${parent.id}</td><td><strong>${parent.username}</strong></td><td>${parent.fullname}</td><td><span class="badge ${parent.referral_node === 'left' ? 'bg-primary text-white' : 'bg-success text-white'}">${parent.referral_node || 'N/A'}</span></td></tr>`;
                    });
                    $('#parentChainTable').html(rows);
                    $('#parentChainSection').show();
                } else {
                    $('#parentChainTable').html('<tr><td colspan="5" class="text-center text-muted">No parent chain found for this user.</td></tr>');
                    $('#parentChainSection').show();
                }
            },
            error: function(xhr) {
                setLoading(searchBtn, false);
                $('#manualRgpError').text(xhr.responseJSON?.message || 'Error finding user.').show();
                $('#parentChainSection').hide();
            }
        });
    }
    
    // Check for username in query parameter on page load
    function checkQueryParameter() {
        var urlParams = new URLSearchParams(window.location.search);
        var usernameParam = urlParams.get('username');
        if (usernameParam) {
            usernameInput.val(usernameParam);
            // Trigger search after a short delay to ensure DOM is ready
            setTimeout(function() {
                performSearch();
            }, 100);
        }
    }
    
    // Real-time search as user types (with debouncing)
    usernameInput.on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            performSearch();
        }, 500); // Wait 500ms after user stops typing
    });
    
    // Form submit handler
    $('#findUserForm').on('submit', function(e) {
        e.preventDefault();
        performSearch();
    });

    // Clear button handler
    clearBtn.on('click', function() {
        usernameInput.val('');
        $('#parentChainSection').hide();
        $('#creditedSummary').hide();
        $('#manualRgpError').hide();
        $('#points').val('');
    });
    
    // Credit RGP
    $('#creditRgpForm').on('submit', function(e) {
        e.preventDefault();
        $('#manualRgpError').hide();
        var username = usernameInput.val();
        var points = $('#points').val();
        
        if (!username || !points) {
            $('#manualRgpError').text('Please enter both username and points.').show();
            return;
        }
        
        setLoading(creditBtn, true);
        
        $.post({
            url: '{{ route('admin.security.manual_rgp_credit.credit') }}',
            data: { username: username, points: points, _token: '{{ csrf_token() }}' },
            success: function(res) {
                setLoading(creditBtn, false);
                if (res.credited && res.credited.length > 0) {
                    var html = '<div class="alert alert-success"><h5><i class="fa fa-check-circle"></i> Credited Successfully!</h5><ul class="mb-0">';
                    res.credited.forEach(function(item) {
                        html += `<li><strong>${item.fullname}</strong> (ID: ${item.id}, Username: ${item.username}) - <span class="badge bg-success">${item.points} points</span> to <span class="badge ${item.side === 'left' ? 'bg-primary text-white' : 'bg-success text-white'}">${item.side}</span> side</li>`;
                    });
                    html += '</ul></div>';
                    $('#creditedSummary').html(html).show();
                    
                    // Clear the form after successful credit
                    $('#points').val('');
                } else {
                    $('#creditedSummary').html('<div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> No users credited.</div>').show();
                }
            },
            error: function(xhr) {
                setLoading(creditBtn, false);
                $('#manualRgpError').text(xhr.responseJSON?.message || 'Error crediting RGP.').show();
            }
        });
    });
    
    // Initialize on page load
    checkQueryParameter();
});
</script>
@endpush 