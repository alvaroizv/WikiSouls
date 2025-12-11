<?php

namespace App\Http\Controllers;

use App\Models\Objeto;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;

class ObjetoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    public function index()
    {
        $objetos = Objeto::all();
        return view('objeto.index', ["objetos" => $objetos]);
    }

    public function create()
    {
        $zonas = Zona::pluck('nombre', 'id');
        return view('objeto.create', ['zonas' => $zonas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1. VALIDACIÓN de Datos
        $validatedData = $request->validate([
    'nombre' => 'required|string|max:255|',
    'usos' => 'required|integer|min:1', 
    
    // Zona ID: Requerido, debe existir en la tabla 'zonas'
    'zona_id' => 'required|exists:zona,id', 
    
    // Descripción: Requerido, cadena de texto, máximo 1000 caracteres
    'descripcion' => 'required|string|max:1000',
    'image' => 'nullable|image|max:2048'
]);

    // 2. CREACIÓN y Guardado
    $objeto = new Objeto($validatedData);
    $result = false;
    $txtmessage = 'Error desconocido al registrar el objeto.';
    
    try {
        $result = $objeto->save();
        if($request->hasFile( 'image')) {
                $ruta = $this->upload($request, $objeto);
                $objeto->image = $ruta;
                $objeto->save();
                $txtmessage = '¡Objeto registrado con éxito! El ' . $validatedData['nombre'] . ' ha sido catalogado.';
            }
    } catch (UniqueConstraintViolationException $e) {
        // Manejo de error por nombre duplicado (si el nombre es UNIQUE)
        $txtmessage = 'Clave única: Ya existe un objeto con este nombre.';
    } catch (QueryException $e) {
        // Manejo de errores de campos obligatorios o tipos de datos incorrectos
        $txtmessage = 'Campo nulo: Verifique los campos obligatorios.';
    } catch (\Exception $e) {
        $txtmessage = 'Otra excepcion: ' . $e->getMessage();
    }
    
    $message = [
        'mensajeTexto' => $txtmessage,
    ];
    
    // 3. Redirección basada en el resultado (Usando la lógica de redirección original)
    if($result) {
        return redirect()->route('objetos.index')->with('success',$txtmessage);
    } else {
        // Redirige hacia atrás con el input y el array de errores
        return back()->withInput()->withErrors($txtmessage);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(objeto $objeto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(objeto $objeto)
    {
        //
    }

    private function upload(Request $request, Objeto $objeto): string {
        $image = $request->file('image');
        $name = $objeto->id . '.' . $image->getClientOriginalExtension();
        $ruta = $image->storeAs('objeto', $name, 'public');
        return $ruta;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, objeto $objeto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Objeto $objeto)
    {
        try {
            if ($objeto->image) {
            Storage::disk('public')->delete($objeto->image);
        }
            $result = $objeto->delete();
            $textMessage = 'El objeto se ha eliminado.';
        } catch(\Exception $e) {
            $textMessage = 'El objeto no se ha podido eliminar.';
            $result = false;
        }
        $message = [
            'mensajeTexto' => $textMessage,
        ];
        if($result) {
            return redirect()->route('objetos.index')->with('success',$textMessage);
        } else {
            return back()->withInput()->withErrors($textMessage);
        }
    }
}