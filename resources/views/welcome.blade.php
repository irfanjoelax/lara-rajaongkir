<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- style -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-3 mb-3 shadow">
                        <div class="card-header bg-primary text-white">
                          Cek Ongkos Kirim
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <form id="form-submit">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="province_origin">Provinsi Asal</label>
                                            <select name="province_origin" id="province_origin" class="form-control">
                                                @foreach ($provinces as $province => $value)
                                                    <option value="{{ $province }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="city_origin">Kota Asal</label>
                                            <select name="city_origin" id="city_origin" class="form-control">
                                                <option value="">-- Kota Asal --</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="province_destination">Provinsi Tujuan</label>
                                            <select name="province_destination" id="province_destination" class="form-control">
                                                @foreach ($provinces as $province => $value)
                                                    <option value="{{ $province }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="city_destination">Kota Tujuan</label>
                                            <select name="city_destination" id="city_destination" class="form-control">
                                                <option value="">-- Kota Asal --</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="courier">Kurir</label>
                                            <select name="courier" id="courier" class="form-control">
                                                @foreach ($couriers as $courier => $value)
                                                    <option value="{{ $courier }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="weight">Berat (gram)</label>
                                            <input type="number" name="weight" id="weight" value="1000" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                                <div class="col-md-5 mt-3">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>First</th>
                                                    <th>Last</th>
                                                    <th>Handle</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Mark</td>
                                                    <td>Otto</td>
                                                    <td>@mdo</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                // select form kota asal
                $('#province_origin').on('change', function () {
                    let provinceID = $(this).val();

                    if (provinceID) {
                        $.ajax({
                            type: "GET",
                            url: '/province/'+provinceID+'/cities',
                            dataType: "JSON",
                            success: function (response) {
                                $('#city_origin').empty();
                                $.each(response, function (key, value) { 
                                    $('#city_origin').append('<option value="'+key+'">'+value+'</option>');
                                });
                            }
                        });
                    } else {
                        $('#city_origin').empty();
                    }
                });

                // select form kota tujuan
                $('#province_destination').on('change', function () {
                    let provinceID = $(this).val();

                    if (provinceID) {
                        $.ajax({
                            type: "GET",
                            url: '/province/'+provinceID+'/cities',
                            dataType: "JSON",
                            success: function (response) {
                                $('#city_destination').empty();
                                $.each(response, function (key, value) { 
                                    $('#city_destination').append('<option value="'+key+'">'+value+'</option>');
                                });
                            }
                        });
                    } else {
                        $('#city_destination').empty();
                    }
                });

                // form submit
                $('#form-submit').submit(function (e) { 
                    e.preventDefault();
                    
                    $.ajax({
                        type: "POST",
                        url: "/",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "city_origin": $('#city_origin').val(),
                            "city_destination": $('#city_destination').val(),
                            "weight": $('#weight').val(),
                            "courier": $('#courier').val(),
                        },
                        dataType: "JSON",
                        success: function (response) {
                            console.log(response);
                        }
                    });
                });

            });
        </script>
    </body>
</html>
