<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $fillable = ['article_id','category_id','soft_delete'];

    public function category() {
        return $this->belongsTo("App\Category");
    }
}
