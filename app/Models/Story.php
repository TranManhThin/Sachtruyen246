<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function chapter(){
        return $this->hasMany(Chapter::class);
    }
    public function genre(){
        return $this->belongsTo(Genre::class,'genre_id','id');
    }

    protected $dates = ['created_at', 'updated_at'];
}
