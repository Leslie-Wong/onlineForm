<?php echo "<?php"
?>


namespace <?php echo e($modelNameSpace); ?>;
<?php
    $hasRoles = false;
    if(count($relations) && isset($relations["belongsToMany"]) && count($relations['belongsToMany'])) {
        $hasRoles = $relations['belongsToMany']->filter(function($belongsToMany) {
            return $belongsToMany['related_table'] == 'roles';
        })->count() > 0;
        $relations['belongsToMany'] = $relations['belongsToMany']->reject(function($belongsToMany) {
            return $belongsToMany['related_table'] == 'roles';
        });
    }
?>
/* Imports */
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<?php if($hasSoftDelete): ?>use Illuminate\Database\Eloquent\SoftDeletes;
<?php endif; ?>
<?php if(isset($relations['belongsToMany']) && count($relations['belongsToMany'])): ?>
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
<?php endif; ?>
<?php if($hasRoles): ?>use Spatie\Permission\Traits\HasRoles;
<?php endif; ?>
use App\Helpers\RouteBindingTrait;
use App\Helpers\OpensslHelper;

class <?php echo e($modelBaseName); ?> extends Model
{
<?php if($hasSoftDelete): ?>
    use SoftDeletes;
    <?php endif; ?>
<?php if($hasRoles): ?>use HasRoles;
    <?php endif; ?>
    use HasFactory, RouteBindingTrait;
<?php if(!is_null($tableName)): ?>protected $table = '<?php echo e($tableName); ?>';
    <?php endif; ?>
<?php if($fillable): ?>

    protected $fillable = [
    <?php $__currentLoopData = $fillable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    '<?php echo e($f); ?>',
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    ];
    <?php endif; ?>

    <?php if($hidden && count($hidden) > 0): ?>protected $hidden = [
    <?php $__currentLoopData = $hidden; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    '<?php echo e($h); ?>',
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    ];
    <?php endif; ?>

    <?php if($booleans && count($booleans) > 0): ?>protected $casts = [
    <?php $__currentLoopData = $booleans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    '<?php echo e($b); ?>' => 'boolean',
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    ];
    <?php endif; ?>

    protected $dates = [
<?php if($dates): ?>
    <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    '<?php echo e($date); ?>' => 'Y-m-d',
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php if($datetimes): ?>
    <?php $__currentLoopData = $datetimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    '<?php echo e($date); ?>',
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
];
<?php if(!$timestamps): ?>public $timestamps = false;
    <?php endif; ?>

    protected $appends = ["api_route", "can", "slug"];

    /* ************************ ACCESSOR ************************* */
    public function getSlugAttribute()
    {
        $slug = "";
        if(isset($this->attributes['id']))
            $slug = OpensslHelper::encrypt($this->attributes['id']."@".$this->getTable());

        return $slug;
    }

    public function getApiRouteAttribute() {
        return route("api.<?php echo e($routeBaseName); ?>.index");
    }

    public function getCanAttribute() {
        return [
            "view" => \Auth::check() && \Auth::user()->can("view", $this),
            "update" => \Auth::check() && \Auth::user()->can("update", $this),
            "delete" => \Auth::check() && \Auth::user()->can("delete", $this),
            "restore" => \Auth::check() && \Auth::user()->can("restore", $this),
            "forceDelete" => \Auth::check() && \Auth::user()->can("forceDelete", $this),
        ];
    }

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
<?php if(count($relations)): ?>

    /* ************************ RELATIONS ************************ */
<?php if(isset($relations['belongsTo']) && count($relations['belongsTo'])): ?>
<?php $__currentLoopData = $relations["belongsTo"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $belongsTo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    /**
    * Many to One Relationship to <?php echo e($belongsTo["related_model"]); ?>

    * <?php echo e('@'); ?>return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function <?php echo e($belongsTo['function_name']); ?>() {
        return $this->belongsTo(<?php echo e($belongsTo['related_model']); ?>,"<?php echo e($belongsTo['foreign_key']); ?>","<?php echo e($belongsTo["owner_key"]); ?>");
    }
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php if(isset($relations["belongsToMany"]) && count($relations['belongsToMany'])): ?>
<?php $__currentLoopData = $relations['belongsToMany']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $belongsToMany): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    /**
    * Relation to <?php echo e($belongsToMany['related_model_name_plural']); ?>

    *
    * <?php echo e('@'); ?>return BelongsToMany
    */
    public function <?php echo e(Str::camel($belongsToMany['related_table'])); ?>() {
        return $this->belongsToMany(<?php echo e($belongsToMany['related_model_class']); ?>, '<?php echo e($belongsToMany['relation_table']); ?>', '<?php echo e($belongsToMany['foreign_key']); ?>', '<?php echo e($belongsToMany['related_key']); ?>');
    }
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endif; ?>
<?php endif; ?>}
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/model.blade.php ENDPATH**/ ?>