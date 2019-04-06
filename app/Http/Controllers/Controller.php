<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getIndex()
    {
        $crawler = \Goutte::request('POST', 'https://play.google.com/store/apps/collection/topselling_free', 
        	[	
            'start' => 0,
				    'num' => 10,
				    'numChildren' => 0,
				    'ipf'=> 1,
				    'xhr'=> 1
			     ]);

  
      $app_ids = $crawler->filter('.preview-overlay-container')->each(function ($node){
          
         return $node->attr('data-docid');
      });
    	
      $app_details = [];
      foreach ($app_ids as $value) {
        $app_details[] = array_merge(['app_id' => $value], self::getAppDetail($value));
      }

      echo json_encode($app_details);exit();

      
    }

    public static function getAppDetail(String $app_id){
      $crawler = \Goutte::request('GET', 'https://play.google.com/store/apps/details?id='.$app_id);
      $app_name = $crawler->filter('.AHFaub span')->text();
      $app_image = $crawler->filter('.dQrBL img')->attr('src');
      $developer_name_and_app_type = $crawler->filter('.T32cc a')->each(function($node){ return $node->text();});  
      $developer_name = $developer_name_and_app_type[0];
      $app_type = $developer_name_and_app_type[1];  

      $description = $crawler->filter('.DWPxHb content div')->html();
      $app_rating = $crawler->filter('.BHMmbe')->text();

      $addition_info = $crawler->filter('.IxB2fe .hAyfc')->each(function($node){
        return [
          'info_type' => $node->filter('.BgcNfc')->text(),
          'info' => $node->filter('.htlgb')->text()
        ];
      });

      $app_screenshot = $crawler->filter('.PlKpub .R66Fic')->each(function($node){ return $node->filter('img')->attr('src');});

      $app_video = $crawler->filter('.PlKpub .MSLVtf')->each(function($node){ return [
          'video_url' => $node->filter('.TdqJUe button')->attr('data-trailer-url'),
          'video_image_url' => $node->filter('img')->attr('src')
      ];});


      return [
        'app_name' => $app_name,
        'app_image' => $app_image,
        'developer_name' => $developer_name,
        'app_type'  => $app_type,
        'description' => $description,
        'app_rating' => $app_rating,
        'addition_info' => $addition_info,
        'app_screenshot' => $app_screenshot,
        'app_video' => $app_video
      ];
    }
}
