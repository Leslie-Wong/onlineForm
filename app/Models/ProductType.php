<?php

namespace App\Models;
/* Imports */
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\RouteBindingTrait;
use App\Helpers\OpensslHelper;

class ProductType extends Model
{
    use SoftDeletes;
        use HasFactory, RouteBindingTrait;

    protected $fillable = [
        'name',
        'lang',
        'status',
    
    ];
    
    
    
    protected $dates = [
        ];

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
        return route("api.product-types.index");
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

    /* ************************ RELATIONS ************************ */
}
