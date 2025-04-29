<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Language;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Rules\AlphaDashWithoutSlashes;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    use Upload;

    public function index()
    {
        $data['defaultLanguage'] = Language::where('default_status', true)->first();
        $data['allLanguage'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();
        $data['blogs'] = Blog::with('category', 'details')->orderBy('id', 'desc')->paginate(10);
        return view('admin.blogs.list', $data);
    }


    public function create()
    {
        $data['blogCategory'] = BlogCategory::orderBy('id', 'desc')->get();
        $data['defaultLanguage'] = Language::where('default_status', true)->first();
        $data['allLanguage'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();
        return view('admin.blogs.create', $data);
    }

    public function store(Request $request)
    {

        $request->validate([
            'category_id' => 'required|numeric|not_in:0|exists:blog_categories,id',
            'title' => 'required|string|min:3|max:200',
            'slug' =>  ['required', 'min:1', 'max:200',
                new AlphaDashWithoutSlashes(),
                Rule::notIn(['login', 'register', 'signin', 'signup', 'sign-in', 'sign-up'])
            ],
            'description' => 'required|string|min:3',
            'description_image' => 'required|mimes:png,jpg,jpeg|max:5000',
        ]);

        try {
            if ($request->hasFile('description_image')) {
                $descriptionImage = $this->fileUpload($request->description_image, config('filelocation.blog.path'), null, null, 'webp', 60 );
                throw_if(empty($descriptionImage['path']), 'Description image could not be uploaded.');
            }
            if ($request->hasFile('breadcrumb_image')) {
                $breadCrumbImage = $this->fileUpload($request->breadcrumb_image, config('filelocation.blog.path'), null, null, 'webp', 60 );
                throw_if(empty($descriptionImage['path']), 'Description image could not be uploaded.');
            }

            DB::beginTransaction();
            $response = Blog::create([
                'category_id' => $request->category_id,
                'blog_image' => $descriptionImage['path'] ?? null,
                'blog_image_driver' => $descriptionImage['driver'] ?? null,
                'breadcrumb_status' => $request->breadcrumb_status,
                'breadcrumb_image' => $breadCrumbImage['path'] ?? null,
                'breadcrumb_image_driver' => $breadCrumbImage['driver'] ?? null,
                'status' => $request->status,
                'created_by' => Auth::id()
            ]);



            $response->details()->create([
                "title" => $request->title,
                "slug" => $request->slug,
                'language_id' => $request->language_id,
                'description' => $request->description,
            ]);
            DB::commit();

            return back()->with('success', 'Blog saved successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }


    }


    /**
     * Show the form for editing the specified resource.
     */
    public function blogEdit($id, $language = null)
    {
        $blog = Blog::with("details")->where('id', $id)->firstOr(function () {
            throw new \Exception('Blog not found');
        });
        $data['pageEditableLanguage'] = Language::where('id', $language)->select('id', 'name', 'short_name')->first();
        $data['defaultLanguage'] = Language::where('default_status', true)->first();
        $data['blogCategory'] = BlogCategory::orderBy('id', 'desc')->get();
        $data['allLanguage'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();
        return view('admin.blogs.edit', $data, compact('blog', 'language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function blogUpdate(Request $request, $id, $language)
    {

        $blog = Blog::with(['details' => function ($query) use ($language) {
            $query->where('language_id',$language);
        }])->findOrFail($id);

        $blogDetailsId =  $blog->details->id;

        $request->validate([
            'category_id' => 'required|numeric|not_in:0|exists:blog_categories,id',
            'title' => 'required|string|min:3|max:200',
            'slug' => ['required', 'min:1', 'max:200',
                new AlphaDashWithoutSlashes(),
                Rule::unique('blog_details', 'slug')->ignore($blogDetailsId,'id'),
                Rule::notIn(['login', 'register', 'signin', 'signup', 'sign-in', 'sign-up'])
            ],
            'description' => 'nullable|string|min:3',
            'description_image' => 'nullable|mimes:png,jpg,jpeg|max:50000',
        ]);

        try {

            if ($request->hasFile('description_image')) {
                $descriptionImage = $this->fileUpload($request->description_image, config('filelocation.blog.path'), null, null, 'webp', 60 );
                throw_if(empty($descriptionImage['path']), 'Description image could not be uploaded.');
            }
            if ($request->hasFile('breadcrumb_image')) {

                $breadCrumbImage = $this->fileUpload($request->breadcrumb_image, config('filelocation.blog.path'), null, null, 'webp', 60 );

                throw_if(empty($breadCrumbImage['path']), 'Breadcrumb image could not be uploaded.');
            }

            DB::beginTransaction();
            $blog = Blog::with(['details' => function ($query) use ($request) {
                $query->where('language_id',$request->language_id);
            }])->findOrFail($id);

            $blog->update([
                'category_id' => $request->category_id,
                'blog_image' => $descriptionImage['path'] ?? $blog->blog_image,
                'blog_image_driver' => $descriptionImage['driver'] ?? $blog->blog_image_driver,
                'breadcrumb_status' => $request->breadcrumb_status,
                'breadcrumb_image' => $breadCrumbImage['path']??$blog->breadcrumb_image,
                'breadcrumb_image_driver' => $breadCrumbImage['driver']??$blog->breadcrumb_image_driver,
                'status' => $request->status,
                'created_by' => Auth::id()
            ]);




            $blog->details()->updateOrCreate([
                'language_id' => $request->language_id,
            ],
                [
                    "title" => $request->title,
                    "slug" => strtolower($request->slug),
                    'description' => $request->description,
                ]
            );
            DB::commit();
            return back()->with('success', 'Blog saved successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }

    }

    public function destroy(string $id)
    {
        try {
            $blog = Blog::where('id', $id)->firstOr(function () {
                throw new \Exception('No blog data found.');
            });
            $blog->delete();
            return redirect()->back()->with('success', 'Blog deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function slugUpdate(Request $request)
    {
        $rules = [
            "blogId" => "required|exists:blogs,id",
            "newSlug" => ["required", "min:1", "max:100",
                new AlphaDashWithoutSlashes(),
                Rule::unique('blog_details', 'slug')->ignore($request->blogId),
                Rule::notIn(['login', 'register', 'signin', 'signup', 'sign-in', 'sign-up'])
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();
            $blogId = $request->blogId;
            $newSlug = $request->newSlug;
            $blog = Blog::find($blogId);

            if (!$blog) {
                return back()->with("error", "Page not found");
            }

            $blog->details()->update([
                'slug' => $newSlug
            ]);
            DB::commit();

            return response([
                'success' => true,
                'slug' => $blog->slug
            ]);
        }catch (\Exception $e) {
            DB::rollback();
            return response(['success' => false,]);
        }
    }

    public function blogSeo(Request $request, $id)
    {
        try {
            $blog = Blog::with("details")->where('id', $id)->firstOr(function () {
                throw new \Exception('Blog not found');
            });
            return view('admin.blogs.seo', compact('blog'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function blogSeoUpdate(Request $request, $id)
    {
        $request->validate([
            'page_title' => 'required|string|min:3|max:100',
            'meta_title' => 'required|string|min:3|max:100',
            'meta_keywords' => 'required|array',
            'meta_keywords.*' => 'required|string|min:1|max:300',
            'meta_description' => 'required|string|min:1|max:300',
            'seo_meta_image' => 'sometimes|required|mimes:jpeg,png,jpeg|max:2048'
        ]);

        try {


        $blog = Blog::with("details")->where('id', $id)->firstOr(function () {
            throw new \Exception('Blog not found');
        });

        if ($request->hasFile('seo_meta_image')) {
            try {
                $image = $this->fileUpload($request->seo_meta_image, config('filelocation.pageSeo.path'), config('filesystems.default'), $blog->meta_image_driver, $blog->meta_image, null, 'webp', 80);
                if ($image) {
                    $pageSEOImage = $image['path'];
                    $pageSEODriver = $image['driver'] ?? 'local';
                }
            } catch (\Exception $exp) {
                return back()->with('error', 'Meta image could not be uploaded.');
            }
        }

        $blog->update([
            'page_title' => $request->page_title,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'meta_image' => $pageSEOImage ?? $blog->meta_image,
            'meta_image_driver' => $pageSEODriver ?? $blog->meta_image_driver,
        ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Seo has been updated.');
    }


}
