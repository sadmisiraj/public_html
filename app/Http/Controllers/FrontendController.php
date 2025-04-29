<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogDetails;
use App\Models\ContentDetails;
use App\Models\Language;
use App\Models\Page;
use App\Models\PageDetail;
use App\Models\Subscriber;
use App\Traits\Frontend;
use App\Traits\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    use Frontend,Notify;


    public function page($slug = '/')
    {

        try {

            $selectedTheme =getTheme();

            $existingSlugs = collect([]);
            DB::table('pages')->select('slug')->get()->map(function ($item) use ($existingSlugs) {
                $existingSlugs->push($item->slug);
            });

            if (!in_array($slug, $existingSlugs->toArray())) {
                abort(404);
            }


            $pageDetails = PageDetail::with('page')
                ->whereHas('page', function ($query) use ($slug, $selectedTheme) {
                    $query->where(['slug' => $slug, 'template_name' => $selectedTheme]);
                })
                ->firstOrFail();
            $data = getData();


            $pageSeo = [
                'page_title' => optional($pageDetails->page)->page_title,
                'meta_title' => optional($pageDetails->page)->meta_title,
                'meta_keywords' => implode(',', optional($pageDetails->page)->meta_keywords ?? []),
                'meta_description' => optional($pageDetails->page)->meta_description,
                'og_description' => optional($pageDetails->page)->og_description,
                'meta_robots' => optional($pageDetails->page)->meta_robots,
                'meta_image' => getFile(optional($pageDetails->page)->meta_image_driver, optional($pageDetails->page)->meta_image),
                'breadcrumb_image' => optional($pageDetails->page)->breadcrumb_status ?
                    getFile(optional($pageDetails->page)->breadcrumb_image_driver, optional($pageDetails->page)->breadcrumb_image) : null,
            ];
            $sectionsData = $this->getSectionsData($pageDetails->sections, $pageDetails->content, $selectedTheme);
            return view("themes.{$selectedTheme}.page", compact('sectionsData', 'pageSeo'),$data);


        }  catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                abort(404);
            }
            if ($exception->getCode() == 403) {
                abort(403);
            }
            if ($exception->getCode() == 401) {
                abort(401);
            }
            if ($exception->getCode() == 503) {
                return redirect()->route('maintenance');
            }
            if ($exception->getCode() == "42S02") {
                die($exception->getMessage());
            }
            if ($exception->getCode() == 1045) {
                die("Access denied. Please check your username and password.");
            }
            if ($exception->getCode() == 1044) {
                die("Access denied to the database. Ensure your user has the necessary permissions.");
            }
            if ($exception->getCode() == 1049) {
                die("Unknown database. Please verify the database name exists and is spelled correctly.");
            }
            if ($exception->getCode() == 2002) {
                die("Unable to connect to the MySQL server. Check the database host and ensure the server is running.");
            }
            if ($exception->getCode() == 0) {
                die("Unknown connection issue. Verify your connection parameters and server status.");
            }
            return redirect()->route('instructionPage');
        }
    }



    public function blogs()
    {
        $title = null;
        if (\request()->has('title')){
            $title  = request()->get('title');
        }
        $seo = Page::where(['slug'=> 'blogs','template_name' => getTheme()])->firstOrFail();
        $data = getData();
        $data['pageSeo'] = [
            'page_title' => $seo->page_title,
            'meta_title' => $seo->meta_title,
            'meta_keywords' => implode(',', $seo->meta_keywords ?? []),
            'meta_description' => $seo->meta_description,
            'og_description' => $seo->og_description,
            'meta_robots' => $seo->meta_robots,
            'meta_image' => getFile($seo->meta_image_driver, $seo->meta_image),
            'breadcrumb_image' => $seo->breadcrumb_status ?
                getFile($seo->breadcrumb_image_driver, $seo->breadcrumb_image) : null,
        ];

        $content_name = getTheme().'_'.'blog_section';
        $blogData = ContentDetails::with('content')
            ->whereHas('content', function ($query) use ($content_name) {
                $query->where('name', $content_name);
            })
            ->get();
        $singleContent = $blogData->where('content.name', $content_name)->where('content.type', 'single')->first() ?? [];
        $blogSectionData = [
            'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
        ];
        $data['blog'] = $blogSectionData;
        $blogs = Blog::with('details')
            ->when($title, function ($query) use ($title) {
                $query->whereHas('details', function ($query) use ($title) {
                    $query->where('title', 'LIKE' , '%'.$title.'%');
                });
            })
            ->get();


        return view(template().'pages.blogs', compact('blogs'),$data);
    }

    public function blogDetails($slug)
    {

        $blogDetails = BlogDetails::where('slug',$slug)->firstOrFail();
        $blog = $blogDetails->blog;
        if (!$blog){
            abort(404);
        }
        $seo = $blog;
        $pageSeo = [
            'page_title' => $seo->page_title,
            'meta_title' => $seo->meta_title,
            'meta_keywords' => implode(',', $seo->meta_keywords ?? []),
            'meta_description' => $seo->meta_description,
            'meta_image' => getFile($seo->meta_image_driver, $seo->meta_image),
            'breadcrumb_image' => $seo->breadcrumb_status ?
                getFile($seo->breadcrumb_image_driver, $seo->breadcrumb_image) : null,
        ];
        $data = getData();
        $data['categories'] = BlogCategory::get();
        $recentBlogs = Blog::with('details')
            ->whereNot('id',$blog->id)->latest()->take(4)->get();
        return view(template().'pages.blog_details',$data, compact('blog','blogDetails','recentBlogs','pageSeo'));
    }

    public function categoryBlogs($id)
    {
        $seo = Page::where(['slug'=> 'blogs','template_name' => getTheme()])->firstOrFail();

        $data = getData();
        $data['pageSeo'] = [
            'page_title' => $seo->page_title,
            'meta_title' => $seo->meta_title,
            'meta_keywords' => implode(',', $seo->meta_keywords ?? []),
            'meta_description' => $seo->meta_description,
            'og_description' => $seo->og_description,
            'meta_robots' => $seo->meta_robots,
            'meta_image' => getFile($seo->meta_image_driver, $seo->meta_image),
            'breadcrumb_image' => $seo->breadcrumb_status ?
                getFile($seo->breadcrumb_image_driver, $seo->breadcrumb_image) : null,
        ];

        $content_name = getTheme().'_'.'blog_section';
        $blogData = ContentDetails::with('content')
            ->whereHas('content', function ($query) use ($content_name) {
                $query->where('name', $content_name);
            })
            ->get();
        $singleContent = $blogData->where('content.name', $content_name)->where('content.type', 'single')->first() ?? [];
        $blogSectionData = [
            'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
        ];
        $data['blog'] = $blogSectionData;
        $blogs = Blog::with('details')->where('category_id', $id)->get();
        return view(template().'pages.blogs', compact('blogs'),$data);
    }

    public function language($locale = 'en')
    {
        app()->setLocale($locale);
        $lang = Language::where('short_name', $locale)->first();
        session()->put('lang', $locale);
        session()->put('language', $lang);
        session()->put('rtl', $lang ? $lang->rtl : 0);

        Artisan::call('cache:clear');
        return redirect()->back();
    }


    public function subscribe(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255|unique:subscribers'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->errors()->first());
        }
        $data = new Subscriber();
        $data->email = $request->email;
        $data->save();

        $msg = [
            'email' => $data->email
        ];

        $action = [
            "link" => route('admin.subscriber.index'),
            "icon" => "fas fa-user text-white",
            'image' => auth()->user()? getFile(auth()->user()->image_driver,auth()->user()->image):getFile('local','image')
        ];

        $this->adminPushNotification('SUBSCRIBE_NEWSLETTER', $msg, $action);
        $this->adminMail('SUBSCRIBE_NEWSLETTER', [
            'email' => $data->email,
        ]);

        return redirect(url()->previous() . '#subscribe')->with('success', 'Subscribed Successfully');
    }

    public function contactSend(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|max:91',
            'subject' => 'required|max:100',
            'message' => 'required|max:1000',
        ]);
        $requestData = $request->all();

        $params = [
            'name' => $requestData['name'],
            'email' => $requestData['email'],
            'subject' => $requestData['subject'],
            'message' => $requestData['message'],
        ];
       $this->adminMail('SEND_CONTACT_FORM', $params);

        return back()->with('success', 'Mail has been sent');
    }
}
