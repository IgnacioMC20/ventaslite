<?php

namespace App\Http\Livewire;

use App\Models\Denomitaion;
use App\Models\Product;
use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleDetail;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class Pos extends Component
{
    public $total, $itemsQuantity, $change, $efectivo;
    public function mount(){
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }
    public function render()
    {
        $this->denominations = Denomitaion::all();
        return view('livewire.pos.component', [
            'denominations' => Denomitaion::orderBy('value', 'desc')->get(),
            'cart' => Cart::getContent()->sortBy('name'),
        ])->extends('layouts.theme.app')->section('content');
    }

    public function ACash($value){
        $this->efectivo += ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
    }

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale',
    ];

    public function ScanCode($barcode, $cant = 1){
        $product = Product::where('barcode', $barcode)->first();
        if($product == null || empty($product)){
            $this->emit('scan-notFound', 'El Producto no esta registrado');
        }else{
            if($this->InCart($product->id)){
                $this->increaseQty($product->id);
                return;
            }
            if($product->stock < 1 ){
                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }

            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();

            $this->emit('scan-ok', 'Producto Agregado');
        }
    }

    public function InCart($product_id){
        $exist = Cart::get($product_id);
        if($exist){
            return true;
        }else{
            return false;
        }
    }
    public function increaseQty($product_id, $cant = 1){
        $title = '';
        $product = Product::find($product_id);
        $exist = Cart::get($product_id);

        if($exist) $title = 'Cantidad Actualizada';
        else $title = 'Producto Agregado';

        if($exist){
            if($product->stock < ($cant + $exist->quantity)){
                $this->emit('no-stock','Stock Insuficiente :(');
                return;
            }
        }

        Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', $title);


    }

    public function updateQty($product_id, $cant = 1){
        $title = '';
        $product = Product::find($product_id);
        $exist = Cart::get($product_id);

        if($exist) $title = 'Cantidad Actualizada';
        else $title = 'Producto Agregado';

        if($exist){
            if($product->stock < $cant){
                $this->emit('no-stock','Stock Insuficiente :(');
                return;
            }
        }

        $this->removeItem($product_id);
        if($cant > 0){
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
    
            $this->emit('scan-ok', $title);
        }
    }

    public function removeItem($product_id){
        Cart::remove($product_id);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Producto Eliminado');
    }

    public function decreaseQty($product_id){
        $item = Cart::get($product_id);
        Cart::remove($product_id);

        $newQty = ($item->quantity) - 1;
        if($newQty > 0){
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);
        }

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Cantidad Actualizada');
    }

    public function clearCart(){
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Carrito Vacio');


    }

    public function saveSale(){
        if($this->total <= 0){
            $this->emit('sale-error', 'Agrega Productos a la venta');
            return;
        }
        if($this->efectivo <= 0){
            $this->emit('sale-error', 'Ingresa el Efectivo');
            return;
        }
        if($this->total > $this->efectivo){
            $this->emit('sale-error', 'El efectivo debe eser mayot o igual al orignial');
            return;
        }

        DB::beginTransaction();
        
        try {
           $sale = Sale::create([
               'total' => $this->total,
               'items' => $this->itemsQuantity,
               'cash' => $this->efectivo,
               'change' => $this->change,
               'user_id' => auth()->user()->id,
           ]);
           if($sale){
               $items = Cart::getContent();
               foreach ($items as $item) {
                   SaleDetail::creat([
                       'price' => $item->price,
                       'quantity' => $item->quantity,
                       'product_id' => $item->quantity,
                       'sale' => $item->id,
                   ]);
                   // ? Update Stock
                   $product = Product::find($item->id);
                   $product->stock = $product->stock - $item->quantity;
                   $product->save();
               }
           }

           DB::commit();

           Cart::clear();
           $this->efectivo = 0;
           $this->change = 0;
           $this->total = Cart::getTotal();
           $this->itemsQuantity = Cart::getTotalQuantity();
           $this->emit('sale-ok', 'Venta registrada con éxito');
           $this->emit('print-ticket', $sale->id);

        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('print-ticket', $e->getMessage());
        }
    }

    public function printTicekt($sale){
        return Redirect::to("print://$sale->id");
    }
}
