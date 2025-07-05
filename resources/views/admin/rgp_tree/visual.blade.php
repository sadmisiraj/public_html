@extends('admin.layouts.app')
@section('title')
    @lang('Visual RGP Tree')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">@lang('Visual RGP Tree')</h5>
                        <div class="search-box">
                            <form action="{{ route('admin.rgp.tree.visual') }}" method="get">
                                <div class="input-group">
                                    <input type="text" name="username" class="form-control" placeholder="@lang('Search by username')" value="{{ request()->username }}">
                                    <button class="btn btn-primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="tree-container">
                            @if(!$user)
                                <!-- Root Users List -->
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>@lang('Root Users (Users without RGP Parents)')</h5>
                                        <div class="search-box">
                                            <form action="{{ route('admin.rgp.tree.visual') }}" method="get">
                                                <div class="input-group">
                                                    <input type="text" name="search" class="form-control" placeholder="@lang('Search by name or username')" value="{{ $search ?? '' }}">
                                                    <select name="per_page" class="form-select" onchange="this.form.submit()">
                                                        <option value="20" {{ ($perPage ?? 20) == 20 ? 'selected' : '' }}>20</option>
                                                        <option value="50" {{ ($perPage ?? 20) == 50 ? 'selected' : '' }}>50</option>
                                                        <option value="100" {{ ($perPage ?? 20) == 100 ? 'selected' : '' }}>100</option>
                                                    </select>
                                                    <button class="btn btn-primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if(isset($rootUsers) && $rootUsers->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>@lang('Username')</th>
                                                            <th>@lang('Name')</th>
                                                            <th>@lang('Left Points')</th>
                                                            <th>@lang('Right Points')</th>
                                                            <th>@lang('Matching Points')</th>
                                                            <th>@lang('Action')</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($rootUsers as $rootUser)
                                                            <tr>
                                                                <td>{{ $rootUser->username }}</td>
                                                                <td>{{ $rootUser->firstname }} {{ $rootUser->lastname }}</td>
                                                                <td>{{ $rootUser->rgp_l }}</td>
                                                                <td>{{ $rootUser->rgp_r }}</td>
                                                                <td>{{ $rootUser->rgp_pair_matching }}</td>
                                                                <td>
                                                                    <a href="{{ route('admin.rgp.tree.visual', ['username' => $rootUser->username]) }}" class="btn btn-sm btn-primary">
                                                                        <i class="fa fa-sitemap"></i> @lang('View Tree')
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <div class="mt-4">
                                                {{ $rootUsers->links() }}
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                <i class="fa fa-info-circle"></i> @lang('No root users found.')
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <!-- Parent Navigation -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('admin.rgp.tree.visual') }}" class="btn btn-outline-secondary">
                                            <i class="fa fa-list"></i> @lang('Back to Root Users')
                                        </a>
                                        
                                        @if($parent)
                                            <a href="{{ route('admin.rgp.tree.visual', ['username' => $parent->username]) }}" class="btn btn-outline-primary">
                                                <i class="fa fa-arrow-up"></i> @lang('Go to Parent') ({{ $parent->username }})
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Ancestors Chain (Parent Hierarchy) -->
                                @if(count($ancestors ?? []) > 0)
                                    <div class="ancestors-chain mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>@lang('Parent Hierarchy')</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="ancestors-list">
                                                    <ul class="list-inline mb-0 d-flex flex-wrap">
                                                        @foreach($ancestors as $ancestor)
                                                            <li class="list-inline-item me-2 mb-2">
                                                                <a href="{{ route('admin.rgp.tree.visual', ['username' => $ancestor['username']]) }}" 
                                                                   class="btn btn-sm btn-outline-secondary ancestor-node" 
                                                                   data-id="{{ $ancestor['id'] }}"
                                                                   data-bs-toggle="tooltip" 
                                                                   title="L: {{ $ancestor['rgp_l'] }} | R: {{ $ancestor['rgp_r'] }}">
                                                                    <i class="fa fa-user"></i> {{ $ancestor['username'] }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>@lang('Current User')</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar me-3">
                                                        <img src="{{ $user->profilePicture() }}" alt="{{ $user->username }}" class="avatar-img">
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-1">{{ $user->username }}</h5>
                                                        <p class="mb-1">{{ $user->fullname }}</p>
                                                        <div class="d-flex">
                                                            <span class="badge bg-primary me-2">@lang('Left'): {{ $user->rgp_l }}</span>
                                                            <span class="badge bg-success me-2">@lang('Right'): {{ $user->rgp_r }}</span>
                                                            <span class="badge bg-info">@lang('Matching'): {{ $user->rgp_pair_matching }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>@lang('Node Details')</h5>
                                            </div>
                                            <div class="card-body" id="node-details">
                                                <p class="text-center">@lang('Click on a node in the tree to view details')</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Visual Tree -->
                                <div class="visual-tree-container">
                                    @if(empty($treeData))
                                        <div class="alert alert-info text-center">
                                            <i class="fa fa-info-circle fa-2x mb-3"></i>
                                            <p>@lang('No tree data available for this user.')</p>
                                        </div>
                                    @else
                                        <div id="tree-diagram">
                                            <div class="zoom-controls">
                                                <button class="btn btn-sm btn-light" id="zoom-in"><i class="fa fa-search-plus"></i></button>
                                                <button class="btn btn-sm btn-light" id="zoom-out"><i class="fa fa-search-minus"></i></button>
                                                <button class="btn btn-sm btn-light" id="zoom-reset"><i class="fa fa-refresh"></i></button>
                                            </div>
                                            <div class="depth-control">
                                                <label for="depth-slider">Tree Depth: <span id="depth-value">10</span></label>
                                                <input type="range" id="depth-slider" min="1" max="10" value="10" class="form-range">
                                            </div>
                                            <div class="loading-overlay" id="loading-overlay">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<style>
    .visual-tree-container {
        width: 100%;
        height: 700px;
        overflow: auto;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        background-color: #fff;
        position: relative;
    }
    
    /* D3.js Tree Styling */
    .node-group {
        cursor: pointer;
    }
    
    .node-line {
        stroke: #000;
        stroke-width: 2px;
    }
    
    .node-group.root-node .node-line {
        stroke: #000;
        stroke-width: 3px;
    }
    
    .node-group.active .node-line {
        stroke: #444;
        stroke-width: 3px;
    }
    
    .node-text {
        font-size: 11px;
        font-family: Arial, sans-serif;
        font-weight: bold;
        fill: #000;
        text-anchor: middle;
    }
    
    .node-points {
        font-size: 10px;
        font-family: Arial, sans-serif;
        fill: #000;
        text-anchor: middle;
    }
    
    .link {
        fill: none;
        stroke: #000;
        stroke-width: 1.5px;
    }
    
    .edge-label {
        font-size: 11px;
        fill: #000;
        font-weight: bold;
    }
    
    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #3498db;
    }
    
    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Loading indicator */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 200;
    }
    
    /* Zoom controls */
    .zoom-controls {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 4px;
        padding: 5px;
        z-index: 100;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .zoom-controls button {
        margin: 0 2px;
    }
    
    /* Depth control */
    .depth-control {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 4px;
        padding: 10px;
        z-index: 100;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        width: 200px;
    }
    
    .depth-control label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    
    /* Styling for ancestor nodes */
    .ancestors-chain {
        margin-bottom: 20px;
    }
    
    .ancestor-node {
        transition: all 0.2s ease;
    }
    
    .ancestor-node:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('script')
<script src="https://d3js.org/d3.v7.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        
        // Tree data from backend
        let treeData = @json($treeData);
        
        // Hide loading overlay
        const loadingOverlay = document.getElementById('loading-overlay');
        if (loadingOverlay) {
            loadingOverlay.style.display = 'none';
        }
        
        // Get the container for the tree diagram
        const treeContainer = document.getElementById('tree-diagram');
        
        // If no tree data is available, don't try to render the tree
        if (!treeData || !treeContainer) {
            const visualTreeContainer = document.querySelector('.visual-tree-container');
            if (visualTreeContainer) {
                visualTreeContainer.innerHTML = `
                    <div class="alert alert-warning text-center">
                        <i class="fa fa-info-circle fa-2x mb-3"></i>
                        <p>@lang('No tree data available for this user.')</p>
                    </div>
                `;
            }
            return;
        }
        
        try {
            // Validate and fix tree data
            treeData = validateTreeData(treeData);
            
            // Render the D3.js tree
            renderD3Tree(treeData, treeContainer);
            
            // Initialize with the root node details
            if (treeData) {
                showNodeDetails(treeData);
            }
            
            // Setup zoom controls
            setupZoomControls();
        } catch (error) {
            console.error('Error rendering tree:', error);
            
            // Show error message in the tree container
            const visualTreeContainer = document.querySelector('.visual-tree-container');
            if (visualTreeContainer) {
                const errorMessage = error.message || 'Unknown error';
                visualTreeContainer.innerHTML = `
                    <div class="alert alert-danger text-center">
                        <i class="fa fa-exclamation-triangle fa-2x mb-3"></i>
                        <p>@lang('An error occurred while rendering the tree.')</p>
                        <p class="mb-2">@lang('Please try again or contact support.')</p>
                        <p class="text-muted small">Error: ${errorMessage}</p>
                    </div>
                `;
            }
            
            // Also update the node details area
            const nodeDetails = document.getElementById('node-details');
            if (nodeDetails) {
                nodeDetails.innerHTML = `
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-circle"></i> @lang('Tree visualization failed to load.')
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.rgp.tree.visual') }}" class="btn btn-sm btn-secondary">
                            <i class="fa fa-arrow-left"></i> @lang('Back to Root Users')
                        </a>
                    </div>
                `;
            }
        }
        
        /**
         * Validate and fix tree data
         */
        function validateTreeData(node) {
            if (!node) return null;
            
            // Create a new object with validated properties
            const validatedNode = {
                id: node.id || 0,
                name: node.name || 'Unknown',
                fullname: node.fullname || '',
                rgp_l: parseFloat(node.rgp_l || 0),
                rgp_r: parseFloat(node.rgp_r || 0),
                rgp_pair_matching: parseFloat(node.rgp_pair_matching || 0),
                children: []
            };
            
            // Process children if they exist
            if (node.children && Array.isArray(node.children)) {
                for (let i = 0; i < node.children.length; i++) {
                    const child = node.children[i];
                    if (child) {
                        const validatedChild = validateTreeData(child);
                        if (validatedChild) {
                            validatedNode.children.push(validatedChild);
                        }
                    }
                }
            }
            
            return validatedNode;
        }
        
        /**
         * Render a D3.js tree
         */
        function renderD3Tree(data, container) {
            if (!data || !container) return;
            
            // Clear the container
            container.innerHTML = '';
            
            // Set dimensions - increased width and height for deeper trees
            const margin = {top: 80, right: 50, bottom: 50, left: 50};
            const width = 2000 - margin.left - margin.right;
            const height = 1500 - margin.top - margin.bottom;
            
            // Create SVG
            const svg = d3.select(container)
                .append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
                .append("g")
                .attr("transform", `translate(${margin.left},${margin.top})`);
            
            // Create a zoom behavior
            const zoom = d3.zoom()
                .scaleExtent([0.1, 3])
                .on("zoom", (event) => {
                    svg.attr("transform", event.transform);
                });
            
            // Apply zoom behavior to the SVG
            d3.select(container).select("svg")
                .call(zoom)
                .on("dblclick.zoom", null);  // Disable double-click zoom
            
            // Create the tree layout with improved separation for deep trees
            const treeLayout = d3.tree()
                .size([width, height])
                .nodeSize([50, 80]) // Set fixed node size [horizontal, vertical] - more compact
                .separation((a, b) => {
                    // More compact separation
                    const baseSeparation = a.parent === b.parent ? 1.1 : 1.5;
                    // Adjust separation based on depth - deeper nodes need more space
                    const depthFactor = Math.max(1, 6 / (a.depth + 1));
                    return baseSeparation * depthFactor;
                });
            
            // Create the hierarchy from the data
            const root = d3.hierarchy(data);
            
            // Compute the tree layout
            treeLayout(root);
            
            // Add links between nodes - using straight lines with angled connections
            const links = svg.selectAll(".link")
                .data(root.links())
                .enter()
                .append("path")
                .attr("class", "link")
                .attr("d", d => {
                    // Calculate midpoint for the angled connection
                    const midY = (d.source.y + d.target.y) / 2;
                    
                    // Create a path with straight lines and an angle at the midpoint
                    return `M${d.source.x},${d.source.y}
                            L${d.source.x},${midY}
                            L${d.target.x},${midY}
                            L${d.target.x},${d.target.y}`;
                });
            
            // Add edge labels (left/right indicators)
            svg.selectAll(".edge-label")
                .data(root.links())
                .enter()
                .append("text")
                .attr("class", "edge-label")
                .attr("x", d => {
                    // Position label near the first turn of the path
                    if (d.source.x < d.target.x) {
                        return d.source.x + 15; // Right branch
                    } else {
                        return d.source.x - 15; // Left branch
                    }
                })
                .attr("y", d => d.source.y + 30)
                .attr("text-anchor", d => d.source.x < d.target.x ? "start" : "end")
                .text(d => {
                    // Determine if this is a left or right child
                    if (d.source.children && d.source.children.length > 0) {
                        return d.source.children[0] === d.target ? "L" : "R";
                    }
                    return "";
                });
            
            // Add nodes as groups
            const nodeGroups = svg.selectAll(".node-group")
                .data(root.descendants())
                .enter()
                .append("g")
                .attr("class", d => {
                    let classes = "node-group";
                    if (d.depth === 0) classes += " root-node";
                    return classes;
                })
                .attr("transform", d => `translate(${d.x},${d.y})`)
                .on("click", function(event, d) {
                    // Remove active class from all nodes
                    d3.selectAll(".node-group").classed("active", false);
                    
                    // Add active class to clicked node
                    d3.select(this).classed("active", true);
                    
                    // Show node details
                    showNodeDetails(d.data);
                });
            
            // Add lines for nodes
            nodeGroups.append("line")
                .attr("class", "node-line")
                .attr("x1", -20)
                .attr("y1", 0)
                .attr("x2", 20)
                .attr("y2", 0);
            
            // Add username text below the line
            nodeGroups.append("text")
                .attr("class", "node-text")
                .attr("y", 15) // Position below the line
                .text(d => d.data.name);
            
            // Add RGP L points text below the username
            nodeGroups.append("text")
                .attr("class", "node-points")
                .attr("y", 30) // Position below the username
                .text(d => {
                    const left = parseFloat(d.data.rgp_l || 0).toFixed(2);
                    return `L:${left}`;
                });
                
            // Add RGP R points text below the L points
            nodeGroups.append("text")
                .attr("class", "node-points")
                .attr("y", 45) // Position below the L points
                .text(d => {
                    const right = parseFloat(d.data.rgp_r || 0).toFixed(2);
                    return `R:${right}`;
                });
            
            // Center the view on the root node initially
            const rootNode = root.descendants()[0];
            const initialTransform = d3.zoomIdentity
                .translate(width / 2 - rootNode.x, 50 - rootNode.y)
                .scale(0.4); // Start with a smaller scale to show more of the tree
                
            d3.select(container).select("svg")
                .call(zoom.transform, initialTransform);
        }
        
        /**
         * Setup zoom controls
         */
        function setupZoomControls() {
            const zoomIn = document.getElementById('zoom-in');
            const zoomOut = document.getElementById('zoom-out');
            const zoomReset = document.getElementById('zoom-reset');
            
            if (!zoomIn || !zoomOut || !zoomReset) return;
            
            const svg = d3.select('#tree-diagram svg');
            const zoom = d3.zoom().on("zoom", (event) => {
                svg.select("g").attr("transform", event.transform);
            });
            
            zoomIn.addEventListener('click', () => {
                svg.transition().call(zoom.scaleBy, 1.3);
            });
            
            zoomOut.addEventListener('click', () => {
                svg.transition().call(zoom.scaleBy, 0.7);
            });
            
            zoomReset.addEventListener('click', () => {
                const rootNode = d3.hierarchy(treeData).descendants()[0];
                const width = parseInt(svg.attr("width")) - 100;
                const height = parseInt(svg.attr("height")) - 100;
                
                const initialTransform = d3.zoomIdentity
                    .translate(width / 2 - rootNode.x, height / 4 - rootNode.y)
                    .scale(0.8);
                    
                svg.transition().call(zoom.transform, initialTransform);
            });
            
            // Setup depth control
            const depthSlider = document.getElementById('depth-slider');
            const depthValue = document.getElementById('depth-value');
            
            if (depthSlider && depthValue) {
                depthSlider.addEventListener('input', () => {
                    const depth = parseInt(depthSlider.value);
                    depthValue.textContent = depth;
                    
                    // Filter the tree to show only nodes up to the selected depth
                    const nodes = d3.selectAll('.node-group');
                    nodes.style('opacity', d => d.depth <= depth ? 1 : 0.1);
                    
                    // Also filter links
                    const links = d3.selectAll('.link');
                    links.style('opacity', d => d.source.depth < depth ? 1 : 0.1);
                    
                    // And edge labels
                    const edgeLabels = d3.selectAll('.edge-label');
                    edgeLabels.style('opacity', d => d.source.depth < depth ? 1 : 0.1);
                });
            }
        }
        
        /**
         * Show node details in the sidebar
         */
        function showNodeDetails(data) {
            if (!data) return;
            
            const nodeDetails = document.getElementById('node-details');
            if (!nodeDetails) return;
            
            // Show loading in node details
            nodeDetails.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading node details...</p>
                </div>
            `;
            
            // Get node details from API for most up-to-date data
            fetch('{{ route('admin.rgp.tree.node-details') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    user_id: data.id
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(nodeData => {
                if (!nodeData || nodeData.error) {
                    throw new Error(nodeData?.error || 'Failed to fetch node data');
                }
                
                const detailsHtml = `
                    <div class="text-center mb-3">
                        <h5>${nodeData.username || 'Unknown'}</h5>
                        <p>${nodeData.fullname || ''}</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>@lang('Left RGP Points')</th>
                                <td>${nodeData.rgp_l || 0}</td>
                            </tr>
                            <tr>
                                <th>@lang('Right RGP Points')</th>
                                <td>${nodeData.rgp_r || 0}</td>
                            </tr>
                            <tr>
                                <th>@lang('Matching Points')</th>
                                <td>${nodeData.rgp_pair_matching || 0}</td>
                            </tr>
                            <tr>
                                <th>@lang('Difference')</th>
                                <td>${Math.abs((nodeData.rgp_l || 0) - (nodeData.rgp_r || 0)).toFixed(2)}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.rgp.tree.visual') }}?username=${nodeData.username}" class="btn btn-sm btn-primary">@lang('View as Root')</a>
                        <a href="{{ url('security/user') }}/${nodeData.id}/rgp-transactions" class="btn btn-sm btn-info">@lang('Transactions')</a>
                    </div>
                `;
                
                nodeDetails.innerHTML = detailsHtml;
            })
            .catch(error => {
                console.error('Error fetching node details:', error);
                nodeDetails.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle"></i> Error loading node details
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.rgp.tree.visual') }}" class="btn btn-sm btn-secondary">
                            <i class="fa fa-arrow-left"></i> @lang('Back to Root Users')
                        </a>
                    </div>
                `;
            });
        }
    });
</script>
@endpush 