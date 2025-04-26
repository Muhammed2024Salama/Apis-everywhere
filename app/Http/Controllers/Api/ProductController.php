<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
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
        $products = $this->productService->getProducts();
        return ResponseHelper::success('Product list retrieved successfully', 'success', $products);
    }

    /**
     * @param CreateProductValidator $createProductValidator
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateProductValidator $createProductValidator)
    {
        if (!empty($createProductValidator->getErrors())) {
            return ResponseHelper::error('error', $createProductValidator->getErrors(), 406);
        }

        $data = $createProductValidator->request()->all();
        $data['user_id'] = Auth::user()->id;

        $response = $this->productService->createProduct($data);

        return ResponseHelper::success('Product created successfully', 'success', $response);
    }

    /**
     * @param $id
     * @param UpdateProductValidator $updateProductValidator
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateProductValidator $updateProductValidator)
    {
        if (!empty($updateProductValidator->getErrors())) {
            return ResponseHelper::error('error', $updateProductValidator->getErrors(), 406);
        }

        $data = $updateProductValidator->request()->all();
        $data['user_id'] = Auth::user()->id;

        $response = $this->productService->updateProduct($id, $data);

        return ResponseHelper::success('Product updated successfully', 'success', $response);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return ResponseHelper::success('Deleted Successfully');
    }
}
