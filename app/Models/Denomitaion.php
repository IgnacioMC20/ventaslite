<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denomitaion extends Model
{
    use HasFactory;

    protected $table = 'denominations';
    protected $fillable = ['type', 'value', 'image'];

    public function getImageAttribute($image)
    {
        if($image){
            if( file_exists('storage/denominations/'.$image)){
                return $image;
            }else{
                return 'noimg.jpg';
            }
        }
    }

}
