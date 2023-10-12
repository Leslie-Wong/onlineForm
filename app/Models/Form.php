<?php

namespace App\Models;
/* Imports */
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\RouteBindingTrait;
use App\Helpers\OpensslHelper;

class Form extends Model
{
    use SoftDeletes;
        use HasFactory, RouteBindingTrait;
    
    protected $fillable = [
        'name',
        'status',
    
    ];
    
    protected $defaults = [
        'name' => null,
        'status' => null,
    
    ];

    
    
    protected $dates = [
        ];

        protected $appends = ["api_route", "can", "slug"];
    
    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    /* ************************ ACCESSOR ************************* */

    public function getSlugAttribute()
    {
        $slug = "";
        if(isset($this->attributes['id']))
            $slug = OpensslHelper::encrypt($this->attributes['id']."@".$this->getTable());

        return $slug;
    }

    public function getApiRouteAttribute() {
        return route("api.forms.index");
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

        /*-----Auot Gen Fun-formAttributes-Start-----*/
    /**
    * Many to One Relationship to \App\Models\FormAttribute::class
    * @return \Illuminate\Database\Eloquent\Relations\hasMany
    */
    public function formAttributes() {
        return $this->hasMany(\App\Models\FormAttribute::class,"form_id","id");
    }
    /*-----Auot Gen Fun-formAttributes-End-----*/

    /*-----Auot Gen Fun-formAttribute-Start-----*/
    public function formAttribute()
    {
        return $this->hasOne(\App\Models\FormAttribute::class,"form_id","id")->withDefault();
    }
    /*-----Auot Gen Fun-formAttribute-End-----*/
}
