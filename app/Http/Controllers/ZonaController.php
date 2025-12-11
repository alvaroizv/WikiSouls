<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use App\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreZonaRequest;
use App\Http\Requests\EditZonaRequest;

class ZonaController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    public function index()
    {
        $zonas = Zona::all();
        return view('zona.index', ["zonas" => $zonas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regiones = Region::orderBy('nombre')->pluck('nombre', 'id');
        return view('zona.create', ['regiones' => $regiones]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreZonaRequest $request)
    {
        $validatedData = $request->validated();
        $zona = new Zona($validatedData);
        $result = false;
        $txtmessage = 'Error desconocido al forjar la zona.';

        try {
            $result = $zona->save();

            if($request->hasFile('image')) {
                $ruta = $this->upload($request, $zona);
                $zona->image = $ruta;
                $zona->save();
            }
            $txtmessage = '¡Zona forjada con éxito! Un nuevo territorio ha sido mapeado.';
        } catch (UniqueConstraintViolationException $e) {
            $txtmessage = 'Error: Ya existe una zona con este nombre (Clave única duplicada).';
        } catch (QueryException $e) {
            $txtmessage = 'Error de Base de Datos: Verifique que todos los campos obligatorios estén correctos.';
        } catch (\Exception $e) {
            $txtmessage = 'Error inesperado: ' . $e->getMessage();
        }

        // 4. Redirección basada en el resultado
        if ($result) {
            return redirect()->route('zonas.index')->with('success', $txtmessage);
        } else {
            // Si falla el guardado, redirigimos manteniendo el input y mostrando el error general
            return back()->withInput()->with('error', $txtmessage);
        }
    }

    public function show(Zona $zona)
    {
        return view('zona.show', ['zona' => $zona]);
    }

    public function edit(Zona $zona)
    {
        $regiones = Region::pluck('nombre', 'id');
        return view('zona.edit', ['zona' => $zona, 'regiones' => $regiones]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditZonaRequest $request, Zona $zona)
{
    $validatedData = $request->validated(); 

    $result = false;
    $txtmessage = 'Error desconocido al actualizar la zona.';

    try {
        if ($request->hasFile('image')) {
            if ($zona->image) {
                Storage::disk('public')->delete($zona->image); 
            }
            
            $ruta = $this->upload($request, $zona);
            $validatedData['image'] = $ruta;
        } 

        $zona->fill($validatedData); 
        $result = $zona->save();

        if ($result) {
            $txtmessage = '¡Zona actualizada con éxito! El territorio ha sido re-mapeado.';
        }

    } catch (UniqueConstraintViolationException $e) {
        $txtmessage = 'Error: Ya existe otra zona con este nombre (Clave única duplicada).';
        $result = false;
    } catch (QueryException $e) {
        $txtmessage = 'Error de Base de Datos: Verifique los campos obligatorios y las referencias (IDs).';
        $result = false;
    } catch (\Exception $e) {
        $txtmessage = 'Error inesperado: ' . $e->getMessage();
        $result = false;
    }

    if ($result) {
        return redirect()->route('zonas.show', $zona->id)->with('success', $txtmessage);
    } else {
        return back()->withInput()->with('error', $txtmessage);
    }
    }

    private function upload(Request $request, Zona $zona): string {
        $image = $request->file('image');
        $name = $zona->id . '.' . $image->getClientOriginalExtension();
        $ruta = $image->storeAs('zona', $name, 'public');
        return $ruta;
    }

     function destroy(Zona $zona): RedirectResponse {
        try {
            if ($zona->image) {
            Storage::disk('public')->delete($zona->image);
        }
            $result = $zona->delete();
            $textMessage = 'La zona se ha eliminado.';
        } catch(\Exception $e) {
            $textMessage = 'La zona no se ha podido eliminar.';
            $result = false;
        }
        $message = [
            'mensajeTexto' => $textMessage,
        ];
        if($result) {
            return redirect()->route('zonas.index')->with('success',$textMessage);
        } else {
            return back()->withInput()->withErrors($textMessage);
        }
    }
}