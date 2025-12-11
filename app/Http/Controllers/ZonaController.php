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
use Illuminate\View\View; 

class ZonaController extends Controller
{
    
    public function __construct()
    {
        // Middleware de autenticación (excepto para index y show)
        $this->middleware('auth')->except(['index', 'show']);
    }


    public function index(): View // Tipo de Retorno: View
    {
        $zonas = Zona::all();
        return view('zona.index', ["zonas" => $zonas]);
    }


    public function create(): View 
    {
        $regiones = Region::orderBy('nombre')->pluck('nombre', 'id');
        return view('zona.create', ['regiones' => $regiones]);
    }

    // Almacena una nueva zona en la base de datos.
    public function store(StoreZonaRequest $request): RedirectResponse 
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

        if ($result) {
            return redirect()->route('zonas.index')->with($txtmessage);
        } else {
            return back()->withInput()->with('error', $txtmessage);
        }
    }

    // Muestra la vista detallada de una zona.
    public function show(Zona $zona): View 
    {
        return view('zona.show', ['zona' => $zona]);
    }

    // Muestra el formulario de edición de una zona.
    public function edit(Zona $zona): View 
    {
        $regiones = Region::pluck('nombre', 'id');
        return view('zona.edit', ['zona' => $zona, 'regiones' => $regiones]);
    }

    // Actualiza la zona especificada en la base de datos.

    public function update(EditZonaRequest $request, Zona $zona): RedirectResponse 
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
            return redirect()->route('zonas.show', $zona->id)->with($txtmessage);
        } else {
            return back()->withInput()->with('error', $txtmessage);
        }
    }

    // Método privado para subir la imagen.
    private function upload(Request $request, Zona $zona): string 
    {
        $image = $request->file('image');
        $name = $zona->id . '.' . $image->getClientOriginalExtension();
        $ruta = $image->storeAs('zona', $name, 'public');
        return $ruta;
    }

    // Elimina la zona de la base de datos.

    function destroy(Zona $zona): RedirectResponse 
    {
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
        
        if($result) {
            return redirect()->route('zonas.index')->with($textMessage);
        } else {
            return back()->withInput()->with('error', $textMessage);
        }
    }
}
