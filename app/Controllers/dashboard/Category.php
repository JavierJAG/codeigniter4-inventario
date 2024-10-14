<?php

namespace App\Controllers\Dashboard;

use CodeIgniter\RESTful\ResourceController;

class Category extends ResourceController
{
    protected $modelName = 'App\Models\CategoryModel';
    protected $format    = 'json';

    // Listar todas las categorías
    public function index()
    {
        $data['categories'] = $this->model->findAll();
        return view('/dashboard/category/index', $data); // Retornar la vista con los datos
    }

    // Mostrar formulario de creación de categoría
    public function new()
    {
        return view('/dashboard/category/new'); // Retornar la vista del formulario
    }

    // Crear nueva categoría
    public function create()
    {
        $data = $this->request->getPost();  // Obtener los datos del formulario

        if ($this->model->insert($data)) {
            return redirect()->to('/dashboard/category')->with('success', 'Categoría creada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
    }

    // Mostrar formulario de edición de categoría
    public function edit($id = null)
    {
        $data['category'] = $this->model->find($id);

        if (!$data['category']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Categoría no encontrada');
        }

        return view('/dashboard/category/edit', $data); // Retornar la vista del formulario de edición
    }

    // Actualizar una categoría existente
    public function update($id = null)
    {
        $data = $this->request->getPost();  // Obtener los datos del formulario

        if ($this->model->update($id, $data)) {
            return redirect()->to('/dashboard/category')->with('success', 'Categoría actualizada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
    }

    // Eliminar una categoría
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return redirect()->to('/dashboard/category')->with('success', 'Categoría eliminada exitosamente');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar la categoría');
        }
    }

    // Mostrar una categoría específica
    public function show($id = null)
    {
        $data['category'] = $this->model->find($id);

        if (!$data['category']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Categoría no encontrada');
        }

        return view('/dashboard/category/show', $data);
    }
}
