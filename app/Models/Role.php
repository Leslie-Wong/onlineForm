<?php

namespace App\Models;
/* Imports */
use DateTimeInterface;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Spatie\Permission\Models\Role as SpatieRole;
use App\Helpers\RouteBindingTrait;
use App\Helpers\OpensslHelper;

class Role extends SpatieRole
{
    use HasFactory, RouteBindingTrait;

    protected $fillable = [
        'name',
        'guard_name',
        'title',
    
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
        return route("api.roles.index");
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
