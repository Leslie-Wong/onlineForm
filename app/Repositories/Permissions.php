<?php
namespace App\Repositories;

use App\Models\Permission;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Column;
use App\Helpers\SearchBuilder;

class Permissions
{
    private Permission $model;
    public static function init(Permission $model): Permissions
    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store(object $data): Permission
    {
        $model = new Permission((array) $data);
                // Save Relationships
                    

        $model->saveOrFail();
        return $model;
    }

    public function show(Request $request): Permission {
        //Fetch relationships
            return $this->model;
    }
    public function update(object $data): Permission
    {
        $this->model->update((array) $data);
        
        // Save Relationships
                        

        $this->model->saveOrFail();
        return $this->model;
    }

    public function destroy(): bool
    {
        return !!$this->model->delete();
    }

    public static function dtColumns() {
        $columns = [
    Column::make('id')->title('ID')->className('all text-right')->type("num"),
            Column::make("name")->className('all')->type("string"),
            Column::make("guard_name")->className('min-tablet')->type("string"),
            Column::make("created_at")->className('min-tv')->type("date"),
            Column::make("updated_at")->className('min-tv')->type("date"),
            Column::make("title")->className('all')->type("string"),
            Column::make('actions')->className('all text-right')->orderable(false)->searchable(false)->type("html"),
        ];
        return $columns;
    }

    public static function dt($query, $request) {
        $allowedColumns = [
            'id',
            'name',
            'guard_name',
            'created_at',
            'updated_at',
            'title',
        ];

        return DataTables::of($query)
            ->filter(function ($query) use ($request, $allowedColumns) {
                $sb    = new SearchBuilder($request, $query, $allowedColumns);
                $query = $sb->build();
            })
            ->editColumn('actions', function (Permission $model) {
                $actions = '';
                if (\Auth::user()->can('view',$model)) $actions .= '<button class="bg-primary hover:bg-primary-600 p-2 px-3 focus:ring-0 focus:outline-none text-green-500 action-button" title="__("View Details")" data-action="show-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-eye"></i></button>';
                if (\Auth::user()->can('update',$model)) $actions .= '<button class="bg-secondary hover:bg-secondary-600 p-2 px-3 focus:ring-0 focus:outline-none text-orange-500 action-button" title="__("Edit Record")"  data-action="edit-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-edit"></i></button>';
                if (\Auth::user()->can('delete',$model)) $actions .= '<button class="bg-danger hover:bg-danger-600 p-2 px-3 text-yellow-500 focus:ring-0 focus:outline-none action-button" title="__("Delete Record")" data-action="delete-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-trash"></i></button>';
                return "<div class='gap-x-1 flex w-full justify-end'>".$actions."</div>";
            })
            ->rawColumns(['actions'])
            ->make();
    }
    public static function seedPermissions(array $perms, array $roleNames = ["administrator"],$guard=null) {
        if (!$guard) {
            $guard = config('auth.defaults.guard');
        }
        $perms = collect($perms);
        $permissions = $perms->map(function ($permission) use($guard) {
            return [
                'name' => $permission,
                'title' => Str::title(str_replace("-"," ",implode(" ",explode(".",$permission)))),
                'guard_name' => $guard,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        $roles = collect($roleNames)->map(function($role) use ($perms, $guard) {
            return [
                'name'          => $role,
                'title'         => str_replace("-"," ", Str::title($role)),
                'guard_name'    => $guard,
                'permissions'   => $perms,
            ];
        });

        $tableNames = config('permission.table_names', [
            'roles' => 'roles',
            'permissions' => 'permissions',
            'model_has_permissions' => 'model_has_permissions',
            'model_has_roles' => 'model_has_roles',
            'role_has_permissions' => 'role_has_permissions',
        ]);

        DB::transaction(function () use($tableNames, $permissions, $roles) {
            foreach ($permissions as $permission) {
                $permissionItem = DB::table($tableNames['permissions'])->where([
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name']
                ])->first();
                if ($permissionItem === null) {
                    DB::table($tableNames['permissions'])->insert($permission);
                }
            }

            foreach ($roles as $role) {
                $permissions = $role['permissions'];
                unset($role['permissions']);

                $roleItem = DB::table($tableNames['roles'])->where([
                    'name' => $role['name'],
                    'guard_name' => $role['guard_name']
                ])->first();
                if ($roleItem !== null) {
                    $roleId = $roleItem->id;

                    $permissionItems = DB::table($tableNames['permissions'])->whereIn('name', $permissions)->where(
                        'guard_name',
                        $role['guard_name']
                    )->get();
                    foreach ($permissionItems as $permissionItem) {
                        $roleHasPermissionData = [
                            'permission_id' => $permissionItem->id,
                            'role_id' => $roleId
                        ];
                        $roleHasPermissionItem = DB::table($tableNames['role_has_permissions'])->where($roleHasPermissionData)->first();
                        if ($roleHasPermissionItem === null) {
                            DB::table($tableNames['role_has_permissions'])->insert($roleHasPermissionData);
                        }
                    }
                }
            }
        });
        app()['cache']->forget(config('permission.cache.key'));
    }
}
