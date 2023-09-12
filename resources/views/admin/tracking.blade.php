@extends('admin.index')

@section('tracking-css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endsection

@section('tracking-scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    var user = {!! auth()->user()->toJson() !!};
</script>
@endsection

@section('tracking')
<div class="page-content">
    <div class="row h-100">
        <div class="col-12 col-xl-12 stretch-card" id="map"></div>
    </div>
</div>
@endsection
