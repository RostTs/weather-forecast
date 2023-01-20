<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <style type="text/css">

    </style>
</head>
<body>

<div class="container">
    <div class="row text-center">
        <div class="col-lg-6 offset-lg-3 col-sm-6 offset-sm-3 col-12 p-3 error-main">
            <div class="row">
                <div class="col-lg-8 col-12 col-sm-10 offset-lg-2 offset-sm-1">
                    <h4 class="m-0">Sorry</h4>
                    <h6>We failed to collect forecast in {{$cityName}}</h6>
                    <p>Unfortunately there are some issues with external clients, you can
                        <span class="text-info"><a href="/form">try again</a></span>, or
                        <span class="text-info">contact us</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
