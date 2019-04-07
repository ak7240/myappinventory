<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Apps;
use App\Models\AppDetails;


Class CronMethods {


    public function __construct()
    {
        echo Date('Y-m-d h:i:s')." ";
    }

    public function syncApps() {
        $app = new Apps;
        $app_count = $app->getAppCount();

        $crawler = \Goutte::request('POST', 'https://play.google.com/store/apps/collection/topselling_free', 
            [   
                'start' => $app_count,
                'num' => 60,
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

        foreach ($app_details as $value) {
           // echo $value['description'];exit();
            $category_obj = new Category;
            $category = $category_obj->getCategory($value['app_type']);
            if(empty($category) === true){
                $category = $category_obj->saveCategory($value['app_type']);
            }

           

            if(empty($app->getApp($value['app_id'])) === false){
                continue;
            }

            $app = $app->saveApp([
                'web_id' => $value['app_id'],
                'app_name' => $value['app_name'],
                'developer_name' => $value['developer_name'],
                'category_id' => $category->id
            ]);

            if(empty($app) === true){
                continue;
            }

            $app_details = new AppDetails;
            $app_details = $app_details->saveAppDetails([
                'app_id' => $app->id,
                'about'  => $value['description'],
                'images'  => $value['app_image'],
                'rating'  => $value['app_rating'],
                'additional_info'  => json_encode($value['addition_info']),
                'screenshot'  => json_encode($value['app_screenshot']),
                'video'     => json_encode($value['app_video'])
            ]);

        }

        

    }

     public static function getAppDetail(String $app_id) {
      
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
          'type' => $node->filter('.BgcNfc')->text(),
          'info' => $node->filter('.htlgb')->text()
        ];
        });

        $app_screenshot = $crawler->filter('.PlKpub .R66Fic')->each(function($node){ return $node->filter('img')->attr('src');});

        $app_video = $crawler->filter('.PlKpub .MSLVtf')->each(function($node){ return [
          'url' => $node->filter('.TdqJUe button')->attr('data-trailer-url'),
          'image_url' => $node->filter('img')->attr('src')
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


}// end Class