<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Categories extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {

        if( strlen($this->search) > 0 )
            $categories = Category::where('name', 'like', '%'. $this->search .'%')->paginate($this->pagination);
        else
            $categories = Category::orderBy('id', 'desc')->paginate($this->pagination);


        return view('livewire.category.categories', compact('categories'))
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function edit($id){
        $record = Category::find($id, ['id','name','image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'Show Modal!');
    }
    public function Store(){
        $rules = [
            'name' => 'required|unique:categories|min:3'
        ];

        $messages = [
            'name.required' => 'Nombre de la categoria es requerido',
            'name.unique' => 'Ya existe el nombre de la categoria',
            'name.min' => 'El nombre de la categoria debe tener al menos 3 caracteres',
        ];
        $this->validate($rules, $messages);

        $category = Category::create([
            'name' => $this->name, // ? el nombre del wire:model.lazy="name"
        ]);

        // $customFileName;
        if($this->image){
            $customFileName = uniqid(). '_.'. $this->image->extension();
            $this->image->storeAs('public/categorias', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }

        $this->resetUI();
        $this->emit('category-added', 'Categoría Registrada!');
    }

    public function resetUI(){
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }

    public function Update(){
        $rules = [
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}"
        ];

        $messages = [
            'name.required' => 'Nombre de categoria requerido',
            'name.min' => 'Nombre de categoria debe tener al menos 3 caracteres',
            'name.unique' => 'Nombre de la categoria ya existe',
        ];

        $this->validate($rules, $messages);

        $category = Category::find($this->selected_id);
        // $category->name = $this->name;
        // $category->update();
        $category->update([
            'name' => $this->name
        ]);

        if($this->image){
            $customFileName = uniqid(). '_.'. $this->image->extension();
            $this->image->storeAs('public/categorias', $customFileName);
            $imageName = $category->image;

            $category->image = $customFileName;
            $category->save();

            if($imageName != null){
                if(file_exists('storage/categorias'.$imageName)){
                    unlink('storage/categorias'.$imageName);
                }
            }
        }
        $this->resetUI();
        $this->emit('category-updated', 'Categoría Actualizada!');
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Category $category){ // ? Buscamos el objeto desde el parametro recibido
        // $category = Category::find($id); 
        $imageName = $category->image;
        $category->delete();

        if($imageName){
            unlink('storage/categorias/'.$imageName);
        }
        $this->resetUI();
        $this->emit('category-deleted', 'Categoría Eliminada!');

    }
}
