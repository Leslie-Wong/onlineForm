<?php
namespace App\Repositories;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Column;
use App\Helpers\SearchBuilder;

class Languages
{
    private Language $model;
    public static function init(Language $model): Languages
    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store(object $data): Language
    {
        $model = new Language((array) $data);
                // Save Relationships
                    

        $model->saveOrFail();
        if(!file_exists(resource_path('lang/'.$model->code.'.json'))){
            \Storage::disk('resources_lang')->put($model->code.'.json',  \Storage::disk('resources_lang')->get('temp.json'));
        }
        return $model;
    }

    public function show(Request $request): Language {
        //Fetch relationships
            return $this->model;
    }
    public function update(object $data): Language
    {
        $old = $this->model->code;
        $new = $data->code;

        $this->model->update((array) $data);
        
        // Save Relationships
                        

        $this->model->saveOrFail();

        if($old != $new && file_exists(resource_path('lang/'.$old.'.json'))){
            File::move(resource_path('lang/'.$old.'.json'),resource_path('lang/'.$new.'.json'));
         }

        return $this->model;
    }

    public function destroy(): bool
    {
        if(file_exists(resource_path('lang/'.$this->model->code.'.json'))){
            unlink(resource_path('lang/'.$this->model->code.'.json'));
        }

        return !!$this->model->delete();
    }

    public static function dtColumns() {
        $columns = [
    Column::make('id')->title('ID')->className('all text-right')->type("num"),
            Column::make("code")->className('min-tablet')->type("string"),
            Column::make("name")->className('all')->type("string"),
            Column::make("created_at")->className('min-tv')->type("date"),
            Column::make("updated_at")->className('min-tv')->type("date"),
            Column::make("flag")->className('min-tablet')->type("string"),
            Column::make('actions')->className('all text-right')->orderable(false)->searchable(false)->type("html"),
        ];
        return $columns;
    }

    public static function dt($query, $request) {
        $allowedColumns = [
            'id',
            'code',
            'name',
            'created_at',
            'updated_at',
            'flag',
        ];

        return DataTables::of($query)
            ->filter(function ($query) use ($request, $allowedColumns) {
                $sb    = new SearchBuilder($request, $query, $allowedColumns);
                $query = $sb->build();
            })
            ->editColumn('actions', function (Language $model) {
                $actions = '';
                if (\Auth::user()->can('update',$model) && $model->id <> 1) $actions .= '<button class="bg-secondary hover:bg-secondary-600 p-2 px-3 focus:ring-0 focus:outline-none text-orange-500 action-button"  title="__("Edit Record")" data-action="edit-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-edit"></i></button>';
                if (\Auth::user()->can('delete',$model) && $model->id <> 1) $actions .= '<button class="bg-danger hover:bg-danger-600 p-2 px-3 text-yellow-500 focus:ring-0 focus:outline-none action-button" title="__("Delete Record")" data-action="delete-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-trash"></i></button>';
                return "<div class='gap-x-1 flex w-full justify-end'>".$actions."</div>";
            })
            ->editColumn('flag', function (Language $model) {
                return "<span class='fi fi-".$model->flag."'></span>";
            })
            ->rawColumns(['actions','flag'])
            ->make();
    }
}
