<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogDetails extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function blog(){
        return $this->belongsTo(Blog::class, 'blog_id');
    }

}
