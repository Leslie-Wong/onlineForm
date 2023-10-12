<?php
namespace App\Repositories;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Column;
use \Spatie\Permission\Models\Role;
use App\Helpers\SearchBuilder;

class Admins
{
    private Admin $model;
    public static function init(Admin $model): Admins
    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store(object $data): Admin
    {
        $model = new Admin((array) $data);
                // Save Relationships
                    

        if (isset($data->password) && $data->password) {
            $model->password = \Hash::make($data->password);
        }

        $model->saveOrFail();

        foreach(collect($data->assigned_roles) as $roles){
            $role = Role::whereName($roles->name)->firstOrFail();
            if($role)
                $model->assignRole([$role]);
        }

        return $model;
    }

    public function show(Request $request): Admin {
        //Fetch relationships
            return $this->model;
    }
    public function update(object $data): Admin
    {
        $this->model->update((array) $data);
        
        // Save Relationships
                        

        if (isset($data->password) && $data->password) {
            $this->model->password = \Hash::make($data->password);
        }
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
            Column::make("email")->className('min-tablet')->type("string"),
            Column::make("email_verified_at")->className('min-tablet')->type("date"),
            Column::make("lang")->className('min-tablet')->type("string"),
            Column::make("two_factor_confirmed_at")->className('min-tablet')->type("date"),
            Column::make("profile_photo_path")->className('min-tablet')->type("string"),
            Column::make("created_at")->className('min-tv')->type("date"),
            Column::make("updated_at")->className('min-tv')->type("date"),
            Column::make('actions')->className('all text-right')->orderable(false)->searchable(false)->type("html"),
        ];
        return $columns;
    }

    public static function dt($query, $request) {
        $allowedColumns = [
            'id',
            'name',
            'email',
            'email_verified_at',
            'lang',
            'two_factor_confirmed_at',
            'profile_photo_path',
            'created_at',
            'updated_at',
        ];

        return DataTables::of($query)
            ->filter(function ($query) use ($request, $allowedColumns) {
                $sb    = new SearchBuilder($request, $query, $allowedColumns);
                $query = $sb->build();
            })
            ->editColumn('actions', function (Admin $model) {
                $actions = '';
                if (\Auth::user()->can('view',$model)) $actions .= '<button class="bg-primary hover:bg-primary-600 p-2 px-3 focus:ring-0 focus:outline-none text-green-500 action-button" title="__("View Details")" data-action="show-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-eye"></i></button>';
                if (\Auth::user()->can('update',$model)) $actions .= '<button class="bg-secondary hover:bg-secondary-600 p-2 px-3 focus:ring-0 focus:outline-none text-orange-500 action-button" title="__("Edit Record")" data-action="edit-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-edit"></i></button>';
                if (\Auth::user()->can('delete',$model)) $actions .= '<button class="bg-danger hover:bg-danger-600 p-2 px-3 text-yellow-500 focus:ring-0 focus:outline-none action-button" title="__("Delete Record")" data-action="delete-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-trash"></i></button>';
                return "<div class='gap-x-1 flex w-full justify-end'>".$actions."</div>";
            })
            ->rawColumns(['actions'])
            ->make();
    }
    public function assignRole(array $data): bool {
        $role = Role::whereName($data['name'])->firstOrFail();
        if ($data['checked']) {
            $this->model->assignRole([$role]);
        } else  {
            if ($this->model->hasRole($role->name)) {
                $this->model->removeRole($role);
            }
        }
        return $this->model->hasRole($role->name);
    }
}
