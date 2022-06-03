<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatigoryFilm extends Model
{
    use HasFactory;
    protected $table=('film_categories');

    public  function films(){
        return $this->hasMany(Film::class);
    }


}
