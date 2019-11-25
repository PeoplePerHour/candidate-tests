<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PPH</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

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
                PPH-nStamatakis
            </div>

            <div class="links">
                <h1>Files</h1>
                @if(count($files) > 0)

                <div class="well">
                    <div class="row">

                        <table id = "filesTable" class="table table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Path Stored</th>
                                    <th scope="col">Uploaded On</th>
                                    <th scope="col">Operation</th>
                                    <th scope="col">Apply</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                <tr>
                                    <th scope="row">{{$file->id}}</th>
                                    <th scope="row">{{$file->path.$file->name}}</th>
                                    <th scope="row">{{$file->created_at}}</th>
                                    <th>
                                        <select name="operation" id = "foMethod">
                                            <option value="FO_ValidFilePerLine">Valid and Insert to Table per Line
                                            </option>
                                    </th>
                                    <th scope="row"><a href name="applyOperation" id = "applyOperation" value="Apply File Operation"></a></th>       
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

                {{$files->links()}}
                @else
                <p>No Files found</p>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
{{Html::script('js/calls/applyOperation.js')}}