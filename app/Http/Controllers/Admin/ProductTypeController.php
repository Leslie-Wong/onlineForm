<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductType\IndexProductType;
use App\Http\Requests\ProductType\StoreProductType;
use App\Http\Requests\ProductType\UpdateProductType;
use App\Http\Requests\ProductType\DestroyProductType;
use App\Models\ProductType;
use App\Repositories\ProductTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;
use App\Helpers\OpensslHelper;;

class ProductTypeController  extends Controller
{
    private ProductTypes $repo;
    public function __construct(ProductTypes $repo)
    {
        $this->repo = $repo;
    }

    /**
    * Display a listing of the resource.
    *
    * @param Request $request
    * @return  \Inertia\Response
    * @throws \Illuminate\Auth\Access\AuthorizationException
    */
    public function index(Request $request): \Inertia\Response
    {
        $this->authorize('viewAny', ProductType::class);
        return Inertia::render('ProductTypes/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', ProductType::class),
                "create" => \Auth::user()->can('create', ProductType::class),
            ],
            "columns" => $this->repo::dtColumns(),
        ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Inertia\Response
    */
    public function create()
    {
        $this->authorize('create', ProductType::class);
        return Inertia::render("ProductTypes/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', ProductType::class),
            "create" => \Auth::user()->can('create', ProductType::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StoreProductType $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StoreProductType $request)
    {
        try {
            $data = $request->sanitizedObject();



            foreach($request->files as $files_key => $files){
                if(is_array($files)){
                    foreach($request->file($files_key) as $idx => $val){
                        foreach($val as $_idx => $_val){
                            $fileName = time().'.'.$_val->getClientOriginalExtension();
                            $_val->move(public_path('upload/ProductType/'.$files_key.'/'.$_idx), $fileName);
                            $data->{$files_key}[$idx]->{$_idx} = '/upload/ProductType/'.$files_key.'/'.$_idx.'/'. $fileName;
                        }
                    }
                }else{
                    $fileName = time().'.'.$request->file($files_key)->getClientOriginalExtension();
                    $request->file($files_key)->move(public_path('upload/ProductType'), $fileName);
                    $data->{$files_key} = '/upload/ProductType/'.$fileName;
                }
            }

            $productType = $this->repo::store($data);
            return back()->with(['success' => "The record was created succesfully."]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
    * Display the specified resource.
    *
    * @param Request $request
    * @param ProductType $productType
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, ProductType $productType)
    {
        try {
            $this->authorize('view', $productType);
            $model = $this->repo::init($productType)->show($request);
            return Inertia::render("ProductTypes/Show", ["model" => $model]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
    * Show Edit Form for the specified resource.
    *
    * @param Request $request
    * @param ProductType $productType
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, ProductType $productType)
    {
        try {
            $this->authorize('update', $productType);
            //Fetch relationships
            

                        return Inertia::render("ProductTypes/Edit", ["model" => $productType]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
    * Update the specified resource in storage.
    *
    * @param UpdateProductType $request
    * @param {$modelBaseName} $productType
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdateProductType $request, ProductType $productType)
    {
        try {
            $data = $request->sanitizedObject();



            foreach($request->files as $files_key => $files){
                if(is_array($files)){
                    foreach($request->file($files_key) as $idx => $val){
                        foreach($val as $_idx => $_val){
                            $fileName = time().'.'.$_val->getClientOriginalExtension();
                            $_val->move(public_path('upload/ProductType/'.$files_key.'/'.$_idx), $fileName);
                            $data->{$files_key}[$idx]->{$_idx} = '/upload/ProductType/'.$files_key.'/'.$_idx.'/'. $fileName;
                        }
                    }
                }else{
                    $fileName = time().'.'.$request->file($files_key)->getClientOriginalExtension();
                    $request->file($files_key)->move(public_path('upload/ProductType'), $fileName);
                    $data->{$files_key} = '/upload/ProductType/'.$fileName;
                }
            }

            $res = $this->repo::init($productType)->update($data);
            return back()->with(['success' => "The record was updated succesfully."]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param ProductType $productType
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyProductType $request, ProductType $productType)
    {
        $res = $this->repo::init($productType)->destroy();
        if ($res) {
            return back()->with(['success' => "The record was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The record could not be deleted."]);
        }
    }
}
