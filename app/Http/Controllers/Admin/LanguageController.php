<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Language\IndexLanguage;
use App\Http\Requests\Language\StoreLanguage;
use App\Http\Requests\Language\UpdateLanguage;
use App\Http\Requests\Language\DestroyLanguage;
use App\Models\Language;
use App\Repositories\Languages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;

class LanguageController  extends Controller
{
    private Languages $repo;
    public function __construct(Languages $repo)
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
        $this->authorize('viewAny', Language::class);
        return Inertia::render('Languages/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Language::class),
                "create" => \Auth::user()->can('create', Language::class),
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
        $this->authorize('create', Language::class);
        return Inertia::render("Languages/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', Language::class),
            "create" => \Auth::user()->can('create', Language::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StoreLanguage $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StoreLanguage $request)
    {
        try {
            $data = $request->sanitizedObject();
            $language = $this->repo::store($data);
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
    * @param Language $language
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, Language $language)
    {
        try {
            $this->authorize('view', $language);
            $model = $this->repo::init($language)->show($request);
            return Inertia::render("Languages/Show", ["model" => $model]);
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
    * @param Language $language
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, Language $language)
    {
        try {
            $this->authorize('update', $language);
            //Fetch relationships
            

                        return Inertia::render("Languages/Edit", ["model" => $language]);
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
    * @param UpdateLanguage $request
    * @param {$modelBaseName} $language
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdateLanguage $request, Language $language)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($language)->update($data);
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
    * @param Language $language
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyLanguage $request, Language $language)
    {
        if($language->id <> 1){
            $res = $this->repo::init($language)->destroy();
            if ($res) {
                return back()->with(['success' => "The record was deleted succesfully."]);
            }
        }

        return back()->with(['error' => "The record could not be deleted."]);
    }
}
