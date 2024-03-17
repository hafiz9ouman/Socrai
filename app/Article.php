<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class Article extends Model

{

    protected $table="articles";

    protected $fillable = ['title','long_title','description','article_type','image','writer_id','soft_delete'];


    public function getPhotoAttribute($value)

    {

        if (!is_null($this->attributes['photo'])) {

            return asset('uploads/articles/'.$this->attributes['image']);

        }

        return '';

    }


    public function categories() {



        return $this->hasMany('App\ArticleCategory');

    }



    public function writer() {

        return $this->belongsTo('App\Writer');

    }

    public function comments() {
        return $this->hasMany('App\ArticleComment');
    }



}

