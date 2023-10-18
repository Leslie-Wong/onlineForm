<?php

namespace App\Models;
/* Imports */
use DateTimeInterface;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\RouteBindingTrait;
use App\Helpers\OpensslHelper;

class Permission extends \Spatie\Permission\Models\Permission
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
        return route("api.permissions.index");
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

    public function getGroupAttribute(): string
    {
        $explode = explode('.',$this->name);
        if (count($explode)) {
            $group = Str::title(str_replace("-"," ", $explode[0]));
        } else {
            $group = "Others";
        }
        return $group;
    }

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

    /* ************************ RELATIONS ************************ */
}
