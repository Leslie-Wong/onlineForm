<?php echo "<?php";
?>

namespace <?php echo e($controllerNamespace); ?>;
<?php if($export): ?>
    use App\Exports\<?php echo e($exportBaseName); ?>;
    use Maatwebsite\Excel\Excel
<?php endif; ?>
use App\Http\Controllers\Controller;
use App\Http\Requests\<?php echo e($modelWithNamespaceFromDefault); ?>\Index<?php echo e($modelBaseName); ?>;
use App\Http\Requests\<?php echo e($modelWithNamespaceFromDefault); ?>\Store<?php echo e($modelBaseName); ?>;
use App\Http\Requests\<?php echo e($modelWithNamespaceFromDefault); ?>\Update<?php echo e($modelBaseName); ?>;
use App\Http\Requests\<?php echo e($modelWithNamespaceFromDefault); ?>\Destroy<?php echo e($modelBaseName); ?>;
use <?php echo e($modelFullName); ?>;
use <?php echo e($repoFullName); ?>;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Yajra\DataTables\Html\Column;
use App\Helpers\OpensslHelper;;

class <?php echo e($controllerBaseName); ?>  extends Controller
{
    private <?php echo e($repoBaseName); ?> $repo;
    public function __construct(<?php echo e($repoBaseName); ?> $repo)
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
        $this->authorize('viewAny', <?php echo e($modelBaseName); ?>::class);
        return Inertia::render('<?php echo e($modelPlural); ?>/Index',[
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', <?php echo e($modelBaseName); ?>::class),
                "create" => \Auth::user()->can('create', <?php echo e($modelBaseName); ?>::class),
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
        $this->authorize('create', <?php echo e($modelBaseName); ?>::class);
        return Inertia::render("<?php echo e($modelPlural); ?>/Create",[
            "can" => [
            "viewAny" => \Auth::user()->can('viewAny', <?php echo e($modelBaseName); ?>::class),
            "create" => \Auth::user()->can('create', <?php echo e($modelBaseName); ?>::class),
            ]
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * <?php echo e("@"); ?>param Store<?php echo e($modelBaseName); ?> $request
    * <?php echo e("@"); ?>return \Illuminate\Http\RedirectResponse
    */
    public function store(Store<?php echo e($modelBaseName); ?> $request)
    {
        try {
            $data = $request->sanitizedObject();



            foreach($request->files as $files_key => $files){
                if(is_array($files)){
                    foreach($request->file($files_key) as $idx => $val){
                        foreach($val as $_idx => $_val){
                            $fileName = time().'.'.$_val->getClientOriginalExtension();
                            $_val->move(public_path('upload/<?php echo e($modelBaseName); ?>/'.$files_key.'/'.$_idx), $fileName);
                            $data->{$files_key}[$idx]->{$_idx} = '/upload/<?php echo e($modelBaseName); ?>/'.$files_key.'/'.$_idx.'/'. $fileName;
                        }
                    }
                }else{
                    $fileName = time().'.'.$request->file($files_key)->getClientOriginalExtension();
                    $request->file($files_key)->move(public_path('upload/<?php echo e($modelBaseName); ?>'), $fileName);
                    $data->{$files_key} = '/upload/<?php echo e($modelBaseName); ?>/'.$fileName;
                }
            }

            $<?php echo e($modelVariableName); ?> = $this->repo::store($data);
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
    * <?php echo e("@"); ?>param Request $request
    * <?php echo e("@"); ?>param <?php echo e($modelBaseName); ?> $<?php echo e($modelVariableName); ?>

    * <?php echo e("@"); ?>return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function show(Request $request, <?php echo e($modelBaseName); ?> $<?php echo e($modelVariableName); ?>)
    {
        try {
            $this->authorize('view', $<?php echo e($modelVariableName); ?>);
            $model = $this->repo::init($<?php echo e($modelVariableName); ?>)->show($request);
            return Inertia::render("<?php echo e($modelPlural); ?>/Show", ["model" => $model]);
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
    * <?php echo e("@"); ?>param Request $request
    * <?php echo e("@"); ?>param <?php echo e($modelBaseName); ?> $<?php echo e($modelVariableName); ?>

    * <?php echo e("@"); ?>return \Inertia\Response|\Illuminate\Http\RedirectResponse
    */
    public function edit(Request $request, <?php echo e($modelBaseName); ?> $<?php echo e($modelVariableName); ?>)
    {
        try {
            $this->authorize('update', $<?php echo e($modelVariableName); ?>);
            //Fetch relationships
            <?php if(count($relations)): ?><?php echo e(PHP_EOL); ?>

<?php if(isset($relations['belongsTo']) && count($relations['belongsTo'])): ?><?php echo e(PHP_EOL); ?>

    <?php $parents = $relations['belongsTo']->pluck("function_name")->toArray(); ?>
    $<?php echo e($modelVariableName); ?>->load([
    <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        '<?php echo e($parent); ?>',
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ]);
<?php endif; ?>
            <?php endif; ?>
            return Inertia::render("<?php echo e($modelPlural); ?>/Edit", ["model" => $<?php echo e($modelVariableName); ?>]);
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
    * <?php echo e("@"); ?>param Update<?php echo e($modelBaseName); ?> $request
    * <?php echo e("@"); ?>param {$modelBaseName} $<?php echo e($modelVariableName); ?>

    * <?php echo e("@"); ?>return \Illuminate\Http\RedirectResponse
    */
    public function update(Update<?php echo e($modelBaseName); ?> $request, <?php echo e($modelBaseName); ?> $<?php echo e($modelVariableName); ?>)
    {
        try {
            $data = $request->sanitizedObject();



            foreach($request->files as $files_key => $files){
                if(is_array($files)){
                    foreach($request->file($files_key) as $idx => $val){
                        foreach($val as $_idx => $_val){
                            $fileName = time().'.'.$_val->getClientOriginalExtension();
                            $_val->move(public_path('upload/<?php echo e($modelBaseName); ?>/'.$files_key.'/'.$_idx), $fileName);
                            $data->{$files_key}[$idx]->{$_idx} = '/upload/<?php echo e($modelBaseName); ?>/'.$files_key.'/'.$_idx.'/'. $fileName;
                        }
                    }
                }else{
                    $fileName = time().'.'.$request->file($files_key)->getClientOriginalExtension();
                    $request->file($files_key)->move(public_path('upload/<?php echo e($modelBaseName); ?>'), $fileName);
                    $data->{$files_key} = '/upload/<?php echo e($modelBaseName); ?>/'.$fileName;
                }
            }

            $res = $this->repo::init($<?php echo e($modelVariableName); ?>)->update($data);
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
    * <?php echo e("@"); ?>param <?php echo e($modelBaseName); ?> $<?php echo e($modelVariableName); ?>

    * <?php echo e("@"); ?>return \Illuminate\Http\RedirectResponse
    */
    public function destroy(Destroy<?php echo e($modelBaseName); ?> $request, <?php echo e($modelBaseName); ?> $<?php echo e($modelVariableName); ?>)
    {
        $res = $this->repo::init($<?php echo e($modelVariableName); ?>)->destroy();
        if ($res) {
            return back()->with(['success' => "The record was deleted succesfully."]);
        }
        else {
            return back()->with(['error' => "The record could not be deleted."]);
        }
    }
}
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/controller.blade.php ENDPATH**/ ?>