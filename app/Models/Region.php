<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{

    function getPath(): string {
        $path = url('assets/img/portada.jpg');
        if($this->image != null &&
                file_exists(storage_path('app/public') . '/' . $this->image)) {
            $path = url('storage/' . $this->image);
        }
        return $path;
    }
    protected $table = "region";
    protected $fillable = ["nombre","poblacion","dificultad","image"];

    public function zonas(){
        return $this->hasMany(Zona::class);
    }

}