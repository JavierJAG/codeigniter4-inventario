<?php

namespace App\Controllers\dashboard;

use App\Database\Migrations\ProductTag;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductsControlModel;
use App\Models\ProductTagModel;
use App\Models\ProductUserControlModel;
use App\Models\TagModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\RESTful\ResourceController;
use Dompdf\Dompdf;
use Exception;

class Product extends ResourceController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format    = 'json';
    use ResponseTrait;

    // Listar todas las categorías
    public function index()
    {
        $categoryModel = new CategoryModel();
        $userModel = new UserModel();
        $tagModel = new TagModel();
        $category_id = $this->request->getGet('category_id');
        $tags_id = $this->request->getGet('tags_id') ?: []; // Recibir múltiples tags seleccionados
    
        // Iniciar la construcción de la consulta
        $query = $this->model;
    
        // Filtrar por categoría si se selecciona una
        if ($category_id) {
            $query = $query->where('category_id', $category_id);
        }
    
        // Filtrar por etiquetas si existen
        if (!empty($tags_id)) {
            $query = $query->join('product_tag as pt', 'pt.product_id = products.id')
                           ->whereIn('pt.tag_id', $tags_id)
                           ->groupBy('products.id, products.code, products.exit, products.entry, products.stock, products.price, products.name, pt.tag_id');  // Aseguramos que solo se agrupe por el ID del producto
        }
    
        // Ejecutar la consulta y obtener los productos filtrados
        $products = $query->findAll();
    
        // Preparar los datos para la vista
        $data = [
            'categories' => $categoryModel->findAll(),
            'tags' => $tagModel->findAll(), // Obtener todas las etiquetas disponibles
            'category_id' => $category_id,  // Mantener la categoría seleccionada
            'productTags' => $tags_id,      // Mantener las etiquetas seleccionadas
            'products' => $products,        // Productos filtrados
            'users' => $userModel->where('type', 'customer')->findAll()
        ];
    
        return view('/dashboard/product/index', $data);
    }
    
    

    // Mostrar formulario de creación de categoría
    public function new()
    {
        $categoryModel = new CategoryModel();
        $tagModel = new TagModel();
        $data = [
            'categories' => $categoryModel->findAll(),
            'tags' => $tagModel->findAll()
        ];
        return view('/dashboard/product/new', $data); // Retornar la vista del formulario
    }

    // Crear nueva categoría
    public function create()
    {
        $productTagModel = new ProductTagModel();
        $validation = \Config\Services::validation();
        $tags = $this->request->getPost('tag_id') ?: [];

        // Definir las reglas de validación para cada campo
        $validation->setRules([
            'name' => 'required',
            'code' => 'required|max_length[10]',
            'description' => 'permit_empty',
            'entry' => 'required|integer',
            'exit' => 'required|integer',
            'stock' => 'required|integer',
            'price' => 'required|decimal'
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Recoger los datos del formulario
        $id = $this->model->insert([
            'name' => $this->request->getPost('name'),
            'code' => $this->request->getPost('code'),
            'description' => $this->request->getPost('description'),
            'entry' => $this->request->getPost('entry'),
            'exit' => $this->request->getPost('exit'),
            'stock' => $this->request->getPost('stock'),
            'price' => $this->request->getPost('price'),
            'category_id' => $this->request->getPost('category_id')
        ]);
        foreach ($tags as $t) {
            $productTagModel->insert([
                'product_id' => $id,
                'tag_id' => $t
            ]);
        }


        return redirect()->to('/dashboard/product')->with('message', 'Producto creado correctamente');
    }

    // Mostrar formulario de edición de categoría
    public function edit($id = null)
    {

        $productTagModel = new ProductTagModel();
        $productTags = array_column($productTagModel->asArray()->select('tag_id')->where('product_id', $id)->findAll(), 'tag_id');
        $categoryModel = new CategoryModel();
        $tagModel = new TagModel();
        $data = [
            'product' => $this->model->find($id),
            'categories' => $categoryModel->findAll(),
            'tags' => $tagModel->findAll(),
            'productTags' => $productTags
        ];

        if (!$data['product']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Etiqueta no encontrada');
        }

        return view('/dashboard/product/edit', $data); // Retornar la vista del formulario de edición
    }

    // Actualizar una categoría existente
    public function update($id = null)
    {
        $productTagModel = new ProductTagModel();
        // Verificar si el producto existe
        if ($id === null || !$product = $this->model->find($id)) {
            return redirect()->to('/dashboard/product')->with('error', 'Producto no encontrado');
        }

        // Validar los datos del formulario
        $validation = $this->validate([
            'name' => 'required',
            'code' => 'required',
            'description' => 'permit_empty',
            'entry' => 'required|integer',
            'exit' => 'required|integer',
            'stock' => 'required|integer',
            'price' => 'required|decimal',
        ]);

        if (!$validation) {
            // Redirigir de vuelta al formulario con los errores de validación
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $tags = $this->request->getPost('tag_id') ?: [];
        // Actualizar el producto en la base de datos
        $this->model->update($id, [
            'name' => $this->request->getPost('name'),
            'code' => $this->request->getPost('code'),
            'description' => $this->request->getPost('description'),
            'entry' => $this->request->getPost('entry'),
            'exit' => $this->request->getPost('exit'),
            'stock' => $this->request->getPost('stock'),
            'price' => $this->request->getPost('price'),
            'category_id' => $this->request->getPost('category_id'),

        ]);
        $productTagModel
            ->whereNotIn('tag_id', $tags)
            ->where('product_id', $id)
            ->delete();
        foreach ($tags as $t) {
            $exists = $productTagModel->where('product_id', $id)
                ->where('tag_id', $t)
                ->first();

            if (!$exists) {
                // Si no existe, insertamos la nueva relación
                try {
                    $productTagModel->insert([
                        'product_id' => $id,
                        'tag_id' => $t
                    ]);
                } catch (Exception $e) {
                }
            }
        }
        return redirect()->to('/dashboard/product')->with('success', 'Producto actualizado exitosamente');
    }


    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return redirect()->to('/dashboard/product')->with('success', 'Etiqueta eliminada exitosamente');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar la categoría');
        }
    }

    // Mostrar una categoría específica
    public function show($id = null)
    {
        $data['product'] = $this->model->find($id);

        if (!$data['product']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Etiqueta no encontrada');
        }

        return view('/dashboard/product/show', $data);
    }
    public function demoPdf()
    {
        $domPDF = new Dompdf();
        // $domPDF->loadHtml('<h1>Hola Mundo</h1>');
        $productId = 10;
        $product = $this->model->find($productId);
        if ($product == null) {
            return redirect()->back()->with('mensaje', 'No existe el producto');
        }
        $query = $this->model->select("pc.*,u.email,puc.description,puc.direction")
            ->join('products_control as pc', 'pc.product_id = products.id')
            ->join('users as u', 'pc.user_id = u.id')
            ->join('products_users_control as puc', 'pc.id = puc.product_control_id');


        $data = [
            'product' => $product,
            'trace' => $query
                ->where('products.id', $productId)
                ->find()
        ];
        $html = view('dashboard/product/trace_pdf',  [
            'trace' => $data
        ]);
        $domPDF->loadHTML($html);


        $domPDF->setPaper('A4', 'portrait');
        $domPDF->render();
        $domPDF->stream();
    }

    public function addStock($id, $entry)
    {
        $validation = \Config\Services::validation();
        if (!$validation->check($entry, 'required|is_natural_no_zero')) {
            return $this->failValidationErrors('Cantidad no válida');
        }
        $productModel = new ProductModel();
        $productsControlModel = new ProductsControlModel();
        $productUserControlModel = new ProductUserControlModel();


        $product = $productModel->find($id);
        $userID = $this->request->getPost('user_id');
        $validate = $this->validate([
            'user_id' => 'required',
            'direction' => 'required',
            'description' => 'required'
        ]);

        if (!$validate) {
            return $this->failValidationErrors('Request no válido');
        }


        if ($product == null) {
            throw PageNotFoundException::forPageNotFound();
        }
        $product->stock += $entry;
        $productModel->update($id, [
            'stock' => $product->stock
        ]);

        $productControlId = $productsControlModel->insert([
            'product_id' => $id,
            'count' => $entry,
            'type' => 'entry',
            'user_id' => $userID
        ]);
        $productUserControlModel->insert([
            'product_control_id' => $productControlId,
            'description' => $this->request->getPost('description'),
            'direction' => $this->request->getPost('direction'),
        ]);

        return $this->respondUpdated($product);
    }
    public function exitStock($id, $exit)
    {
        $productModel = new ProductModel();
        $productsControlModel = new ProductsControlModel();
        $productUserControlModel = new ProductUserControlModel();
        $product = $productModel->find($id);
        $userID = $this->request->getPost('user_id');
        $validate = $this->validate([
            'user_id' => 'required',
            'direction' => 'required',
            'description' => 'required'
        ]);

        if (!$validate) {
            return $this->failValidationErrors('Request no válido');
        }
        if ($product == null) {
            throw PageNotFoundException::forPageNotFound();
        }
        if (($product->stock - $exit) < 0) {
            return $this->failValidationErrors('No hay stock');
        }
        $product->stock -= $exit;
        $productModel->update($id, [
            'stock' => $product->stock
        ]);
        $productControlId = $productsControlModel->insert([
            'product_id' => $id,
            'count' => $exit,
            'type' => 'exit',
            'user_id' => $userID
        ]);
        $productUserControlModel->insert([
            'product_control_id' => $productControlId,
            'description' => $this->request->getPost('description'),
            'direction' => $this->request->getPost('direction'),
        ]);

        return $this->respondUpdated($product);
    }
    public function trace($productId)
    {
        $product = $this->model->find($productId);
        $userModel = new UserModel();
        if ($product == null) {
            return redirect()->back()->with('mensaje', 'No existe el producto');
        }
        $query = $this->model->select("pc.*,u.email,puc.description,puc.direction")
            ->join('products_control as pc', 'pc.product_id = products.id')
            ->join('users as u', 'pc.user_id = u.id')
            ->join('products_users_control as puc', 'pc.id = puc.product_control_id');

        $type = $this->request->getGet('type');
        if ($type !== "" && ($type == "entry" || $type == "exit")) {
            $query = $query->where('pc.type', $type);
        } else {
            $type = "";
        }
        if ($type == "exit") {
            $users = $userModel->where('type', 'customer')->find();
        } else if ($type == "entry") {
            $users = $userModel->where('type', 'provider')->find();
        } else {
            $users = $userModel->find();
        }

        $userId = intval($this->request->getGet('user_id'));
        if ($userId !== "" && $userId > 0) {
            $query = $query->where('pc.user_id', $userId);
        } else {
            $userId = "";
        }
        if ($this->request->getGet('check_cant')) {
            $minCount = $this->request->getGet('min_count');
            $maxCount = $this->request->getGet('max_count');
        }
        if (!empty($minCount)) {
            $query = $query->where('pc.count >=', $minCount);
        }
        if (!empty($maxCount)) {
            $query = $query->where('pc.count <=', $maxCount);
        }
        $search = explode(" ", trim($this->request->getGet('search')));
        if ($this->request->getGet('search')) {
            $query = $query->GroupStart();
            foreach ($search as $s) {
                $query = $query->orLike('u.username', $s)
                    ->orLike('u.email', $s)
                    ->orLike('puc.description', $s);
            }

            $query->groupEnd();
        }

        $data = [
            'product' => $product,
            'type' => $type,
            'users' => $users,
            'user_id' => $userId,
            'search' => $this->request->getGet('search'),
            'check_cant' => $this->request->getGet('check_cant'),
            'min_cant' => $this->request->getGet('min_cant'),
            'max_cant' => $this->request->getGet('max_cant'),
            'trace' => $query
                ->where('products.id', $productId)
                ->find()
        ];

        return view('/dashboard/product/trace', [
            'trace' => $data
        ]);
    }
}
