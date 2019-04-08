<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Apps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Console\Commands\CronMethods;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getIndex(Request $request)
    {
      $input_param = $request->input();

      $offset = (isset($input_param['offset']) === true) ? (int) $input_param['offset'] : 0;
      $total = (isset($input_param['total']) === true && $input_param['total'] <= 50) ? (int) $input_param['total'] : 20;

      $ajax = (isset($input_param['ajax']) === true) ? (int) $input_param['ajax'] : 0;

      if($ajax === 0){
        $offset = 0;
        $total = 20;
      }

      $app = new Apps;
      $app_details = $app->getAppList($offset, $total);
  
      return \View::make('home', ['app_details' => $app_details, 'ajax' => $ajax]);
      
    }

    public function getAppDetails(Request $request)
    {
      $input_param = $request->input();
      
      // Redirect when no package pass in request params.
      if(empty($input_param['pkg']) === true){
          return Redirect::to('/');
      }

      $app = new Apps;
      $app_details = $app->getAppDetails($input_param['pkg']);
      
      if(empty($app_details) === true){
        return \View::make('404', []);   
      }

      $app_details['screenshot'] = json_decode($app_details['screenshot']);
      foreach ($app_details['screenshot'] as $key => $value) {
        if(strpos($value, 'lh3.googleusercontent.com') === false){
          unset($app_details['screenshot'][$key]);
        }
      }
      
      $app_details['video'] = json_decode($app_details['video']);
      $app_details['additional_info'] = json_decode($app_details['additional_info']);

      return \View::make('detail', ['app_details' => $app_details]); 

      
    }

    public function getScrapping(){
        $cron_method = new CronMethods();
        $cron_method->syncApps();

        return true;
    }
}
