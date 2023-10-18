<?php

namespace App\Helpers;

use App\Helpers\OpensslHelper;



trait RouteBindingTrait
{
    /**
	 * Cached hashslug
	 * @var null|string
	 */
	private $hashslug = null;

    /**
	 * Used in implicit model binding AND
	 * used in explicit model binding if no callback
	 * is specified, eg: Route::model('post', Post::class)
	 *
	 * @param  string $slug
	 * @param  string|null  $field
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function resolveRouteBinding($slug, $field = null){
		$id = explode("@", OpensslHelper::decrypt($slug)) ;
		return parent::where($field ?? $this->getKeyName(), $id[0])->first();
	}

    /**
	 * Hashslug calculated from id
	 * @return string
	 */
	public function slug(){
		if (is_null($this->hashslug)){

			$this->hashslug = OpensslHelper::encrypt($this->{$this->getKeyName()}."@".$this->getTable());
		}

		return $this->hashslug;
	}

    public function getRouteKeyName(){
		return 'hashslug';
	}

	public function getRouteKey() {
		return $this->slug();
	}
}
