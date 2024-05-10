@extends('admin.index')

@section('tracking-css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<link
  rel="stylesheet"
  href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css"
/>
<link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
<style>
.colored-toast.swal2-icon-success {
  background-color: #54C015 !important;
}

.colored-toast.swal2-icon-error {
  background-color: #CE1B1B !important;
}

.colored-toast.swal2-icon-warning {
  background-color: #f8bb86 !important;
}

.colored-toast.swal2-icon-info {
  background-color: #2DB4E1 !important;
}

.colored-toast.swal2-icon-question {
  background-color: #87adbd !important;
}

.colored-toast .swal2-title {
  color: white;
}

.colored-toast .swal2-close {
  color: white;
}

.colored-toast .swal2-html-container {
  color: white;
}

</style>
@endsection

@section('tracking-scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>
<script>
    var getGeofencesURL = "{{ route('system-admin.geofences') }}";
    var saveGeofenceURL = "{{ route('system-admin.geofences.save') }}";
    var updateGeofenceURL = "{{ route('tourist.index') }}/api/system-admin/geofences/{id}/update";
    var deleteGeofenceURL = "{{ route('tourist.index') }}/api/system-admin/geofences/{id}/delete";

    var getTouristLocationURL = "{{ route('tourist.index') }}/api/system-admin/tourist-location/{id}";
    var saveOrUpdateTouristLocationURL = "{{ route('tourist.index') }}/api/system-admin/tourist-location/{id}/save-or-update";
</script>
@endsection

@section('tracking')
<div class="page-content">
    <div class="row h-100">
        <div class="col-12 col-xl-12 stretch-card" id="map"></div>
    </div>
</div>
@endsection
