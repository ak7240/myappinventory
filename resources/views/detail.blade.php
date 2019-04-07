<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>App Inventory | {{ $app_details['app_name'] }}</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
      <link href="css/main.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
   </head>
   <body>
      <header>
         <nav class="navbar navbar-fixed-top navbar-default">
            <div class="container" style="height: 90px">
               <div class="collapse navbar-collapse">
                  <div class="col-md-2"> <a href="/"><img src="logo.png" alt="App Inventory" style="max-width: 75%;"></a></div>
                  <div class="col-md-6" style="padding-top: 15px;">
                     <h1 class="header-style">App Inventory</h1>
                  </div>
               </div>
            </div>
         </nav>
      </header>
      <div>
         <div id="main" class="container">
            <div class="row">
               <div class="col-md-8 col-sm-12" style="margin-top: 20px;">
                  <div id="content" class="row11">
                     <section class="box" style="height: 185px;">
                        <div class="col-md-3 height-width-150 margin-tp">
                           <img class="img-thumbnail lazy height-width-150" width="150" src="{{ $app_details['images'] }}"  alt="{{ $app_details['app_name'] }}">
                        </div>
                        <div class="pull-right">
                           <span class="label label-success"><strong>{{ $app_details['rating'] }}</strong><small>/5</small>
                           </span>     
                        </div>
                        <h1 style="display: inline;">{{ $app_details['app_name'] }}</h1>
                        <br>
                        <span class="label label-info">{{ $app_details['developer_name'] }}</span>&nbsp;<span class="label label-success">{{ $app_details['category_name'] }}</span>
                     </section>
                     <section class="box">
                        <div id="screenshot" class="carousel slide" data-ride="carousel">
                           <ol class="carousel-indicators">
                              @php $screenshot = 0 @endphp 
                              @if(empty($app_details['video']) === false)
                              @foreach($app_details['video'] as $value)
                              <li data-target="#screenshot" data-slide-to="{{$screenshot}}" @if($screenshot == 0)class="active"@endif></li>
                              @php $screenshot++ @endphp 
                              @endforeach
                              @endif
                              @foreach($app_details['screenshot'] as $value)
                              <li data-target="#screenshot" data-slide-to="{{$screenshot}}" @if($screenshot == 0)class="active"@endif></li>
                              @php $screenshot++; @endphp
                              @endforeach
                           </ol>
                           <div class="carousel-inner">
                              @php $screenshot = 0 @endphp 
                              @if(empty($app_details['video']) === false)
                              @foreach($app_details['video'] as $value)
                              <div class="item @if($screenshot == 0) active @endif">
                                 <img class="lazy img-responsive" src="{{$value->image_url}}" alt="{{ $app_details['app_name'] }}" style="margin-left: auto;margin-right: auto;">
                              </div>
                              @php $screenshot++; @endphp 
                              @endforeach
                              @endif
                              @foreach($app_details['screenshot'] as $value)
                              <div class="item @if($screenshot == 0) active @endif">
                                 <img class="lazy img-responsive" src="{{$value}}" alt="{{ $app_details['app_name'] }}" style="margin-left: auto;margin-right: auto;">
                              </div>
                              @php $screenshot++; @endphp 
                              @endforeach
                              <!-- Left and right controls -->
                              <a class="left carousel-control" href="#screenshot" data-slide="prev">
                              <span class="glyphicon glyphicon-chevron-left"></span>
                              <span class="sr-only">Previous</span>
                              </a>
                              <a class="right carousel-control" href="#screenshot" data-slide="next">
                              <span class="glyphicon glyphicon-chevron-right"></span>
                              <span class="sr-only">Next</span>
                              </a>
                           </div>
                     </section>
                     <section class="box">
                     <h2 class="myPrfl">About</h2><hr>
                     {!! str_replace('?', '', $app_details['about']) !!}
                     </section>
                     <section class="box">
                     <h2 class="myPrfl">Additional Info</h2>
                     <table  class='table noBorder mng'>
                     <tr>
                     @php $flag = 0; @endphp
                     @foreach($app_details['additional_info'] as $app)
                     @php $flag++; @endphp
                     <td style="width: 50%;">
                     <h4>{{ $app->type }}</h4>
                     <br>
                     {{ $app->info }}   
                     </td>
                     @if(($flag % 2) == 0 )
                     </tr><tr>
                     @endif
                     @endforeach
                     </tr>
                     </table>
                     </section>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>