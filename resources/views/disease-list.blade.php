@extends('layouts.app')
@section('pageTitle', 'Search Result')
@section('content')
@include('layouts.partials.search')

<div class="container-fluid mt-3 mb-3">
    <div class="card-group">

        <div class="card col-sm-12 col-md-12 col-lg-12 col-xl-12 overflow:auto border-success bg-light" style="min-height: 500px; min-width:320px;">
            <div class="card-body table-responsive pl-0 pr-0">
                <p class="lead text-center pl-3 pr-3" style="font-size: 20px;" >You are searching for <strong>{{ $disease }}</strong> in <strong>{{ $city }}</strong> within <strong>{{ $radius }}</strong> miles.</p>
                <table class="table table-hover table-sm">
                <caption style="display: none;">A table displaying a list of hospitals that provide the searched procedure.</caption>
                    <tr>
                        <th scope="col" class="align-middle">Hospital</th>
                        <th scope="col" class="align-middle">City</th>
                        <th scope="col" class="align-middle">
                            @if(request()->has('cost'))
                                @if(request()->get('cost') == 'DESC' )
                                    <a href="{{ url()->full() }}&cost=ASC">
                                        Cost <span class="fa fa-chevron-down"></span>
                                    </a>
                                @else
                                    <a href="{{ url()->full() }}&cost=DESC">
                                        Cost <span class="fa fa-chevron-up"></span>
                                    </a>
                                @endif
                            @else
                                <a href="{{ url()->full() }}&cost=ASC">
                                    Cost
                                </a>
                            @endif
                        </th>
                        <th scope="col" class="align-middle" colspan="2">
                            @if(request()->has('distance'))
                                @if(request()->get('distance') == 'DESC' )
                                    <a href="{{ url()->full() }}&distance=ASC">
                                        Distance <span class="fa fa-chevron-down"></span>
                                    </a>
                                @else
                                    <a href="{{ url()->full() }}&distance=DESC">
                                        Distance <span class="fa fa-chevron-up"></span>
                                    </a>
                                @endif
                            @else
                                <a href="{{ url()->full() }}&distance=ASC">
                                    Distance
                                </a>
                            @endif
                        </th>
                    </tr>
                    <tbody>
                        @for($i = 0; $i < count($treatments); $i++)
                        <tr class="hospital-data" scope="row" data-hospital-address="{{ $treatments[$i]->HospitalAddress }}" data-hospital-postCode="{{ $treatments[$i]->HospitalPostCode }}">
                            <td class="hospital-name align-middle">{{ $treatments[$i]->HospitalName }}</td>
                            <td class="hospital-city text-capitalize align-middle">{{ $treatments[$i]->City }}</td>
                            <td class="align-middle">@parseMoney($treatments[$i]->AverageCharges)</td>
                            <td class="distance align-middle" style="min-width: 60px">@parseDistance($treatments[$i]->Distance)</td>
                            <td class="align-middle">
                                <a class="btn btn-secondary" href='treatment?disease={{urlencode($treatments[$i]->DiseaseID)}}&hospital={{urlencode($treatments[$i]->HospitalID)}}'>View</a>
                            </td>
                        </tr>
                        @endfor
                        @if(count($treatments) === 0)
                        <tr> <td> No treatments Found </td> </tr>
                        <script> ("No treatments found, Try searching again with different parameters!"); </script>
                        @endif
                    </tbody>
                </table>
                <div class="flexBox" style="display: flex; flex-flow: row wrap; justify-content: center;">
                    {!! $treatments->appends(\Request::except('page'))->render() !!}
                </div>
            </div>
        </div>
        <div class="card col-sm-12 col-md-12 col-lg-12 col-xl-6 border-success bg-light p-3" style="min-height: 500px; min-width: 320px;">
            <div class="card-body " style="position: relative">
                <!-- Google Maps -->
                <div style="position: absolute; top: 0; right: 0; bottom: 0; left: 0" id="map"></div>
                <script>
                    var position = {lat: {{ json_encode($userLatitude) }}, lng: {{ json_encode($userLongitude) }}};   //Get Lat and Lng from laravel's session
                </script>
                <script src="{{ URL::asset('js/maps-list.js') }}"></script>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        //Autocomplete the search form
        let searchParams = new URLSearchParams(window.location.search);

        if (searchParams.has('radius')) {
            $('#radius option[value=' + searchParams.get('radius') + ']').prop('selected', true);
        }
    });
</script>
@endsection

