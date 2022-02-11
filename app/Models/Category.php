<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    // ? Relaciones
    // Relacion One to Many
    public function products(){
        return $this->hasMany(Product::class);
    }

    // ? Accessor

    public function getImageAttribute($image)
    {
        if($image){
            if( file_exists('storage/categorias/'.$image)){
                return $image;
            }else{
                return 'noimg.jpg';
            }
        }
    }

}
