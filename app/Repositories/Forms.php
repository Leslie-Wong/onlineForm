<?php
namespace App\Repositories;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Column;
use App\Helpers\OpensslHelper;
use App\Helpers\SearchBuilder;

class Forms
{
    private Form $model;

    public static function init(Form $model): Forms
    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store(object $data): Form
    {
        $data->name = "Product List";
        $data->status = "Enable";
        $model = new Form((array) $data);
        // Save Relationships



        $model->saveOrFail();

        /*-----Auot Gen Create-form_attributes-Start-----*/
        if (isset($data->form_attributes)) {
            foreach ($data->form_attributes as $child) {
                \Log::info(json_encode($child));
                if( auth('sanctum')->check() ){
                    $user = auth('sanctum')->user();
                    $child->name = $user->name;
                    $child->email = $user->email;
                    $child->phone = "no-phone";
                }
                $model->formAttributes()
                ->create((array) $child);
            }

        }
        /*-----Auot Gen Create-form_attributes-End-----*/
        return $model;
    }

    public function show(Request $request): Form {
        //Fetch relationships
        return $this->model;
    }

    public function update(object $data): Form
    {
        $this->model->update((array) $data);

        // Save Relationships


        /*-----Auot Gen Update-form_attributes-Start-----*/
        if (isset($data->form_attributes)) {
            foreach ($data->form_attributes as $child) {
                if(isset($child->id)){
                    $id = explode("@", OpensslHelper::decrypt($child->id));
                    $child->id = $id[0];
                    $this->model->formAttributes()->where('id',$child->id)
                    ->update((array) $child);
                }else{
                    $this->model->formAttributes()
                    ->create((array) $child);
                }
            }

        }
        /*-----Auot Gen Update-form_attributes-End-----*/

        $this->model->saveOrFail();
        return $this->model;
    }

    public function destroy(): bool
    {
		$this->model->formAttributes()->delete();
        return !!$this->model->delete();
    }

    public static function dtColumns() {
        $columns = [
            Column::make('id')->title('ID')->className('all text-right')->type("num"),
            Column::make("name")->className('all')->type("string"),
            Column::make("status")->className('min-tablet')->type("ENUM")->content(json_encode(['options' => ['Enable','Disable']])),
        ];


        $child_columns = [
            Column::make("form_attribute.name")->title('Name')->className('all')->type("string"),
            Column::make("form_attribute.phone")->title('Phone')->className('min-tablet')->type("string"),
            Column::make("form_attribute.email")->title('Email')->className('min-tablet')->type("string"),
            Column::make("form_attribute.product_sku")->title('ProductSku')->className('min-tablet')->type("string"),
            Column::make("form_attribute.product_name")->title('ProductName')->className('min-tablet')->type("string"),
            Column::make("form_attribute.product_type")->title('ProductType')->className('min-tablet')->type("string"),
            Column::make("form_attribute.brand")->title('Brand')->className('min-tablet')->type("string"),
            Column::make("form_attribute.ref_price")->title('RefPrice')->className('min-tablet')->type("string"),
            Column::make("form_attribute.place_of_origin")->title('PlaceOfOrigin')->className('min-tablet')->type("string"),
            Column::make("form_attribute.product_image")->title('ProductImage')->className('min-tablet')->type("string"),
        ];

        $exheader = [
            ["name" => "Forms", "len" => 4],
            ["name" => "Form Attributes", "len" => 10],
        ];

        $columns = array_merge($columns, $child_columns);

        $columns = array_merge($columns, [
            Column::make("created_at")->className("min-tv")->type("date"),
            Column::make("updated_at")->className("min-tv")->type("date"),
            Column::make('actions')->className('all text-right')->orderable(false)->searchable(false)->type('html'),
        ]);

        return ["data" => $columns, "exheader" => $exheader];
    }

    public static function dt($query, $request) {
        $query = $query->with([
            'FormAttribute',
        ]);

        $childColumns = [
            'form_attribute.name',
            'form_attribute.phone',
            'form_attribute.email',
            'form_attribute.product_sku',
            'form_attribute.product_name',
            'form_attribute.product_type',
            'form_attribute.brand',
            'form_attribute.ref_price',
            'form_attribute.place_of_origin',
            'form_attribute.product_image',
        ];

        $allowedColumns = [
            'id',
            'name',
            'status',
            'created_at',
            'updated_at',
            ...$childColumns,
        ];

        $sb    = new SearchBuilder($request, $query, $allowedColumns);
        $query = $sb->build()->get();

        $dataTable = DataTables::of($query);


        return DataTables::of($query)->editColumn('actions',function (Form $model) {
            $actions = '';
            if (\Auth::user()->can('view',$model)) $actions .= '<button class="bg-primary hover:bg-primary-600 p-2 px-3 focus:ring-0 focus:outline-none text-green-500 action-button" title="__("View Details")" data-action="show-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-eye"></i></button>';
            if (\Auth::user()->can('update',$model)) $actions .= '<button class="bg-secondary hover:bg-secondary-600 p-2 px-3 focus:ring-0 focus:outline-none text-orange-500 action-button" title="__("Edit Record")" data-action="edit-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-edit"></i></button>';
            if (\Auth::user()->can('delete',$model)) $actions .= '<button class="bg-danger hover:bg-danger-600 p-2 px-3 text-yellow-500 focus:ring-0 focus:outline-none action-button" title="__("Delete Record")" data-action="delete-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-trash"></i></button>';
            return "<div class='gap-x-1 flex w-full justify-end'>".$actions."</div>";
        })
        ->rawColumns(['actions'])
        ->make(true);
        //->toJson();
    }
}