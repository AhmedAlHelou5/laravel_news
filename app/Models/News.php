<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected  $table='news';

    protected $guarded = [];
    public function news_type(){
     return $this->hasMany (Classifications::class,'classification_id');}


        public function typeNews(){
            return $this->belongsTo(Classifications :: class,'classification_id','id');
            }

}
