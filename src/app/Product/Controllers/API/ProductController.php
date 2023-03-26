<?php

namespace App\Product\Controllers\API;

use Illuminate\Http\JsonResponse;
use Domain\Product\Models\Product;
use Domain\Product\Data\ProductData;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use App\Product\Queries\ProductIndexQuery;
use App\Product\Requests\StoreProductRequest;
use Domain\Product\Actions\ViewProductAction;
use App\Product\Requests\UpdateProductRequest;
use Domain\Product\Actions\StoreProductAction;
use Domain\Product\Actions\DeleteProductAction;
use Domain\Product\Actions\UpdateProductAction;

class ProductController extends APIController
{
   /**
    * list the products
    * @queryParam filter[name] Filter by product name. Example: ProductA
    * @queryParam filter[admin_id] Filter by product name. Example: 1
    * @responseFile 200 responses/Product/products.json
    * @response status=401 scenario="Unauthenticated" {"message": "Unauthenticated."}
    */
    public function index(ProductIndexQuery $productQuery)
    {
        return  $this->okResponse($productQuery->get());
    }

   /**
    * Store a new Product
    * @bodyParam name string required The name of the product. Example: ProductA
    * @bodyParam status string required The status of the product. Example: active
    * @bodyParam product_type string required The type of the product. Example: service
    * @responseFile 201 responses/Product/product.json
    * @response status=401 scenario="Unauthenticated" {"message": "Unauthenticated."}
    * @response status=422 scenario="Invalid Inputs" {"message": "The name field is required."}
    */
    public function store(StoreProductRequest $request): JsonResponse
    {

       $product=StoreProductAction::run(
           ProductData::from([
                    'name' => $request->name,
                    'admin_id' => Auth::user()->id,
                    'product_type' => $request->product_type,
                    'status' => $request->status,
               ])
       );
       return  $this->createdResponse($product);
    }


   /**
    * view the product
    * @urlParam id integer required The id of the Product.
    * @responseFile 200 responses/Product/product.json
    * @response status=401 scenario="Unauthenticated" {"message": "Unauthenticated."}
    */
    public function show(int $id)
    {
        $product=ViewProductAction::run($id);
        return $product ? $this->okResponse($product) : $this->notFoundResponse("product not found");
    }

   /**
    * Update the product
    * @urlParam id integer required The id of the Product.
    * @bodyParam name string required The name of the product. Example: ProductA
    * @bodyParam status string required The status of the product. Example: active
    * @bodyParam product_type string required The type of the product. Example: service
    * @response status=200 scenario="delete" {"message": "Operation succeeded.
    * @response status=401 scenario="Unauthenticated" {"message": "Unauthenticated."}
    * @response status=422 scenario="Invalid Inputs" {"message": "The name field is required."}
    */
    public function update(int $id, UpdateProductRequest $request): JsonResponse
    {
        $result=UpdateProductAction::run(
            $id,
            ProductData::from([
                     'name' => $request->name,
                     'product_type' => $request->product_type,
                     'status' => $request->status,
                ])
        );
        return $result ? $this->okResponse() : $this->notFoundResponse("product not found");
    }


  /**
    * Delete The Product
    * @urlParam id integer required The id of the Product.
    * @response status=200 scenario="delete" {"message": "Operation succeeded."}
    * @response status=401 scenario="Unauthenticated" {"message": "Unauthenticated."}
  */
    public function destroy(int $id)
    {
        $result=DeleteProductAction::run($id);
        return $result ? $this->okResponse() : $this->notFoundResponse("product not found");
    }
}
