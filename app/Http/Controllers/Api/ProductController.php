<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Review;
use App\Requests\Product\CreateProductValidator;
use App\Requests\Product\UpdateProductValidator;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;

class ProductController extends BaseController
{
    /**
     * @var ProductService
     */
    public $productService;

    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @return void
     */
    public function index()
    {
        return $this->productService->getProducts();
    }

    /**
     * @param CreateProductValidator $createProductValidator
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateProductValidator $createProductValidator)
    {
        if(!empty($createProductValidator->getErrors())){
            return response()->json($createProductValidator->getErrors(),406);
        }
        $data=$createProductValidator->request()->all();
        $data['user_id']=Auth::user()->id;
        $response=$this->productService->createProduct($data);
        return $this->sendResponse($response);
    }

    /**
     * @param $id
     * @param UpdateProductValidator $updateProductValidator
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateProductValidator $updateProductValidator)
    {
        if(!empty($updateProductValidator->getErrors())){
            return response()->json($updateProductValidator->getErrors(),406);
        }
        $data=$updateProductValidator->request()->all();
        $data['user_id']=Auth::user()->id;
        $response=$this->productService->updateProduct($id,$data);
        return $this->sendResponse($response);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $this->productService->deleteProduct($id);
        return $this->sendResponse("deleted Successfully");
    }
}
