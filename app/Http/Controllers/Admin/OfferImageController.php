<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfferImage;
use App\Traits\Upload;
use Illuminate\Http\Request;

class OfferImageController extends Controller
{
    use Upload;

    public function index()
    {
        $offerImages = OfferImage::orderBy('order', 'asc')->get();
        return view('admin.offer_images.index', compact('offerImages'));
    }

    public function create()
    {
        return view('admin.offer_images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'url' => 'nullable|url|max:255',
            'order' => 'required|integer|min:0',
            'status' => 'required|boolean',
        ]);

        try {
            if ($request->hasFile('image')) {
                $image = $this->fileUpload($request->image, config('filelocation.offerImage.path'), null, null, 'webp', 80);
                if ($image) {
                    $imagePath = $image['path'];
                    $imageDriver = $image['driver'];
                } else {
                    return back()->with('error', 'Image could not be uploaded.');
                }
            }

            OfferImage::create([
                'title' => $request->title,
                'image' => $imagePath,
                'image_driver' => $imageDriver,
                'url' => $request->url,
                'order' => $request->order,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.offer-images.index')->with('success', 'Offer image created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $offerImage = OfferImage::findOrFail($id);
        return view('admin.offer_images.edit', compact('offerImage'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'url' => 'nullable|url|max:255',
            'order' => 'required|integer|min:0',
            'status' => 'required|boolean',
        ]);

        try {
            $offerImage = OfferImage::findOrFail($id);

            if ($request->hasFile('image')) {
                $image = $this->fileUpload($request->image, config('filelocation.offerImage.path'), null, null, 'webp', 80, $offerImage->image, $offerImage->image_driver);
                if ($image) {
                    $imagePath = $image['path'];
                    $imageDriver = $image['driver'];
                } else {
                    return back()->with('error', 'Image could not be uploaded.');
                }
            }

            $offerImage->update([
                'title' => $request->title,
                'image' => $imagePath ?? $offerImage->image,
                'image_driver' => $imageDriver ?? $offerImage->image_driver,
                'url' => $request->url,
                'order' => $request->order,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.offer-images.index')->with('success', 'Offer image updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $offerImage = OfferImage::findOrFail($id);
            $this->fileDelete($offerImage->image_driver, $offerImage->image);
            $offerImage->delete();
            
            return redirect()->route('admin.offer-images.index')->with('success', 'Offer image deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
