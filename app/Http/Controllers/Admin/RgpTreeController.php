<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RgpTreeController extends Controller
{
    /**
     * Display the RGP tree view
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $username = $request->username;
        
        if ($username) {
            $user = User::where('username', $username)->first();
        } else {
            // Get the root user (user with no RGP parent)
            $user = User::whereNull('rgp_parent_id')->first();
            
            // If no root user found, get the first user
            if (!$user) {
                $user = User::first();
            }
        }
        
        if (!$user) {
            return redirect()->route('admin.rgp.tree')->with('error', 'User not found');
        }
        
        // Get left and right children
        $leftChild = User::where('rgp_parent_id', $user->id)
            ->where('referral_node', 'left')
            ->first();
            
        $rightChild = User::where('rgp_parent_id', $user->id)
            ->where('referral_node', 'right')
            ->first();
        
        // Get user's RGP parent
        $parent = null;
        if ($user->rgp_parent_id) {
            $parent = User::find($user->rgp_parent_id);
        }
        
        return view('admin.rgp_tree.index', compact('user', 'leftChild', 'rightChild', 'parent'));
    }
    
    /**
     * Display the visual binary tree representation
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function visualTree(Request $request)
    {
        $username = $request->username;
        $treeData = null;
        $user = null;
        $parent = null;
        $ancestors = [];
        $search = $request->search;
        $perPage = $request->per_page ?? 20;
        
        // If a specific username is provided, show that user's tree
        if ($username) {
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return redirect()->route('admin.rgp.tree.visual')->with('error', 'User not found');
            }
            
            // Get the ancestors (parents chain) of the current user
            $currentParent = $user;
            
            while ($currentParent && $currentParent->rgp_parent_id) {
                $parent = User::find($currentParent->rgp_parent_id);
                if ($parent) {
                    $ancestors[] = [
                        'id' => $parent->id,
                        'username' => $parent->username,
                        'fullname' => $parent->fullname,
                        'rgp_l' => floatval($parent->rgp_l ?? 0),
                        'rgp_r' => floatval($parent->rgp_r ?? 0),
                        'rgp_pair_matching' => floatval($parent->rgp_pair_matching ?? 0),
                    ];
                    $currentParent = $parent;
                } else {
                    break;
                }
            }
            
            // Reverse the ancestors array to show from top to bottom
            $ancestors = array_reverse($ancestors);
            
            // Get user's immediate parent
            $parent = null;
            if ($user->rgp_parent_id) {
                $parent = User::find($user->rgp_parent_id);
            }
            
            // Get the tree data for visualization with increased depth (10 levels)
            $treeData = $this->getTreeData($user, 10);
            
            return view('admin.rgp_tree.visual', compact('user', 'parent', 'treeData', 'ancestors', 'search', 'perPage'));
        } else {
            // No username provided, show list of root users (users without RGP parents)
            $rootUsersQuery = User::whereNull('rgp_parent_id')
                ->select('id', 'username', 'firstname', 'lastname', 'rgp_l', 'rgp_r', 'rgp_pair_matching');
                
            // Apply search filter if provided
            if ($search) {
                $rootUsersQuery->where(function($query) use ($search) {
                    $query->where('username', 'like', "%{$search}%")
                        ->orWhere('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%");
                });
            }
            
            // Order by username and paginate
            $rootUsers = $rootUsersQuery->orderBy('username')
                ->paginate($perPage)
                ->appends($request->except('page'));
                
            return view('admin.rgp_tree.visual', compact('rootUsers', 'user', 'parent', 'treeData', 'ancestors', 'search', 'perPage'));
        }
    }
    
    /**
     * Search for a user by username
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $search = $request->search;
        
        $users = User::where('username', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhere('firstname', 'like', "%$search%")
            ->orWhere('lastname', 'like', "%$search%")
            ->select('id', 'username', 'email', 'firstname', 'lastname')
            ->limit(10)
            ->get();
            
        return response()->json($users);
    }
    
    /**
     * Get children for a specific user (for AJAX loading)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChildren(Request $request)
    {
        $userId = $request->user_id;
        
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        $leftChild = User::where('rgp_parent_id', $user->id)
            ->where('referral_node', 'left')
            ->first();
            
        $rightChild = User::where('rgp_parent_id', $user->id)
            ->where('referral_node', 'right')
            ->first();
            
        $leftChildData = null;
        $rightChildData = null;
        
        if ($leftChild) {
            $leftChildData = [
                'id' => $leftChild->id,
                'username' => $leftChild->username,
                'fullname' => $leftChild->fullname,
                'rgp_l' => $leftChild->rgp_l,
                'rgp_r' => $leftChild->rgp_r,
                'has_children' => User::where('rgp_parent_id', $leftChild->id)->exists()
            ];
        }
        
        if ($rightChild) {
            $rightChildData = [
                'id' => $rightChild->id,
                'username' => $rightChild->username,
                'fullname' => $rightChild->fullname,
                'rgp_l' => $rightChild->rgp_r,
                'rgp_r' => $rightChild->rgp_r,
                'has_children' => User::where('rgp_parent_id', $rightChild->id)->exists()
            ];
        }
        
        return response()->json([
            'left_child' => $leftChildData,
            'right_child' => $rightChildData
        ]);
    }
    
    /**
     * Get tree data for a user up to a certain depth
     *
     * @param User $user
     * @param int $maxDepth
     * @return array|null
     */
    private function getTreeData(User $user, $maxDepth = 10, $currentDepth = 0)
    {
        // If user is null, return null
        if (!$user) {
            return null;
        }
        
        // Create basic node data
        $data = [
            'id' => $user->id,
            'name' => $user->username,
            'fullname' => $user->fullname ?? '',
            'rgp_l' => floatval($user->rgp_l ?? 0),
            'rgp_r' => floatval($user->rgp_r ?? 0),
            'rgp_pair_matching' => floatval($user->rgp_pair_matching ?? 0),
            // Initialize with empty array to avoid null children
            'children' => []
        ];
        
        // Stop recursion at max depth
        if ($currentDepth >= $maxDepth) {
            return $data;
        }
        
        try {
            // Get left child
            $leftChild = User::where('rgp_parent_id', $user->id)
                ->where('referral_node', 'left')
                ->first();
                
            if ($leftChild) {
                $leftChildData = $this->getTreeData($leftChild, $maxDepth, $currentDepth + 1);
                if ($leftChildData) {
                    $data['children'][] = $leftChildData;
                } else {
                    // Add placeholder for left child if data is null
                    $data['children'][] = null;
                }
            } else {
                // Add placeholder for left child if it doesn't exist
                $data['children'][] = null;
            }
            
            // Get right child
            $rightChild = User::where('rgp_parent_id', $user->id)
                ->where('referral_node', 'right')
                ->first();
                
            if ($rightChild) {
                $rightChildData = $this->getTreeData($rightChild, $maxDepth, $currentDepth + 1);
                if ($rightChildData) {
                    $data['children'][] = $rightChildData;
                } else {
                    // Add placeholder for right child if data is null
                    $data['children'][] = null;
                }
            } else {
                // Add placeholder for right child if it doesn't exist
                $data['children'][] = null;
            }
            
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in RGP tree data: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'depth' => $currentDepth,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Ensure we have valid children array
            if (!isset($data['children']) || !is_array($data['children'])) {
                $data['children'] = [null, null];
            } else if (count($data['children']) < 2) {
                // Add missing children if needed
                while (count($data['children']) < 2) {
                    $data['children'][] = null;
                }
            }
        }
        
        return $data;
    }
    
    /**
     * Get node details for AJAX requests
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNodeDetails(Request $request)
    {
        try {
            $userId = $request->user_id;
            
            if (!$userId) {
                return response()->json(['error' => 'User ID is required'], 400);
            }
            
            $user = User::find($userId);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            
            return response()->json([
                'id' => $user->id,
                'username' => $user->username,
                'fullname' => $user->fullname,
                'rgp_l' => floatval($user->rgp_l ?? 0),
                'rgp_r' => floatval($user->rgp_r ?? 0),
                'rgp_pair_matching' => floatval($user->rgp_pair_matching ?? 0),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching node details'], 500);
        }
    }
} 