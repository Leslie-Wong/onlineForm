<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductType\IndexProductType;
use App\Http\Requests\ProductType\StoreProductType;
use App\Http\Requests\ProductType\UpdateProductType;
use App\Http\Requests\ProductType\DestroyProductType;
use App\Models\ProductType;
use App\Repositories\ProductTypes;
use Illuminate\Http\Request;
use Lesliew\LaravelJetinGenerator\Helpers\ApiResponse;
use Savannabits\Pagetables\Column;
use Savannabits\Pagetables\Pagetables;
use Yajra\DataTables\DataTables;

class ProductTypeController  extends Controller
{
    private ApiResponse $api;
    private ProductTypes $repo;
    public function __construct(ApiResponse $apiResponse, ProductTypes $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @return columnsToQuery \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $query = ProductType::query(); // You can extend this however you want.
        $cols = [
            Column::name('id')->title('Id')->sort()->searchable(),
            Column::name('name')->title('Name')->sort()->searchable(),
            Column::name('lang')->title('Lang')->sort()->searchable(),
            Column::name('status')->title('Status')->sort()->searchable(),
            Column::name('updated_at')->title('Updated At')->sort()->searchable(),

            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of ProductTypes")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = ProductType::query()->select(ProductType::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query, $request);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductType $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductType $request)
    {
        try {
            $data = $request->sanitizedObject();
            $productType = $this->repo::store($data);
            return $this->api->success()->message('Product Type Created')->payload($productType)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param ProductType $productType
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, ProductType $productType)
    {
        try {
            $payload = $this->repo::init($productType)->show($request);
            return $this->api->success()
                        ->message("Product Type $productType->id")
                        ->payload($payload)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductType $request
     * @param {$modelBaseName} $productType
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductType $request, ProductType $productType)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($productType)->update($data);
            return $this->api->success()->message("Product Type has been updated")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductType $productType
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyProductType $request, ProductType $productType)
    {
        $res = $this->repo::init($productType)->destroy();
        return $this->api->success()->message("Product Type has been deleted")->payload($res)->code(200)->send();
    }

}
