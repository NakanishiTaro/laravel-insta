<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;
    //
    //USED FOR UPDATE METHOD
    //PUT (replace all)
    //PATCH (update a single or any entry)

    protected $table    = 'category_post';
    protected $fillable = ['category_id', 'post_id'];
    public $timestamps  = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
