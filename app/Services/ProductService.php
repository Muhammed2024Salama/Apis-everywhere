<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProducts()
    {
        return Product::all();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getProduct(int $id)
    {
        return Product::find($id)->first();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createProduct($data)
    {
        return Product::create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function updateProduct($id,$data)
    {
        $product=$this->getProduct($id);
        $product->title=$data['title'];
        $product->description=$data['description'];
        $product->user_id=$data['user_id'];
        $product->details->size=$data['size'];
        $product->details->color=$data['color'];
        $product->details->price=$data['price'];
        $product->save();
        return $product;
    }

    /**
     * @param $id
     * @return void
     */
    public function deleteProduct($id)
    {
        $product=$this->getProduct($id);
        if($product->details){
            $product->details()->delete();
        }
        if($product->reviews){
            $product->reviews()->delete();
        }
        if($product->imagable){
            $product->imagable()->delete();
        }
        $product->delete();
    }
}
