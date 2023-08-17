<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function user()
    {
        //to get info of the owner ot the comment
        return $this->belongsTo(User::class)->withTrashed();
    }
}
