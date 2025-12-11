<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Enemigo;

class Arma extends Model
{

    function getPath(): string {
        $path = url('assets/img/afeitado.jpg');
        if($this->image != null &&
                file_exists(storage_path('app/public') . '/' . $this->image)) {
            $path = url('storage/' . $this->image);
        }
        return $path;
    }
    protected $table = "arma";
    protected $fillable = ["nombre","descripcion","ataque","image"];

    public function enemigos() {
        return $this->hasMany(Enemigo::class);
    }
}