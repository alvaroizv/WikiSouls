<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Arma;
use App\Models\Escudo;
use App\Models\Zona;



class Enemigo extends Model
{

    function getPath(): string {
        $path = url('assets/img/afeitado.jpg');
        if($this->image != null &&
                file_exists(storage_path('app/public') . '/' . $this->image)) {
            $path = url('storage/' . $this->image);
        }
        return $path;
    }
    protected $table = "enemigo";
    protected $fillable = ["nombre","vida_T","ataque_T","zona_id","arma_id","image"];

    public function arma(){
        return $this->belongsTo(Arma::class);
    }

    public function zona(){
        return $this->belongsTo(Zona::class);
    }
}