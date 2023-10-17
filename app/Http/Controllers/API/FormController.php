<?php
namespace App\Http\Controllers\API;
use App\Models\Form;
use App\Models\FormAttribute;
use App\Repositories\Forms;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Savannabits\Pagetables\Column;
use App\Http\Controllers\Controller;
use App\Http\Requests\Form\IndexForm;
use App\Http\Requests\Form\StoreForm;
use App\Http\Requests\Form\UpdateForm;
use Savannabits\Pagetables\Pagetables;
use App\Http\Requests\Form\DestroyForm;
use Illuminate\Support\Facades\Validator;
use Lesliew\LaravelJetinGenerator\Helpers\ApiResponse;

class FormController  extends Controller
{
    private ApiResponse $api;
    private Forms $repo;
    public function __construct(ApiResponse $apiResponse, Forms $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @return columnsToQuery \Illuminate\Http\JsonResponse
     */
    public function index(IndexForm $request)
    {
        $query = Form::query(); // You can extend this however you want.
        $cols = [
            Column::name('id')->title('Id')->sort()->searchable(),
            Column::name('name')->title('Name')->sort()->searchable(),
            Column::name('status')->title('Status')->sort()->searchable(),
            Column::name('updated_at')->title('Updated At')->sort()->searchable(),

            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of Forms")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = FormAttribute::query()->select(FormAttribute::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query, $request);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreForm $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreForm $request)
    {
        try {
            $data = $request->sanitizedObject();
            \Log::info(json_encode($data));
            $form = $this->repo::store($data);
            return $this->api->success()->message('Form Created')->payload($form)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Form $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Form $form)
    {
        try {
            $payload = $this->repo::init($form)->show($request);


            $payload->load([
                'formAttributes',
            ]);

            return $this->api->success()
                    ->message("Form $form->id")
                    ->payload($payload)->send();

        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateForm $request
     * @param {$modelBaseName} $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateForm $request, Form $form)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($form)->update($data);
            return $this->api->success()->message("Form has been updated")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Form $form
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyForm $request, Form $form)
    {
        $res = $this->repo::init($form)->destroy();
        return $this->api->success()->message("Form has been deleted")->payload($res)->code(200)->send();
    }

    public function dataUpload(Request $request){
        // \Log::info(json_encode($request->data));

        $storeForm = new StoreForm();

        $validator = Validator::make($request->all(), $storeForm->rules());

        If ($validator->fails()){
            return $this->api->failed()->code(400)->message($validator->messages())->send();
        }

        foreach($request->files as $files_key => $files){

            if(is_array($files)){

                foreach($request->file($files_key) as $idx => $val){
                    $fileName = time()."-".$val->getClientOriginalName();
                    $val->move(public_path('uploads/forms/upload-file/files/'.$files_key.'/'.$idx), $fileName);
                }
            }else{
                $fileName = time()."-".$request->file($files_key)->getClientOriginalName();
                $request->file($files_key)->move(public_path('uploads/forms/upload-file/files'), $fileName);
                // $data->{$files_key} = '/uploads/forms/upload-file/images/'.$fileName;
            }
        }

        $form = $this->repo::storeByUpload(json_decode(collect($request->all())));


        return $this->api->success()->message("Thank You. Your information has been saved.")->payload($form)->send();

        // return $this->api->success()->message("Form has been updated")->payload($request->data)->code(200)->send();
    }

}
