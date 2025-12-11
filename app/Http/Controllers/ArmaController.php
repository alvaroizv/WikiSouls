<?php

namespace App\Http\Controllers;

use App\Models\Arma;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;

class ArmaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    public function index(): View
    {
        $armas = Arma::all();
        return view('arma.index', ["armas" => $armas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('arma.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
    // El nombre es obligatorio, cadena de texto, máximo 255 caracteres y único en la tabla 'armas'
    'nombre' => 'required|string|max:255|unique:arma,nombre', 
    
    // La descripción es obligatoria y una cadena de texto, máximo 1000 caracteres
    'descripcion' => 'required|string|max:1000',
    
    // El ataque es obligatorio, debe ser un número entero y al menos 1 (no puede hacer 0 daño)
    'ataque' => 'required|integer|min:1', 
    
    // Si tu arma tuviera relaciones, usarías algo como:
    // 'tipo_id' => 'required|exists:tipos_arma,id', 
]);

        $arma = new Arma($validatedData);
        $result = false;
        $txtmessage = 'Error desconocido al crear un arma.';
        
        try {
            // 2. Intentar Guardar
            $result = $arma->save(); 
            $txtmessage = 'Arma forjada con éxito! Una nueva arma ha sido añadida.';
            
        } catch (UniqueConstraintViolationException $e) {
            // 3. Manejo de Errores de Base de Datos
            $txtmessage = 'Error: Ya existe una arma con este nombre (Clave única duplicada).';
        } catch (QueryException $e) {
            $txtmessage = 'Error de Base de Datos: Verifique que todos los campos obligatorios estén correctos.';
        } catch (\Exception $e) {
            $txtmessage = 'Error inesperado: ' . $e->getMessage();
        }
        $message = [
            'mensajeTexto' => $txtmessage,
        ];
        
        // 4. Redirección basada en el resultado
        if($result) {
            return redirect()->route('armas.index')->with($message);
        } else {
            return back()->withInput()->withErrors($message);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(arma $arma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(arma $arma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, arma $arma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Arma $arma)
    {
        try {
            if ($arma->image) {
            Storage::disk('public')->delete($arma->image);
        }
            $result = $arma->delete();
            $textMessage = 'El arma se ha eliminado.';
        } catch(\Exception $e) {
            $textMessage = 'El arma no se ha podido eliminar.';
            $result = false;
        }
        $message = [
            'mensajeTexto' => $textMessage,
        ];
        if($result) {
            return redirect()->route('armas.index')->with('success',$textMessage);
        } else {
            return back()->withInput()->withErrors($textMessage);
        }
    }
}