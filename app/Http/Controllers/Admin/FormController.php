<?php
namespace App\Http\Controllers\Admin;
use App\Models\Form;
use Inertia\Inertia;
use App\Repositories\Forms;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\OpensslHelper;
use Yajra\DataTables\Html\Column;
use App\Actions\Exports\FormsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Form\IndexForm;
use App\Http\Requests\Form\StoreForm;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Form\UpdateForm;
use App\Http\Requests\Form\DestroyForm;
use Illuminate\Support\Facades\Storage;

class FormController  extends Controller
{
    private Forms $repo;
    public function __construct(Forms $repo)
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
        $this->authorize('viewAny', Form::class);
        return Inertia::render('Forms/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Form::class),
                "create" => \Auth::user()->can('create', Form::class),
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
        $this->authorize('create', Form::class);
        return Inertia::render("Forms/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', Form::class),
            "create" => \Auth::user()->can('create', Form::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StoreForm $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StoreForm $request)
    {
        try {
            $data = $request->sanitizedObject();

            foreach($request->files as $files_key => $files){
                if(is_array($files)){
                    foreach($request->file($files_key) as $idx => $val){
                        foreach($val as $_idx => $_val){
                            $fileName = time().'.'.$_val->getClientOriginalExtension();
                            $_val->move(public_path('uploads/forms/upload-file/images/'.$files_key.'/'.$_idx), $fileName);
                            $fileName = 'forms/upload-file/images/'.$files_key.'/'.$_idx.'/'. $fileName;
                            $data->{$files_key}[$idx]->{$_idx} = '/uploads/'.$fileName;
                        }
                    }
                }else{
                    $fileName = time().'.'.$request->file($files_key)->getClientOriginalExtension();
                    $request->file($files_key)->move(public_path('uploads/forms/upload-file/images/'), $fileName);
                    $fileName = 'forms/upload-file/images/'.$fileName;
                    $data->{$files_key} = '/uploads/'.$fileName;
                }

                $img = Image::make(Storage::disk('public_uploads')->get($fileName));


                $img->resize(180, 180, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg',70);

                Storage::disk('public_thumbnails')->put( $fileName , $img);
            }

            $form = $this->repo::store($data);
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
    * @param Form $form
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, Form $form)
    {
        try {
            $this->authorize('view', $form);
            $model = $this->repo::init($form)->show($request);
            return Inertia::render("Forms/Show", ["model" => $model]);
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
    * @param Form $form
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, Form $form)
    {
        try {
            $this->authorize('update', $form);
            //Fetch relationships




        $form->load([
                'formAttributes',
        ]);

        return Inertia::render("Forms/Edit", ["model" => $form]);
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
    * @param UpdateForm $request
    * @param {$modelBaseName} $form
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdateForm $request, Form $form)
    {
        try {
            $data = $request->sanitizedObject();

            foreach($request->files as $files_key => $files){
                if(is_array($files)){
                    foreach($request->file($files_key) as $idx => $val){
                        foreach($val as $_idx => $_val){
                            $fileName = time().'.'.$_val->getClientOriginalExtension();
                            $_val->move(public_path('uploads/forms/upload-file/images/'.$files_key.'/'.$_idx), $fileName);
                            $data->{$files_key}[$idx]->{$_idx} = '/uploads/forms/upload-file/images/'.$files_key.'/'.$_idx.'/'. $fileName;
                        }
                    }
                }else{
                    $fileName = time().'.'.$request->file($files_key)->getClientOriginalExtension();
                    $request->file($files_key)->move(public_path('uploads/forms/upload-file/images/'), $fileName);
                    $data->{$files_key} = '/uploads/forms/upload-file/images/'.$fileName;
                }

                $img = Image::make(Storage::disk('public_uploads')->get('forms/upload-file/images/'.$fileName));


                $img->resize(180, 180, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg',70);

                Storage::disk('public_thumbnails')->put( 'forms/upload-file/images/'.$fileName , $img);
            }

            $res = $this->repo::init($form)->update($data);
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
    * @param Form $form
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyForm $request, Form $form)
    {
        $res = $this->repo::init($form)->destroy();
        if ($res) {
            return back()->with(['success' => "The record was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The record could not be deleted."]);
        }
    }

    /**
    * Remove the specified child resource from storage.
    *
    */
    public function destroyChild(Request $request)
    {
        $modelNamespace = "App\Models\\";
        $id = explode("@", OpensslHelper::decrypt($request->slug));
        $modelName = Str::studly($id[1]);
        $model = $modelNamespace.$modelName;

        if (!!$model::find($id[0])->delete()) {
            return back()->with(['success' => "This child was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "This child could not be deleted."]);
        }
    }

    public function exportExcel()
    {

        return Excel::download(new FormsExport, 'formsexport.xlsx');

    }

}
