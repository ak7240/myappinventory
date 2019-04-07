<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	/**
	 * @var $table Table Name
	 */
	protected $table = 'category';

	/**
	 * Save Category Data
	 *
	 * @param String $category_name Category Data
	 *
	 * @return Object
	 */
    public function saveCategory(String $category_name) {
		
		$category = new self;
		$category->name = $category_name;
		
		if($category->save() === true){
			return $category;
		}

		return (Object) [];
	}

	/**
	 * Get Category Data
	 *
	 * @param String $category Category Data
	 *
	 * @return Object
	 */
    public function getCategory(String $category) {
		
		$category = self::where('name', '=', $category)->first();

		return $category;
	}

}
