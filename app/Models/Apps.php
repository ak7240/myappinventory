<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AppDetails;

class Apps extends Model
{
	/**
	 * @var $table Table Name
	 */
	protected $table = 'app';

	/**
	 * Save App Data
	 *
	 * @param Array $data App Data
	 *
	 * @return Object
	 */
    public function saveApp(Array $data) {
		
		$app = new self;
		$app->web_id = $data['web_id'];
		$app->app_name = utf8_encode($data['app_name']);
		$app->developer_name = utf8_encode($data['developer_name']);
		$app->category_id = $data['category_id'];
		
		if($app->save() === true){
			return $app;
		}

		return (Object) [];
	}

	/**
	 * Get App Data
	 *
	 * @param String $web_id Web Id
	 *
	 * @return Object
	 */
    public function getApp(String $web_id) {
		
		$app = self::where('web_id', '=', $web_id)->first();
		
		return $app;
	}

	/**
	 * Get App Count
	 *
	 * @return Object
	 */
    public function getAppCount() {
		
		$app_count= self::count();
		
		return $app_count;
	}

	/**
	 * Get App Data and app Details
	 *
	 * @param integer $offset Offset
	 * @param integer $total Total
	 *
	 * @return Object
	 */
    public function getAppList(int $offset, int $total) {
		
		$app_details= self::from('app as a')->join('app_detail as ad','a.id','=','ad.app_id')->select(
			'a.web_id as web_id',
			'a.app_name as app_name',
			'a.developer_name as developer_name',
			'ad.images',
			'ad.rating as rating'
			)->offset($offset)->limit($total)->get();

		if(empty($app_details) === true){
			return [];
		}

		return $app_details->toArray();
	}

	/**
	 * Get App Data and app Details
	 *
	 * @param String $web_id Web Id
	 *
	 * @return Object
	 */
    public function getAppDetails(String $web_id) {
		
		$app_details= self::from('app as a')
				->join('app_detail as ad','a.id','=','ad.app_id')
				->leftjoin('category as c', 'a.category_id', '=', 'c.id')
				->select(
					'a.web_id as web_id',
					'a.app_name as app_name',
					'a.developer_name as developer_name',
					'ad.about as about',
					'ad.images',
					'ad.rating as rating',
					'ad.additional_info',
					'ad.screenshot',
					'ad.video',
					'c.name as category_name'
				)->where('a.web_id', '=', $web_id)->first();

		if(empty($app_details) === true){
			return [];
		}

		return $app_details->toArray();
	}

}
