<?php echo "<?php";
?>

namespace <?php echo e($repoNamespace); ?>;

use <?php echo e($modelFullName); ?>;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Column;
use App\Models\Permission;
use App\Helpers\SearchBuilder;

class <?php echo e($repoBaseName); ?>

{
    private <?php echo e($modelBaseName); ?> $model;
    public static function init(<?php echo e($modelBaseName); ?> $model): <?php echo e($repoBaseName); ?>

    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store(object $data): <?php echo e($modelBaseName); ?>

    {
        $model = new <?php echo e($modelBaseName); ?>((array) $data);
        $model->title = $data->title;
        $model->guard_name = 'web';
        $model->name = Str::slug($model->title);
        $model->saveOrFail();
        return $model;
    }

    public function show(Request $request): <?php echo e($modelBaseName); ?> {
        //Fetch relationships
<?php if(count($relations)): ?>
<?php if(isset($relations['belongsTo']) && count($relations['belongsTo'])): ?>
<?php $parents = $relations['belongsTo']->pluck("function_name")->toArray(); ?>
        $this->model->load([
<?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        '<?php echo e($parent); ?>',
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ]);
<?php endif; ?>
<?php endif; ?>
        return $this->model;
    }

    public function update(object $data): <?php echo e($modelBaseName); ?>

    {
        $this->model->update((array) $data);
<?php if(in_array("slug",$columns->pluck('name')->toArray()) && in_array("name",$columns->pluck('name')->toArray())): ?>
        $this->model->slug = Str::slug($this->model->name);
<?php elseif(in_array("slug",$columns->pluck('name')->toArray()) && in_array("display_name",$columns->pluck('name')->toArray())): ?>
        $this->model->slug = Str::slug($this->model->display_name);
<?php elseif(in_array("slug",$columns->pluck('name')->toArray()) && in_array("title",$columns->pluck('name')->toArray())): ?>
        $this->model->slug = Str::slug($this->model->title);
<?php endif; ?>
        // Save Relationships
<?php if(count($relations)): ?>
<?php if(isset($relations['belongsTo']) && count($relations['belongsTo'])): ?>
<?php $__currentLoopData = $relations["belongsTo"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e(PHP_EOL); ?>

        if (isset($data-><?php echo e($relation["relationship_variable"]); ?>)) {
            $this->model-><?php echo e($relation['function_name']); ?>()
                ->associate($data-><?php echo e($relation["relationship_variable"]); ?>-><?php echo e($relation['owner_key']); ?>);
        }
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php endif; ?><?php echo e(PHP_EOL); ?>

        $this->model->saveOrFail();
        return $this->model;
    }

    public function destroy(): bool
    {
        return !!$this->model->delete();
    }

    public static function dtColumns() {
        $columns = [
<?php $__currentLoopData = $columnsToQuery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $type = "string";
    switch ($column['type']) {
        case 'bit':
        case 'tinyint':
        case 'smallint':
        case 'int':
        case 'bigint':
        case 'decimal':
        case 'numeric':
        case 'float':
        case 'real':
        case 'smallmoney':
        case 'money':
            $type = "num";
            break;
        case 'datetime':
        case 'datetime2':
        case 'smalldatetime':
        case 'time':
        case 'date':
        case 'datetimeoffset':
        case 'timestamp':
            $type = "date";
            break;
        default:
            $type = "string";
            break;
    }
?>
<?php $col = $column['name']; ?>
<?php if($col ==='id'): ?>
            Column::make('<?php echo e($col); ?>')->title('ID')->className('all text-right')->type("<?php echo e($type); ?>"),
<?php elseif($col==='name'||$col==='title'): ?>
            Column::make("<?php echo e($col); ?>")->className('all')->type("<?php echo e($type); ?>"),
<?php elseif($col==='created_at'|| $col==='updated_at'): ?>
            Column::make("<?php echo e($col); ?>")->className('min-tv')->type("<?php echo e($type); ?>"),
<?php else: ?>
            Column::make("<?php echo e($col); ?>")->className('min-tablet')->type("<?php echo e($type); ?>"),
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            Column::make('actions')->className('all text-right')->orderable(false)->searchable(false)->type("html"),
        ];
        return $columns;
    }

    public static function dt($query, $request) {
        $allowedColumns = [
<?php $__currentLoopData = $columnsToQuery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            '<?php echo e($col['name']); ?>',
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ];

        return DataTables::of($query)
            ->filter(function ($query) use ($request, $allowedColumns) {
                $sb    = new SearchBuilder($request, $query, $allowedColumns);
                $query = $sb->build();
            })
            ->editColumn('actions', function (<?php echo e($modelBaseName); ?> $model) {
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
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/role/repository.blade.php ENDPATH**/ ?>