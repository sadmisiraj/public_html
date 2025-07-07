<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'image_driver',
        'url',
        'order',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getImageUrl()
    {
        $url = getFile($this->image_driver, $this->image, true);
        // For debugging
        $localPath = '/assets/upload/' . $this->image;
        $exists = file_exists(public_path($localPath));
        $debug = [
            'image' => $this->image,
            'driver' => $this->image_driver,
            'url' => $url,
            'local_path' => $localPath,
            'exists' => $exists ? 'yes' : 'no'
        ];
        \Log::info('OfferImage debug', $debug);
        return $url;
    }
}
