@extends('admin.layouts.app')
@section('title')
    @lang('RGP Tree')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">@lang('RGP Tree')</h5>
                        <div class="d-flex">
                            <a href="{{ route('admin.rgp.tree.visual', request()->only('username')) }}" class="btn btn-info me-3">
                                <i class="fa fa-sitemap"></i> @lang('Visual Tree View')
                            </a>
                            <div class="search-box">
                                <form action="{{ route('admin.rgp.tree') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" name="username" class="form-control" placeholder="@lang('Search by username')" value="{{ request()->username }}">
                                        <button class="btn btn-primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="tree-container">
                            <!-- Parent Navigation -->
                            @if($parent)
                                <div class="text-center mb-4">
                                    <a href="{{ route('admin.rgp.tree', ['username' => $parent->username]) }}" class="btn btn-outline-primary">
                                        <i class="fa fa-arrow-up"></i> @lang('Go to Parent') ({{ $parent->username }})
                                    </a>
                                </div>
                            @endif

                            <!-- Current User Node -->
                            <div class="tree">
                                <div class="node main-node" id="node-{{ $user->id }}">
                                    <div class="node-content">
                                        <div class="user-avatar">
                                            <img src="{{ $user->profilePicture() }}" alt="{{ $user->username }}" class="avatar-img">
                                        </div>
                                        <div class="user-info">
                                            <h5>{{ $user->username }}</h5>
                                            <p>{{ $user->fullname }}</p>
                                            <div class="rgp-info">
                                                <span class="badge bg-primary">@lang('Left'): {{ $user->rgp_l }}</span>
                                                <span class="badge bg-success">@lang('Right'): {{ $user->rgp_r }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tree-branches">
                                    <div class="branch left-branch"></div>
                                    <div class="branch right-branch"></div>
                                </div>

                                <div class="tree-children">
                                    <!-- Left Child -->
                                    <div class="child left-child">
                                        @if($leftChild)
                                            <div class="node child-node" id="node-{{ $leftChild->id }}">
                                                <div class="node-content">
                                                    <div class="user-avatar">
                                                        <img src="{{ $leftChild->profilePicture() }}" alt="{{ $leftChild->username }}" class="avatar-img">
                                                    </div>
                                                    <div class="user-info">
                                                        <h5>{{ $leftChild->username }}</h5>
                                                        <p>{{ $leftChild->fullname }}</p>
                                                        <div class="rgp-info">
                                                            <span class="badge bg-primary">@lang('Left'): {{ $leftChild->rgp_l }}</span>
                                                            <span class="badge bg-success">@lang('Right'): {{ $leftChild->rgp_r }}</span>
                                                        </div>
                                                        <a href="{{ route('admin.rgp.tree', ['username' => $leftChild->username]) }}" class="btn btn-sm btn-primary mt-2">@lang('View')</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="node empty-node">
                                                <div class="node-content">
                                                    <div class="user-info">
                                                        <h5>@lang('Empty Position')</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Right Child -->
                                    <div class="child right-child">
                                        @if($rightChild)
                                            <div class="node child-node" id="node-{{ $rightChild->id }}">
                                                <div class="node-content">
                                                    <div class="user-avatar">
                                                        <img src="{{ $rightChild->profilePicture() }}" alt="{{ $rightChild->username }}" class="avatar-img">
                                                    </div>
                                                    <div class="user-info">
                                                        <h5>{{ $rightChild->username }}</h5>
                                                        <p>{{ $rightChild->fullname }}</p>
                                                        <div class="rgp-info">
                                                            <span class="badge bg-primary">@lang('Left'): {{ $rightChild->rgp_l }}</span>
                                                            <span class="badge bg-success">@lang('Right'): {{ $rightChild->rgp_r }}</span>
                                                        </div>
                                                        <a href="{{ route('admin.rgp.tree', ['username' => $rightChild->username]) }}" class="btn btn-sm btn-primary mt-2">@lang('View')</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="node empty-node">
                                                <div class="node-content">
                                                    <div class="user-info">
                                                        <h5>@lang('Empty Position')</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Tree Stats -->
                            <div class="tree-stats mt-5">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>@lang('Tree Statistics')</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="stat-item">
                                                    <h6>@lang('Left RGP Points')</h6>
                                                    <h3>{{ $user->rgp_l }}</h3>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="stat-item">
                                                    <h6>@lang('Right RGP Points')</h6>
                                                    <h3>{{ $user->rgp_r }}</h3>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="stat-item">
                                                    <h6>@lang('Matching Points')</h6>
                                                    <h3>{{ $user->rgp_pair_matching }}</h3>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="stat-item">
                                                    <h6>@lang('Difference')</h6>
                                                    <h3>{{ abs($user->rgp_l - $user->rgp_r) }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<style>
    .tree-container {
        width: 100%;
        overflow-x: auto;
    }
    
    .tree {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 800px;
        margin: 0 auto;
    }
    
    .node {
        width: 220px;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        background-color: #fff;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .node:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        transform: translateY(-3px);
    }
    
    .main-node {
        border: 2px solid #3498db;
    }
    
    .child-node {
        border: 1px solid #ddd;
    }
    
    .empty-node {
        border: 1px dashed #ccc;
        background-color: #f9f9f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
    }
    
    .node-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .user-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 10px;
        border: 2px solid #3498db;
    }
    
    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .user-info h5 {
        margin-bottom: 5px;
        font-size: 16px;
    }
    
    .user-info p {
        margin-bottom: 8px;
        color: #666;
        font-size: 14px;
    }
    
    .rgp-info {
        margin-top: 5px;
    }
    
    .tree-branches {
        display: flex;
        width: 80%;
        position: relative;
        height: 40px;
    }
    
    .branch {
        flex: 1;
        position: relative;
    }
    
    .left-branch:before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        width: 1px;
        height: 40px;
        background-color: #3498db;
    }
    
    .right-branch:before {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        width: 1px;
        height: 40px;
        background-color: #3498db;
    }
    
    .tree-branches:before {
        content: '';
        position: absolute;
        top: 0;
        left: 25%;
        width: 50%;
        height: 1px;
        background-color: #3498db;
    }
    
    .tree-children {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }
    
    .child {
        flex: 1;
        display: flex;
        justify-content: center;
    }
    
    .stat-item {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        text-align: center;
    }
    
    .stat-item h6 {
        color: #666;
        margin-bottom: 5px;
    }
    
    .stat-item h3 {
        color: #3498db;
        margin: 0;
    }
    
    .search-box {
        max-width: 300px;
    }
</style>
@endpush 