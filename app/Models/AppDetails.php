<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppDetails extends Model
{	
	/**
	 * @var $table Table Name
	 */
	protected $table = 'app_detail';

    /**
	 * Save App Details
	 *
	 * @param Array $data App Details Data
	 *
	 * @return Object
	 */
	public function saveAppDetails(Array $data) {
		
		$app = new self;
		$app->app_id 	= $data['app_id'];
		$app->about 	= addslashes(stripslashes(utf8_encode($data['about'])));
		$app->images 	= $data['images'];
		$app->rating 	= $data['rating'];
		$app->additional_info 	= $data['additional_info'];
		$app->screenshot 		= $data['screenshot'];
		$app->video 	= $data['video'];
		
		if($app->save() === true){
			return $app;
		}

		return (Object) [];
	}

}
