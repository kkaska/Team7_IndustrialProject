@extends('layouts.app')

@section('content')
@include('layouts.partials.search')

<div class="container-fluid mt-3">
{{-- <p>This page needs fixed a bit, the cards need to be responsive and the map should probably have a fixed height, but good enough for now</p>
<p>Map is also completely unconnected -> to do later</p>
<p> make the table scrollable</p>
<div class="container"> --}}
    <div class="card-group">
        <div class="card col overflow:auto border-success bg-light">
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <tr>

                        <th scope="col" class="align-middle">Treatment</th>
                        <th scope="col" class="align-middle">Hospital</th>
                        <th scope="col" class="align-middle">City</th>
                        <th scope="col" class="align-middle">@sortablelink('AverageCharges', 'Cost')</th>
                        <th scope="col" class="align-middle">Distance</th>
                    </tr>
                    <tbody>
                    @for($i = 0; $i < count($treatments); $i++)
                        <tr class="hospital-data" scope="row" data-hospital-address="{{ $treatments[$i]->HospitalAddress }}" data-hospital-postCode="{{ $treatments[$i]->HospitalPostCode }}">
                            <td>{{ $treatments[$i]->DiseaseName }}</td>
                            <td class="hospital-name">{{ $treatments[$i]->HospitalName }}</td>
                            <td class="hospital-city">{{ $treatments[$i]->City }}</td>
                            <td>@parseMoney($treatments[$i]->AverageCharges)</td>
                            <td>
                                <a href='treatment?disease={{urlencode($treatments[$i]->DiseaseID)}}&hospital={{urlencode($treatments[$i]->HospitalID)}}'>link</a>
                            </td>
                        </tr>
                    @endfor

                    </tbody>
                </table>

                {!! $treatments->appends(\Request::except('page'))->render() !!}
            </div>
        </div>
        <div class="card col-lg-5 border-success bg-light">
            <div class="card-body">
                <!-- Google Maps -->
                <div id="map"></div>
                <script>
                    var position = {lat: {{ json_encode($userLatitude) }}, lng: {{ json_encode($userLongitude) }}};   //Get Lat and Lng from laravel's session
                </script>
                <script src="{{ URL::asset('js/maps-list.js') }}"></script>
            </div>
        </div>
    </div>
</div>
@endsection