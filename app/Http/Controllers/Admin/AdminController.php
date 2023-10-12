<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IndexAdmin;
use App\Http\Requests\Admin\StoreAdmin;
use App\Http\Requests\Admin\UpdateAdmin;
use App\Http\Requests\Admin\DestroyAdmin;
use App\Models\Admin;
use App\Repositories\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;
use \Spatie\Permission\Models\Role;

class AdminController  extends Controller
{
    private Admins $repo;
    public function __construct(Admins $repo)
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
        $this->authorize('viewAny', Admin::class);
        return Inertia::render('Admins/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Admin::class),
                "create" => \Auth::user()->can('create', Admin::class),
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
        $this->authorize('create', User::class);
        $roles = Role::all()->map(function ($role) {
            $role->checked = false;
            return $role->only(['id', 'name', 'title', 'checked']);
        })->keyBy('name');
        return Inertia::render("Users/Create", [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', User::class),
                "create" => \Auth::user()->can('create', User::class),
            ],
            "roles" => $roles,
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param StoreAdmin $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function store(StoreAdmin $request)
    {
        try {
            $data = $request->sanitizedObject();
            $admin = $this->repo::store($data);
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
    * @param Admin $admin
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, Admin $admin)
    {
        try {
            $this->authorize('view', $admin);
            $model = $this->repo::init($admin)->show($request);
            return Inertia::render("Admins/Show", ["model" => $model]);
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
    * @param Admin $admin
    * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, Admin $admin)
    {
        try {
            $this->authorize('update', $admin);
            $roles = Role::all()->map(function ($role) use($user) {
                $checked = $user->hasRole([$role]);
                $role->checked = $checked;
                $role->title = $role->title ?? Str::title(str_replace("-"," ",Str::slug($role->name)));
                return $role->only(['id','name','title', 'checked']);
            })->keyBy('name');
            //Fetch relationships
            

                        return Inertia::render("Admins/Edit", ["model" => $admin,"roles" => $roles]);
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
    * @param UpdateAdmin $request
    * @param {$modelBaseName} $admin
    * @return \Illuminate\Http\RedirectResponse
    */
    public function update(UpdateAdmin $request, Admin $admin)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($admin)->update($data);
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
    * @param Admin $admin
    * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy(DestroyAdmin $request, Admin $admin)
    {
        $res = $this->repo::init($admin)->destroy();
        if ($res) {
            return back()->with(['success' => "The record was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The record could not be deleted."]);
        }
    }
}
