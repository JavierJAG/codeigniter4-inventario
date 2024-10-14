<?php

namespace App\Controllers\dashboard;

use CodeIgniter\RESTful\ResourceController;

class Tag extends ResourceController
{
    protected $modelName = 'App\Models\tagModel';
    protected $format    = 'json';

    // Listar todas las categorías
    public function index()
    {
        $data['tags'] = $this->model->findAll();
        return view('/dashboard/tag/index', $data); // Retornar la vista con los datos
    }

    // Mostrar formulario de creación de categoría
    public function new()
    {
        return view('/dashboard/tag/new'); // Retornar la vista del formulario
    }

    // Crear nueva categoría
    public function create()
    {
        $data = $this->request->getPost();  // Obtener los datos del formulario

        if ($this->model->insert($data)) {
            return redirect()->to('/dashboard/tag')->with('success', 'Etiqueta creada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
    }

    // Mostrar formulario de edición de categoría
    public function edit($id = null)
    {
        $data['tag'] = $this->model->find($id);

        if (!$data['tag']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Etiqueta no encontrada');
        }

        return view('/dashboard/tag/edit', $data); // Retornar la vista del formulario de edición
    }

    // Actualizar una categoría existente
    public function update($id = null)
    {
        $data = $this->request->getPost();  // Obtener los datos del formulario

        if ($this->model->update($id, $data)) {
            return redirect()->to('/dashboard/tag')->with('success', 'Etiqueta actualizada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
    }

    // Eliminar una categoría
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return redirect()->to('/dashboard/tag')->with('success', 'Etiqueta eliminada exitosamente');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar la categoría');
        }
    }

    // Mostrar una categoría específica
    public function show($id = null)
    {
        $data['tag'] = $this->model->find($id);

        if (!$data['tag']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Etiqueta no encontrada');
        }

        return view('/dashboard/tag/show', $data);
    }
}
