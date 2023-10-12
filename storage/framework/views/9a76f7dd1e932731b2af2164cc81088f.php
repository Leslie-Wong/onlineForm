<?php echo "<?php";
?>

namespace <?php echo e($repoNamespace); ?>;

use <?php echo e($modelFullName); ?>;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Column;
use App\Helpers\OpensslHelper;
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
        <?php if(in_array("slug",$columns->pluck('name')->toArray()) && in_array("name",$columns->pluck('name')->toArray())): ?>
$model->slug = Str::slug($model->name);
        <?php elseif(in_array("slug",$columns->pluck('name')->toArray()) && in_array("display_name",$columns->pluck('name')->toArray())): ?>
$model->slug = Str::slug($model->name);
        <?php elseif(in_array("slug",$columns->pluck('name')->toArray()) && in_array("title",$columns->pluck('name')->toArray())): ?>
$model->slug = Str::slug($model->title);
        <?php endif; ?>
        // Save Relationships
        <?php if(count($relations)): ?>
    <?php if(isset($relations['belongsTo']) && count($relations['belongsTo'])): ?><?php echo e(PHP_EOL); ?>

        <?php $__currentLoopData = $relations["belongsTo"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
if (isset($data-><?php echo e($relation["relationship_variable"]); ?>)) {
            $model-><?php echo e($relation['function_name']); ?>()
                ->associate($data-><?php echo e($relation["relationship_variable"]); ?>-><?php echo e($relation['owner_key']); ?>);
        }
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
        <?php endif; ?><?php echo e(PHP_EOL); ?>

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
<?php if($column['type'] == 'enum'): ?>
    Column::make("<?php echo e($col); ?>")->className('min-tablet')->type("ENUM")->content(json_encode(['options' => [<?php echo $column['options']; ?>]])),
<?php else: ?>
    Column::make("<?php echo e($col); ?>")->className('min-tablet')->type("<?php echo e($type); ?>"),
<?php endif; ?>
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
<?php if(isset($rootOptions) && in_array('pdfview', $rootOptions)): ?>
                $actions = '<button class="bg-danger hover:bg-danger-600 p-2 px-3 text-yellow-500 focus:ring-0 focus:outline-none action-button" title="__("PDF View")" data-action="pdf-view-model" data-tag="button" data-id="'.$model->slug().'"><svg id="PDF_24" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect width="24" height="24" stroke="none" fill="#000000" opacity="0"></rect>


                    <g transform="matrix(0.43 0 0 0.43 12 12)">
                    <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" translate(-25, -25)" d="M 7 2 L 7 48 L 43 48 L 43 15.410156 L 29.183594 2 Z M 9 4 L 28 4 L 28 17 L 41 17 L 41 46 L 9 46 Z M 30 5.578125 L 39.707031 15 L 30 15 Z M 23.769531 19.875 C 23.019531 19.875 22.242188 20.300781 21.902344 20.933594 C 21.558594 21.5625 21.535156 22.238281 21.621094 22.941406 C 21.753906 24.050781 22.257813 25.304688 22.910156 26.589844 C 22.585938 27.683594 22.429688 28.636719 21.941406 29.804688 C 21.320313 31.292969 20.558594 32.472656 19.828125 33.710938 C 18.875 34.15625 17.671875 34.554688 16.96875 35.015625 C 16.179688 35.535156 15.554688 36 15.1875 36.738281 C 15.007813 37.105469 14.914063 37.628906 15.09375 38.101563 C 15.273438 38.574219 15.648438 38.882813 16.035156 39.082031 C 16.855469 39.515625 17.800781 39.246094 18.484375 38.785156 C 19.167969 38.324219 19.777344 37.648438 20.390625 36.824219 C 20.699219 36.40625 20.945313 35.730469 21.25 35.242188 C 22.230469 34.808594 22.925781 34.359375 24.039063 33.976563 C 25.542969 33.457031 26.882813 33.238281 28.289063 32.933594 C 29.464844 33.726563 30.714844 34.34375 32.082031 34.34375 C 32.855469 34.34375 33.453125 34.308594 34.035156 33.992188 C 34.621094 33.675781 34.972656 32.914063 34.972656 32.332031 C 34.972656 31.859375 34.765625 31.355469 34.4375 31.03125 C 34.105469 30.707031 33.714844 30.535156 33.3125 30.425781 C 32.515625 30.210938 31.609375 30.226563 30.566406 30.332031 C 30.015625 30.390625 29.277344 30.683594 28.664063 30.796875 C 28.582031 30.734375 28.503906 30.707031 28.421875 30.636719 C 27.175781 29.5625 26.007813 28.078125 25.140625 26.601563 C 25.089844 26.511719 25.097656 26.449219 25.046875 26.359375 C 25.257813 25.570313 25.671875 24.652344 25.765625 23.960938 C 25.894531 23.003906 25.921875 22.167969 25.691406 21.402344 C 25.574219 21.019531 25.378906 20.632813 25.039063 20.335938 C 24.699219 20.039063 24.21875 19.875 23.769531 19.875 Z M 23.6875 21.867188 C 23.699219 21.867188 23.71875 21.875 23.734375 21.878906 C 23.738281 21.886719 23.746094 21.882813 23.777344 21.980469 C 23.832031 22.164063 23.800781 22.683594 23.78125 23.144531 C 23.757813 23.027344 23.621094 22.808594 23.609375 22.703125 C 23.550781 22.238281 23.625 21.941406 23.65625 21.890625 C 23.664063 21.871094 23.675781 21.867188 23.6875 21.867188 Z M 24.292969 28.882813 C 24.910156 29.769531 25.59375 30.597656 26.359375 31.359375 C 25.335938 31.632813 24.417969 31.730469 23.386719 32.085938 C 23.167969 32.160156 23.042969 32.265625 22.828125 32.34375 C 23.132813 31.707031 23.511719 31.234375 23.785156 30.578125 C 24.035156 29.980469 24.078125 29.476563 24.292969 28.882813 Z" stroke-linecap="round"></path>
                    </g>

                    </svg></button>';
<?php else: ?>
                $actions = '';
<?php endif; ?>
                if (\Auth::user()->can('view',$model)) $actions .= '<button class="bg-primary hover:bg-primary-600 p-2 px-3 focus:ring-0 focus:outline-none text-green-500 action-button" title="__("View Details")" data-action="show-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-eye"></i></button>';
                if (\Auth::user()->can('update',$model)) $actions .= '<button class="bg-secondary hover:bg-secondary-600 p-2 px-3 focus:ring-0 focus:outline-none text-orange-500 action-button" title="__("Edit Record")" data-action="edit-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-edit"></i></button>';
                if (\Auth::user()->can('delete',$model)) $actions .= '<button class="bg-danger hover:bg-danger-600 p-2 px-3 text-yellow-500 focus:ring-0 focus:outline-none action-button" title="__("Delete Record")" data-action="delete-model" data-tag="button" data-id="'.$model->slug().'"><i class="fas fa-trash"></i></button>';
                return "<div class='gap-x-1 flex w-full justify-end'>".$actions."</div>";
            })
            ->rawColumns(['actions'])
            ->make();
    }
}
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/repository.blade.php ENDPATH**/ ?>