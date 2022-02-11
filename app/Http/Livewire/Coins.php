<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Denomitaion;

class Coins extends Component
{
    use WithPagination;
    use WithFileUploads;


    public $componentName, $pageTitle, $selected_id, $image, $search, $type, $value;
    private $pagination = 5;

    public function mount(){
        $this->componentName = 'Denominaciones';
        $this->pageTitle = 'Listado';
        $this->selected_id = 0;
    }
    public function paginationView(){
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if( strlen($this->search) > 0 )
            $coins = Denomitaion::where('type', 'like', '%'. $this->search .'%')->paginate($this->pagination);
        else
            $coins = Denomitaion::orderBy('id', 'desc')->paginate($this->pagination);
        return view('livewire.denomination.component',compact('coins'))->extends('layouts.theme.app')->section('content');
    }

    public function edit($id){
        $record = Denomitaion::find($id, ['id','type','image']);
        $this->type = $record->type;
        $this->value = $record->value;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'Show Modal!');
    }
    public function Store(){
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => 'required|unique:denominations',
        ];

        $messages = [
            'type.required' => 'El tipo es requerido',
            'type.not_in' => 'Elige un valor distinto a Elegir',
            'value.required' => 'El valor es requerido',
            'value.unique' => 'El valor ya existe',
        ];
        $this->validate($rules, $messages);

        $denomination = Denomitaion::create([
            'type' => $this->type, // ? el nombre del wire:model.lazy="name"
            'value' => $this->value, 
        ]);

        // $customFileName;
        if($this->image){
            $customFileName = uniqid(). '_.'. $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $denomination->image = $customFileName;
            $denomination->save();
        }

        $this->resetUI();
        $this->emit('denomination-added', 'Denominacion Registrada!');
    }

    public function resetUI(){
        $this->type = '';
        $this->value = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }

    public function Update(){
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => "required|unique:denominations,value,{$this->selected_id}",
        ];

        $messages = [
            'type.required' => 'El tipo es requerido',
            'type.not_in' => 'Elige un valor distinto a Elegir',
            'value.required' => 'El valor es requerido',
            'value.unique' => 'El valor ya existe',
        ];

        $this->validate($rules, $messages);

        $denomination = Denomitaion::find($this->selected_id);
        // $denomination->name = $this->name;
        // $denomination->update();
        $denomination->update([
            'value' => $this->value,
            'type' => $this->type
        ]);

        if($this->image){
            $customFileName = uniqid(). '_.'. $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $imageName = $denomination->image;

            $denomination->image = $customFileName;
            $denomination->save();

            if($imageName != null){
                if(file_exists('storage/denominations'.$imageName)){
                    unlink('storage/denominations'.$imageName);
                }
            }
        }
        $this->resetUI();
        $this->emit('denomination-updated', 'Denominacion Actualizada!');
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Denomination $denomination){ // ? Buscamos el objeto desde el parametro recibido
        // $denomination = denominat$Denomitaion::find($id); 
        $imageName = $denomination->image;
        $denomination->delete();

        if($imageName){
            unlink('storage/categorias/'.$imageName);
        }
        $this->resetUI();
        $this->emit('denomination-deleted', 'Categoría Eliminada!');

    }
}
