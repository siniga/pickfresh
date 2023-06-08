<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        //

    }

    public function getProductsByOrderId($orderId){
        $products = Product::join('order_products','products.id','order_products.product_id')
          ->where('order_products.order_id', $orderId)->get();

        return response($products, 200);
    }

    public function getBusinessProducts( $bid, $cid, $specialId ) {
        //get all products based on business and category
        if ( $cid == 0 ) {
            $products = Product::join( 'categories', 'categories.id', 'products.category_id' )
            ->join( 'product_units', 'products.id', 'product_units.product_id' )
            ->join( 'units', 'units.id', 'product_units.unit_id' )
            ->select( 'products.id', 'products.id as serverId', 'products.name', 'products.price',
            'products.stock', 'products.cost', 'products.img', 'products.category_id as categoryId', 'categories.name as category','units.id as unit_id', 'units.name as unit' )
            ->where( 'categories.business_id', $bid )
            ->orderBy( 'products.id', 'desc' )
            ->get();
        } else {
            $products = Product::join( 'categories', 'categories.id', 'products.category_id' )
            ->join( 'product_units', 'products.id', 'product_units.product_id' )
            ->join( 'units', 'units.id', 'product_units.unit_id' )
            ->select( 'products.id', 'products.id as serverId', 'products.name', 'products.price',
            'products.stock', 'products.cost', 'products.img', 'products.category_id as categoryId', 'categories.name as category','units.id as unit_id','units.name as unit' )
            ->where( 'categories.business_id', $bid )
            ->where( 'categories.id', $cid )
            ->orderBy( 'products.id', 'desc' )
            ->get();
        }

        return response( [ 'products'=> $products, 'special_products'=>$this->getBusinessSpecialProducts( $bid, $cid, $specialId ) ], 200 );
    }

    public function getBusinessSpecialProducts( $bid, $cid, $specialId ) {
        //only get special products
        $products = Product::join( 'categories', 'categories.id', 'products.category_id' )
        ->join( 'product_units', 'products.id', 'product_units.product_id' )
        ->join( 'units', 'units.id', 'product_units.unit_id' )
        ->select( 'products.id', 'products.id as serverId', 'products.name', 'products.price',
        'products.stock', 'products.cost', 'products.img', 'products.category_id as categoryId', 'categories.name as category', 'units.id as unit_id','units.name as unit' )
        ->where( 'categories.business_id', $bid )
        ->where( 'categories.id', $specialId )
        ->orderBy( 'products.id', 'desc' )
        ->get();

        return $products;
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \App\Http\Requests\StoreProductRequest  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {

        $validatedData = $request->validate( [
            'file' => 'required|image|mimes:jpeg,jpg,png,gif',
        ] );

        if ( !empty( request()->file( 'file' ) ) ) {

            $doc = request()->file( 'file' );
            $uplodedDoc = $doc->store( 'uploads' );

            //get original file name
            $originalFileName =  request()->file( 'file' )
            ->getClientOriginalName();

            //get file extention
            $extension = $doc->getClientOriginalExtension();

        } else {
            $uplodedDoc = $request->img;
        }

        $product = new Product;
        $product->name = $request->name;
        $product->cost = $request->cost;
        $product->price =  $request->price;
        $product->stock = $request->stock;
        $product->cost = $request->cost;
        $product->category_id = $request->category_id;
        $product->img = $uplodedDoc;

        if ( $product->save() ) {

            //convert sku to array
            $skus = ( array ) $request->skus;
            foreach ( $skus as $sku ) {
                $this->attachProductToSku( $product->id, $sku );
            }

            $units = ( array ) $request->units;
            foreach ( $units as $unit ) {
                $this->attachProductToUnit( $product->id, $unit );
            }

            return response( [ 'product'=> $product ], 201 );
        }

    }

    public function update( Request $request ) {
        if ( !empty( request()->file( 'file' ) ) ) {

            $doc = request()->file( 'file' );
            $uplodedDoc = $doc->store( 'uploads' );

            //get original file name
            $originalFileName =  request()->file( 'file' )
            ->getClientOriginalName();

            //get file extention
            $extension = $doc->getClientOriginalExtension();

        } else {
            $uplodedDoc = $request->img;
        }

        return $uplodedDoc;

        $product = Product::findOrFail( $request->id );
        $product->name = $request->name;
        $product->cost = $request->cost;
        $product->price =  $request->price;
        $product->stock = $request->stock;
        $product->cost = $request->cost;
        $product->category_id = $request->category_id;
        $product->img = $uplodedDoc;

        if ( $product->save() ) {

            //convert sku to array
            $skus = ( array ) $request->skus;
            foreach ( $skus as $sku ) {
                $this->attachProductToSku( $product->id, $sku );
            }

            $units = ( array ) $request->units;
            foreach ( $units as $unit ) {
                $this->attachProductToUnit( $product->id, $unit );
            }

            return response( [ 'product'=> $product ], 201 );
        }

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Product  $product
    * @return \Illuminate\Http\Response
    */

    public function destroy( $pid ) {
        $product = Product::findOrfail( $pid );
        $productUnit = $product->units;
        $productSku = $product->skus;
        $productOrder = $product->orders;

        if ( count( $productUnit ) > 0 )
        $product->units()->detach();

        if ( count( $productSku ) > 0 )
        $product->skus()->detach();

        if ( $productOrder && count( $productOrder ) > 0 )
        $product->orders()->detach();

        if ( $product->delete() ) {

            return response( $product, 200 );
        }
    }

    public function attachProductToSku( $pid, $sid ) {

        $product = Product::findOrFail( $pid );

        $product->skus()->syncWithoutDetaching( $sid );

    }

    public function attachProductToUnit( $pid, $uid ) {

        $product = Product::findOrFail( $pid );

        $product->units()->syncWithoutDetaching( $uid );

    }
}
