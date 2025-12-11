<?php

namespace App\Http\Controllers;

use App\Models\Enemigo;
use App\Models\Arma;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;

class EnemigoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    public function index(): View
    {
        $enemigos = Enemigo::all();
        return view('enemigo.index', ["enemigos" => $enemigos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $armas = Arma::pluck('nombre', 'id');
        $zonas = Zona::pluck('nombre', 'id');

        return view('enemigo.create',["armas" => $armas,"zonas"=>$zonas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
        $validatedData = $request->validate([
            // Nombre del Enemigo: Requerido, cadena, máx. 255 y único en la tabla 'enemigos'
            'nombre' => 'required|string|max:255|unique:enemigo,nombre', 
            
            // Vida Total: Requerido, entero, mínimo 1
            'vida_T' => 'required|integer|min:1', 
            
            // Ataque Total: Requerido, entero, mínimo 0
            'ataque_T' => 'required|integer|min:0', 
            
            // zona_id: Requerido, debe existir en la tabla 'zonas'
            'zona_id' => 'required|exists:zona,id', 
            
            // arma_id: Requerido, debe existir en la tabla 'armas'
            'arma_id' => 'required|exists:arma,id',             
        ]);
    // 2. Intentar Guardar
    $enemigo = new Enemigo($validatedData);
    $result = false;
    $txtmessage = 'Error desconocido al registrar el adversario.';
    
    try {
        $result = $enemigo->save(); 
        $txtmessage = '¡Adversario registrado con éxito! El camino ha sido iluminado.';
        if($request->hasFile('image')) {

                $ruta = $this->upload($request, $enemigo);
                $enemigo->image = $ruta;
                $enemigo->save();
            }
        
    } catch (UniqueConstraintViolationException $e) {
        $txtmessage = 'Error: Ya existe un adversario con este nombre (Clave única duplicada).';
    } catch (QueryException $e) {
        $txtmessage = 'Error de Base de Datos: Verifique los campos obligatorios y las referencias (IDs).';
    } catch (\Exception $e) {
        $txtmessage = 'Error inesperado: ' . $e->getMessage();
    }
    
    $message = [
        'mensajeTexto' => $txtmessage,
    ];
    
    // 3. Redirección basada en el resultado
    if($result) {
        return redirect()->route('enemigos.index')->with('success',$txtmessage);
    } else {
        return back()->withInput()->withErrors($message);
    }
}

    private function upload(Request $request, Enemigo $enemigo): string {
        $image = $request->file('image');
        $name = $enemigo->id . '.' . $image->getClientOriginalExtension();
        $ruta = $image->storeAs('enemigo', $name, 'public');
        return $ruta;
    }
    public function show(enemigo $enemigo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(enemigo $enemigo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, enemigo $enemigo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enemigo $enemigo)
    {
        try {
            if ($enemigo->image) {
            Storage::disk('public')->delete($enemigo->image);
        }
            $result = $enemigo->delete();
            $textMessage = 'El enemigo se ha eliminado.';
        } catch(\Exception $e) {
            $textMessage = 'El enemigo no se ha podido eliminar.';
            $result = false;
        }
        $message = [
            'mensajeTexto' => $textMessage,
        ];
        if($result) {
            return redirect()->route('enemigos.index')->with('success',$textMessage);
        } else {
            return back()->withInput()->withErrors($textMessage);
        }
    }
}