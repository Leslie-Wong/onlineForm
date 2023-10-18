<?php

namespace App\Models;
/* Imports */
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\RouteBindingTrait;
use App\Helpers\OpensslHelper;

class FormAttribute extends Model
{
    use HasFactory, RouteBindingTrait;
    
    protected $fillable = [
        'form_id',
        'name',
        'phone',
        'email',
        'product_sku',
        'product_name',
        'product_type',
        'brand',
        'ref_price',
        'place_of_origin',
        'product_image',
        'product_details',
    
    ];
    
    protected $defaults = [
        'form_id' => null,
        'name' => null,
        'phone' => null,
        'email' => null,
        'product_sku' => null,
        'product_name' => null,
        'product_type' => null,
        'brand' => null,
        'ref_price' => null,
        'place_of_origin' => null,
        'product_image' => null,
        'product_details' => null,
    
    ];

    
    
    protected $dates = [
        ];

        protected $appends = ["can", "slug"];
    
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

    public function getIdAttribute()
    {
        $slug = "";
        if(isset($this->attributes['id']))
            $slug = OpensslHelper::encrypt($this->attributes['id']."@".$this->getTable());

        return $slug;
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
    /**
    * Many to One Relationship to \App\Models\Form::class
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function form() {
        return $this->belongsTo(\App\Models\Form::class,"form_id","id");
    }

}
