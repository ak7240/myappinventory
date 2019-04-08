@if($ajax == 0)
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>AppInventory | Top Free Android Apps</title>
      <meta name="theme-color" content="#ffffff"/>
      <link rel="shortcut icon" href="favicon.ico">
      <script type="text/javascript">
         function loadCSS(e,t,o){var s=window.document.createElement("link"),n=t||window.document.getElementsByTagName("script")[0];s.rel="stylesheet",s.href=e,s.media="only x",n.parentNode.insertBefore(s,n),setTimeout(function(){s.media=o||"all"})}loadCSS("https://fonts.googleapis.com/css?family=Roboto:400");
      </script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   </head>
   <body>
      <header >
         <div class="container">
            <script type="text/javascript">
               loadCSS("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css");
               loadCSS("css/main.css");
               
            </script>
            <div class="col-md-3">
               <img src="logo.png" alt="home-logo">
            </div>
            <div class="col-md-8">
               <h1 class="header-style">Find interesting Android Applications</h1>
            </div>
            <button type="button" class="btn btn-primary btn-lg scrap-data" onclick="scrapData();">Sync Data</button>
         </div>
      </header>
      <div class="container">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12" id="left-box">
               <h2 class="header-style">Top Free Android Apps</h2>
               <div class="row list-data">
@endif
                  @foreach($app_details as $app)
                     <section class="col-md-3 col-sm-3">
                        <div class="box" >
                           <a href="/appdetails?pkg={{ $app['web_id'] }}" title="{{ $app['app_name'] }}">
                              <img class="lazy img-responsive" src="{{ $app['images'] }}"  alt="{{ $app['app_name'] }}" style="width:100%">
                           </a>
                           <a style="text-decoration:none;color:inherit" href="/appdetails?pkg={{ $app['web_id'] }}" title="{{ $app['app_name'] }}">
                              <strong class="title" >{{ str_limit($app['app_name'], $limit = 30, $end = '...') }}</strong>
                           </a>
                           <small class="text-muted">{{ $app['developer_name'] }}</small>
                        </div>
                     </section>
                  @endforeach
@if($ajax == 0)
               </div>
               <hr style="margin-top: 5px!important;margin-bottom: 5px!important">
            </div>
         </div>
      </div>
      <div class="ajax-load text-center" style="display:none">
         <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More Apps</p>
      </div>

      <script type="text/javascript">
         var offset = 0;
         var load_start = 1;

         $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height() && load_start == 1) {
               offset+=20;
               load_start = 0;
               loadMoreData(offset);
            }
         });

         function loadMoreData(offset){
            $.ajax(
               {
                  url: "/?ajax=1&offset="+offset+"&total=20",
                  type: "get",
                  beforeSend: function()
                  {
                     $('.ajax-load').show();
                  }
               }).done(function(data){
                  
                  $('.ajax-load').hide();
                  if(data != ""){
                     load_start = 1;
                     $(".list-data").append(data);
                  }
               })
               .fail(function(jqXHR, ajaxOptions, thrownError){
                  load_start = 1;
                  alert('server not responding...');
               });

         }
         
         function scrapData(){
               $.ajax(
                  {
                     url: "/scrap",
                     type: "get",
                     beforeSend: function()
                     {
                        $('.scrap-data').addClass('disabled');
                     }
                  }).done(function(data){
                     
                     if(typeof data  != 'undefined'){
                        $('.scrap-data').removeClass('disabled');
                     }
                  })
                  .fail(function(jqXHR, ajaxOptions, thrownError){
                     $('.scrap-data').removeClass('disabled');
                     alert('server not responding... please try after some time');
                  });
            
            }
      </script>
   </body>
</html>
@endif
