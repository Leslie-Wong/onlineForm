<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\Language\IndexLanguage;
use App\Http\Requests\Language\StoreLanguage;
use App\Http\Requests\Language\UpdateLanguage;
use App\Http\Requests\Language\DestroyLanguage;
use App\Models\Language;
use App\Repositories\Languages;
use Illuminate\Http\Request;
use Lesliew\LaravelJetinGenerator\Helpers\ApiResponse;
use Savannabits\Pagetables\Column;
use Savannabits\Pagetables\Pagetables;
use Yajra\DataTables\DataTables;

class LanguageController  extends Controller
{
    private ApiResponse $api;
    private Languages $repo;
    public function __construct(ApiResponse $apiResponse, Languages $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @return columnsToQuery \Illuminate\Http\JsonResponse
     */
    public function index(IndexLanguage $request)
    {
        $query = Language::query(); // You can extend this however you want.
        $cols = [
            Column::name('id')->title('Id')->sort()->searchable(),
            Column::name('code')->title('Code')->sort()->searchable(),
            Column::name('name')->title('Name')->sort()->searchable(),
            Column::name('updated_at')->title('Updated At')->sort()->searchable(),
            Column::name('flag')->title('Flag')->sort()->searchable(),
            
            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of Languages")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = Language::query()->select(Language::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query, $request);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLanguage $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreLanguage $request)
    {
        try {
            $data = $request->sanitizedObject();
            $language = $this->repo::store($data);
            return $this->api->success()->message('{{__($modelTitle)}} {{__("Created")}}')->payload($language)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Language $language
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Language $language)
    {
        try {
            $payload = $this->repo::init($language)->show($request);
            return $this->api->success()
                        ->message("{{__('Language')}} $language->id")
                        ->payload($payload)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLanguage $request
     * @param {$modelBaseName} $language
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateLanguage $request, Language $language)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($language)->update($data);
            return $this->api->success()->message("{{__('Language')}} {{__('has been updated')}}")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Language $language
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyLanguage $request, Language $language)
    {
        $res = $this->repo::init($language)->destroy();
        return $this->api->success()->message("{{__('Language')}} {{__('has been deleted')}}")->payload($res)->code(200)->send();
    }

}
