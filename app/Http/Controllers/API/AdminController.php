<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IndexAdmin;
use App\Http\Requests\Admin\StoreAdmin;
use App\Http\Requests\Admin\UpdateAdmin;
use App\Http\Requests\Admin\DestroyAdmin;
use App\Models\Admin;
use App\Repositories\Admins;
use Illuminate\Http\Request;
use Lesliew\LaravelJetinGenerator\Helpers\ApiResponse;
use Savannabits\Pagetables\Column;
use Savannabits\Pagetables\Pagetables;
use Yajra\DataTables\DataTables;

class AdminController  extends Controller
{
    private $api;
    private Admins $repo;
    public function __construct(ApiResponse $apiResponse, Admins $repo)
    {
        $this->api = $apiResponse;
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource (paginated).
     * @retcolumnsToQueryurn \Illuminate\Http\JsonResponse
     */
    public function index(IndexAdmin $request)
    {
        $query = Admin::query(); // You can extend this however you want.
        $cols = [
            Column::name('id')->title('Id')->sort()->searchable(),
            Column::name('name')->title('Name')->sort()->searchable(),
            Column::name('email')->title('Email')->sort()->searchable(),
            Column::name('email_verified_at')->title('Email Verified At')->sort()->searchable(),
            Column::name('lang')->title('Lang')->sort()->searchable(),
            Column::name('two_factor_confirmed_at')->title('Two Factor Confirmed At')->sort()->searchable(),
            Column::name('profile_photo_path')->title('Profile Photo Path')->sort()->searchable(),
            Column::name('updated_at')->title('Updated At')->sort()->searchable(),
            
            Column::name('actions')->title('')->raw()
        ];
        $data = Pagetables::of($query)->columns($cols)->make(true);
        return $this->api->success()->message("List of Admins")->payload($data)->send();
    }

    public function dt(Request $request) {
        $query = Admin::query()->select(Admin::getModel()->getTable().'.*'); // You can extend this however you want.
        return $this->repo::dt($query, $request);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdmin $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAdmin $request)
    {
        try {
            $data = $request->sanitizedObject();
            $admin = $this->repo::store($data);
            return $this->api->success()->message('{{__($modelTitle)}} {{__("Created")}}')->payload($admin)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->payload([])->code(500)->send();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Admin $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Admin $admin)
    {
        try {
            $payload = $this->repo::init($admin)->show($request);
            return $this->api->success()
                        ->message("Admin $admin->id")
                        ->payload($payload)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->message($exception->getMessage())->send();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAdmin $request
     * @param {$modelBaseName} $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAdmin $request, Admin $admin)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($admin)->update($data);
            return $this->api->success()->message("Admin has been updated")->payload($res)->code(200)->send();
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return $this->api->failed()->code(400)->message($exception->getMessage())->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Admin $admin
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyAdmin $request, Admin $admin)
    {
        $res = $this->repo::init($admin)->destroy();
        return $this->api->success()->message("Admin has been deleted")->payload($res)->code(200)->send();
    }
    public function assignRole(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update',$user);
        $validated = $request->validate([
            'role' => ["required","array"],
            'role.id' =>['required','numeric'],
            'role.checked' =>['required','boolean'],
            'role.name' =>['required','string']
        ]);
        if (\Auth::id() === $user->id && $validated["role"]["name"] ==='administrator') {
            return $this->api->failed()->message("Possible Accidental Self-lockout or self-assignment of admin? We have prevented this assignment")->code(403)->send();
        }
        $res = $this->repo::init($user)->assignRole($validated['role']);
        return $this->api->success()->message("Role assignment updated")->payload($res)->send();
    }

}
