<?php
namespace App\Repositories;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Column;
use App\Models\Permission;
use App\Helpers\SearchBuilder;

class Roles
{
    private Role $model;
    public static function init(Role $model): Roles
    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store(object $data): Role
    {
        $model = new Role((array) $data);
        $model->title = $data->title;
        $model->guard_name = 'web';
        $model->name = Str::slug($model->title);
        $model->saveOrFail();
        return $model;
    }

    public function show(Request $request): Role {
        //Fetch relationships
        return $this->model;
    }

    public function update(object $data): Role
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
            ->editColumn('actions', function (Role $model) {
                $actions = '';
                if (\Auth::user()->can('view',$model)) $actions .= '<button class="bg-primary hover:bg-primary-600 p-2 px-3 focus:ring-0 focus:outline-none text-green-500 action-button" title="__("View Details")" data-action="show-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-eye"></i></button>';
                if (\Auth::user()->can('update',$model)) $actions .= '<button class="bg-secondary hover:bg-secondary-600 p-2 px-3 focus:ring-0 focus:outline-none text-orange-500 action-button" title="__("Edit Record")" data-action="edit-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-edit"></i></button>';
                if (\Auth::user()->can('delete',$model)) $actions .= '<button class="bg-danger hover:bg-danger-600 p-2 px-3 text-yellow-500 focus:ring-0 focus:outline-none action-button" title="__("Delete Record")" data-action="delete-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-trash"></i></button>';
                return "<div class='gap-x-1 flex w-full justify-end'>".$actions."</div>";
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function assignPermission(array $data): bool {
        $perm = Permission::whereId($data['id'])->firstOrFail();
        if ($data['checked']) {
            $this->model->givePermissionTo($perm);
        } else  {
            if ($this->model->hasPermissionTo($perm)) {
                $this->model->revokePermissionTo($perm);
            }
        }
        return $this->model->hasPermissionTo($perm);
    }
}
