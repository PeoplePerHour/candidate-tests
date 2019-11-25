<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PPH</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    {{-- {{Html::script('css/phh.css')}} --}}
    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">

        <div class="content">
            <div class="title m-b-md">
                Tomorrow's weather forecast
            </div>






            {{-- <div class="form-group">
    {{Form::label('body', 'Body')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!} --}}


        <div class="links">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="well well-sm">
                            {!! Form::open(['action' => 'ForecastController@sourceCall', 'method' => 'POST', 'enctype'
                            =>
                            'multipart/form-data']) !!}
                            <fieldset>
                                <legend class="text-center header">UI Api Endpoint</legend>
                                <h3>Let's find your Location</h3>
                                <div class="form-group">
                                    <span class="col-md-1 col-md-offset-2 text-center"><i
                                            class="fa fa-user bigicon"></i></span>
                                    <div class="row">
                                        <div class="col-md-4">
                                            {{Form::text('country_name', '', ["id"=>"countryId",'class' => 'form-control', 'placeholder' => 'Country'])}}
                                            <select class="form-control" id="getCountriesDropDown" style = "display:"">
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" id="getCitiesDropDown" >
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 text-center">
                                        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .header {
                    color: #36A0FF;
                    font-size: 27px;
                    padding: 10px;
                }

                .bigicon {
                    font-size: 35px;
                    color: #36A0FF;
                }
            </style>

        </div>
    </div>
    </div>
</body>

</html>
<style>
    .header {
        color: #36A0FF;
        font-size: 27px;
        padding: 10px;
    }

    .bigicon {
        font-size: 35px;
        color: #36A0FF;
    }
</style>
{{Html::script('js/calls/findLocation.js')}}