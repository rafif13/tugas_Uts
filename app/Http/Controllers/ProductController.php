<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product; //1

class ProductController extends Controller
{


    public function index()
    {


            $products = Product::orderBY('created_at','DESC')->get(); //2
             // Code diatas sama dengan >select *from 'products 'order by' com_create_guid 
            return view ('products.index',compact ('products'));


    }

    public function create ()
        {
            return view('products.create');
        }


            public function save(Request $request )
            {
            //Melakukan validasi data yang dikirim form inputan 

            $this->validate($request, [
                'title'=> 'required|string|max:100',
                'description'=>'required|string',
                'price' => 'required|integer',
                'stock' =>'required|integer'
            ]);

            try{
                $product = Product::create([
                    'title' => $request-> title,
                    'description' => $request-> description,
                    'price' => $request-> price,
                    'stock' => $request-> stock
                ]);


                return redirect ('/product')->with(['success' => '<strong>' . $product-> title. '</strong> telah disimpan']);
            }catch(\Exception $e)  {

                return redirect ('/product/new') ->with (['error'=>$e ->getMessage()]);
             }
        }
    


        public function edit($id)
        {
            $product= Product::find($id);
            return view ('products.edit', compact('product'));
        }   

        public function update(Request $request, $id)
        { 
            $product = Product::find($id);
            $product-> update ([
                'title' =>$request->title,
                'description' =>$request->description,
                'price' =>$request->price,
                'stock' =>$request->stock,

            ]);
return redirect ('/product')-> with (['success' => '<strong>' .$product->title. '</strong> Diperbaharui ']);
        }
        
        public function destroy($id)
{
    $product = Product::find($id); //QUERY KEDATABASE UNTUK MENGAMBIL DATA BERDASARKAN ID
    $product->delete(); // MENGHAPUS DATA YANG ADA DIDATABASE
    return redirect('/product')->with(['success' => '</strong>' . $product->title . '</strong> Dihapus']); // DIARAHKAN KEMBALI KEHALAMAN /product
}
    
    }
    