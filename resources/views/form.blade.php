<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel PHP Ajax Country State City Dropdown List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-success">Please select the country and city</h2>
                </div>
                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            <h4>City: {{session()->get('message')['city']}}</h4>
                                <p>Temperature: {{session()->get('message')['forecast']->temperature}}</p>
                                <p>Wind: {{session()->get('message')['forecast']->wind}}</p>
                                <p>Clouds: {{session()->get('message')['forecast']->clouds}}</p>
                                <p>Pressure: {{session()->get('message')['forecast']->pressure}}</p>
                            </div>
                    @endif
                    @if(count($errors))
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    <form method="GET" action="{{url('calculate-forecast')}}">
                        <div class="form-group">
                            <label for="country-dropdown">Country</label>
                            <select class="form-control" id="country-dropdown">
                                <option id="default-value" value="0" selected>Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}">
                                        {{$country->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="cityName" list="select-results" required>
                            <datalist id="select-results"></datalist>
                            <input type="hidden" id="cityId" name="city" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        if($('#country-dropdown').val() !== 0){
            getCities();
        }
        $('#country-dropdown').on('change', getCities);

        function getCities(){
            $("#select-results").empty();
            var country_id = $('#country-dropdown').val();
            $("#select-results").html('');
            $.ajax({
                url:"{{url('fetch-cities')}}",
                type: "GET",
                data: {
                    country_id: country_id
                },
                dataType : 'json',
                success: function(result){
                    $.each(result.cities,function(key,value){
                        $("#select-results").append('<option data-value="'+value.id+'" value="'+value.name+'">');
                    });
                }
            });
        }

        $('#city').on('input', function() {
            var city_name = this.value;
            var selectedValue = document.querySelector("#select-results option[value='"+city_name+"']")
            if(selectedValue){
                $("#cityId").val(selectedValue.dataset.value);
            }
        });
    });
</script>
</body>
</html>
