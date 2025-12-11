<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Zona;

class Objeto extends Model
{

    function getPath(): string {
        $path = url('assets/img/afeitado.jpg');
        if($this->image != null &&
                file_exists(storage_path('app/public') . '/' . $this->image)) {
            $path = url('storage/' . $this->image);
        }
        return $path;
    }
    protected $table = "objeto";
    protected $fillable = ["nombre","usos","zona_id","descripcion","image"];

    public function zona(){
        return $this->belongsTo(Zona::class);
    }
}