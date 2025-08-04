<?php

namespace App\Http\Controllers;

use App\Models\Cliente; // Importamos el modelo Cliente
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Muestra una lista de todos los clientes.
     */
    public function index()
    {
        // Usamos el modelo para obtener todos los clientes de la base de datos
        $clientes = Cliente::all();

        // Devolvemos los clientes en formato JSON
        return response()->json($clientes);
    }

    // Aquí, en el futuro, agregaremos más métodos como store() (para guardar),
    // update() (para actualizar), destroy() (para borrar), etc.
    /**
     * Guarda un nuevo cliente en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos que llegan
        $validatedData = $request->validate([
            'nombreEmpresa' => 'required|string|max:255',
            'razonSocial'   => 'required|string|max:255',
            'correo'        => 'required|email|unique:clientes,correo',
            'telefono'      => 'required|string|max:50',
            'rtn'           => 'nullable|string|max:50',
            'direccion'     => 'nullable|string',
        ]);

        // 2. Crear el cliente con los datos validados
        $cliente = Cliente::create($validatedData);

        // 3. Devolver el nuevo cliente creado con un código de estado 201 (Created)
        return response()->json($cliente, 201);


    }
    /**
     * Muestra un cliente específico.
     */
    public function show(Cliente $cliente)
    {
        // Laravel automáticamente encuentra el cliente por su id
        return response()->json($cliente);
    }

    /**
     * Actualiza un cliente específico.
     */
    public function update(Request $request, Cliente $cliente)
    {
        // Validamos los datos (el 'unique' se ajusta para ignorar el cliente actual)
        $validatedData = $request->validate([
            'nombreEmpresa' => 'sometimes|required|string|max:255',
            'razonSocial'   => 'sometimes|required|string|max:255',
            'correo'        => 'sometimes|required|email|unique:clientes,correo,'.$cliente->idCliente.',idCliente',
            'telefono'      => 'sometimes|required|string|max:50',
            'rtn'           => 'nullable|string|max:50',
            'direccion'     => 'nullable|string',
            'estado'        => 'sometimes|required|in:activo,inactivo'
        ]);

        // Actualizamos el cliente con los datos validados
        $cliente->update($validatedData);

        return response()->json($cliente);
    }

    /**
     * Elimina un cliente.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        // Devolvemos una respuesta vacía con código 204 (No Content)
        return response()->noContent();
    }
}