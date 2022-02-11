<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Products extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $barcode, $cost, $price, $stock, $alerts, $category_id, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function paginationView(){
        return 'vendor.livewire.bootstrap';
    }

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->category_id = 'Elegir';
    }

    public function render()
    {

        if(strlen($this->search) > 0 ) 
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                        ->select('products.*', 'c.name as category')
                        ->where('products.name', 'like', '%'. $this->search .'%')
                        ->orWhere('products.barcode', 'like', '%'. $this->search .'%')
                        ->orWhere('c.name', 'like', '%'. $this->search .'%')
                        ->orderBy('products.name', 'asc')
                        ->paginate($this->pagination);

        else $products = Product::join('categories as c', 'c.id', 'products.category_id')
                        ->select('products.*', 'c.name as category')
                        ->orderBy('products.name', 'asc')
                        ->paginate($this->pagination);

        return view('livewire.products.component',[
            'products' => $products,
            'categories' => Category::orderBy('name', 'asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Store(){
        $rules = [
            'name' => 'required|unique:products|min:3',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'category_id' => 'required|not_in:Elegir',
        ];

        $messages = [
            'name.required' => 'Nombre del producto requerido',
            'name.unique' => 'Ya existe el nombre del producto',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'cost.required' => 'Costo del producto es requerido',
            'price.required' => 'Precio del producto es requerido',
            'stock.required' => 'Stock del producto es requerido',
            'alerts.required' => 'Ingrese el valor minimo en existencias',
            'category_id.not_in' => 'Elige un nombre de la categoria diferente de Elegir',
        ];

        $this->validate($rules, $messages);

        $product = Product::create([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->category_id,
        ]);

        if($this->image){
            $customFileName = uniqid(). '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }
        $this->resetUI();
        $this->emmit('product-added','Producto Registrado');
    }

    public function editarProducto(Product $product){
        $this->selected_id = $product->id;
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alerts = $product->alerts;
        $this->category_id = $product->category_id;
        $this->image = null;
        
        $this->emit('show-modal', 'Show Modal');

    }

    public function Update(){
        $rules = [
            'name' => "required|min:3|unique:products,name,{$this->selected_id}",
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'category_id' => 'required|not_in:Elegir',
        ];

        $messages = [
            'name.required' => 'Nombre del producto requerido',
            'name.unique' => 'Ya existe el nombre del producto',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'cost.required' => 'Costo del producto es requerido',
            'price.required' => 'Precio del producto es requerido',
            'stock.required' => 'Stock del producto es requerido',
            'alerts.required' => 'Ingrese el valor minimo en existencias',
            'category_id.not_in' => 'Elige un nombre de la categoria diferente de Elegir',
        ];

        $this->validate($rules, $messages);

        $product = Product::find($this->selected_id);    
        $product->update([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->category_id,
        ]);

        $imageTemp = null; 

        if($this->image){
            $customFileName = uniqid(). '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $imageTemp = $product->image;
            $product->image = $customFileName;
            $product->save();
        }

        if($imageTemp){
            if(file_exists('storage/products/'.$imageTemp)){
                unlink('storage/products/'.$imageTemp);
            }
        }
        $this->resetUI();
        $this->emit('product-updated','Producto Actualizado');
    }



    public function resetUI(){

        $this->name = null;
        $this->cost = null;
        $this->price = null;
        $this->barcode = null;
        $this->stock = null;
        $this->alerts = null;
        $this->category_id = null;
        $this->image = null;
        $this->search = null;
        $this->selected_id = 0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Product $product){
        $imageTemp = $product->image;
        $product->delete();
        if($imageTemp){
            if(file_exists('storage/products/'.$imageTemp)){
                unlink('storage/products/'.$imageTemp);
            }
        }
        $this->resetUI();
        $this->emit('product-deleted', 'Producto Eliminado');
    }    


}
