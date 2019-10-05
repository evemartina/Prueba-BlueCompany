<?php

namespace App\Http\Controllers;

use App\Productos;
use App\Categorias;
use App\CategoriasProductos;
use Illuminate\Http\Request;

class ProductosController extends Controller{

    public function index(){

        $product = Productos::all();

        if(!empty($product->toArray())){
            return json_encode(array('status'=>'ok','data'=>$product->toArray()));
        }else{
            return json_encode(array('status'=>'No hay productos registrados.','data'=>[]));
        }
    }

    public function listarProductos(){

         $productos = Productos::with('Categorias')->get();
         // print_r($productos->toArray());
         // die();
         $categoria = Categorias::All();
        return view('productos.lista')->with(compact('productos','categoria'));
    }


    public function show($id){

        $product = Productos::find($id);

        if(!empty($product)){
            return json_encode(array('status'=>'ok','data'=>$product->toArray()));
        }else{
            return json_encode(array('status'=>'Producto no encontrado.','data'=>[]));
        }

    }


    public function guardar(){
        $request  = request()->all();
        $producto = new Productos();
        $producto->nombre           = $request['nombre'];
        $producto->valor            = $request['valor'];
        if (!empty($request['fecha_expiracion'])){
            $producto->fecha_expiracion =$request['fecha_expiracion'];
        }

        if($producto->save()){
            foreach ($request['categoria'] as $id) {
               $cat_prod = new CategoriasProductos();
               $cat_prod->productos_id  = $producto->id;
               $cat_prod->categorias_id = $id;
               $cat_prod->save();
            }
            return response()->json(['status'=>true,'mensaje'=>'Producto guardado exitosamente.']);
        }else{
            return response()->json(['status'=>fasle,'mensaje'=>'Error.']);

        }
    }


    public function eliminar(){
        $request = request()->all();
        $id      =  $request['id'];
        if(Productos::destroy($id)){
            return response()->json(['status'=>true,'mensaje'=>'Producto Eliminado exitosamente.']);
        }else{
          return response()->json(['status'=>fasle,'mensaje'=>'Error.']);

        }
    }
}
