@extends('admin.index')

@section('reservations-css')
<link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endsection

@section('reservations-scripts')
<script src="{{ asset('assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendors/moment/moment.min.js') }}"></script>
{{-- <script>
    $(document).on("DOMContentLoaded", function() {
        $("#reservationsTable").DataTable({
            serverSide: true,
            ajax: "{{ route('admin.reservations') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'gender', name: 'gender', render: (data) => data.charAt(0).toUpperCase() + data.slice(1)},
                {data: 'age', name: 'age', render: (data) => `${data} yrs. old`},
                {data: 'contact_number', name: 'contact_number', render: (data) => data ?? 'N/A'},
                {data: 'created_at', name: 'created_at', render: (data) => moment(data).format('YYYY-MM-DD / hh:mm A')},
                {data: 'number_of_tourists', name: 'number_of_tourists'},
                {data: 'assigned_tour_guide', name: 'assigned_tour_guide'},
            ],
            dom: '<"row"<"col-12 col-md-6"l><"col-12 col-md-6"f>>' +
                    '<"row"<"col-12"t>>' +
                    '<"row"<"col-12 col-md-5"i><"col-12 col-md-7"p>>',
            lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "All"]],
            searching: true,
        });
    });
</script> --}}
@endsection

@section('reservations')

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Ecopark</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reservations</li>
        </ol>
    </nav>

    <div class="row">
        @if($errors->any())
            <div class="alert alert-danger mb-4" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        @if (!empty($error))
                            <li>{{ $error }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title">Tourist Reservations</h6>
                        {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newReservationModal"><i class="link-icon" data-feather="plus"></i> New Reservation</button> --}}
                    </div>
                    <p class="text-muted mb-3">List of tourist reservations along with their complete information and assigned tour guide.</p>
                    <div class="table-responsive">
                        <table id="reservationsTable" class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Date/Time</th>
                                    <th>Cottages/Kubo</th>
                                    <th>Name</th>
                                    <th>Number Of Tourist</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                               @if (count($reservations) > 0)
                                    @foreach ($reservations as $reservation)
                                        @php
                                            $reservationType = $reservation['reservation_type'];
                                            $adultsTotal = $reservationType['price_per_head'] * $reservation['number_of_adults'];
                                            $childrenTotal = ($reservationType['price_per_head'] - ($reservationType['price_per_head'] * $reservationType['children_discount'])) * $reservation['number_of_children'];
                                        @endphp
                                        <tr>
                                            <td>{{ $reservation['id'] }}</td>
                                            <td><img src="{{ $reservation['reservation_type']['photo'] }}" class="img-fluid" alt="Photo of {{ $reservation['reservation_type']['name_of_spot'] }}"></td>
                                            <td>{{ \Carbon\Carbon::parse($reservation['reserve_date'])->format('F d, Y') . " @ " . \Carbon\Carbon::parse($reservation['arrival_time'])->format('h:i A') }}</td>
                                            <td>{{ ucfirst($reservation['reservation_type']['name_of_spot']) }}</td>
                                            <td>{{ $reservation['user']['name'] }}</td>
                                            <td>{{ $reservation['number_of_adults'] . " Adults \n " . $reservation['number_of_children'] . " Children" }}</td>
                                            <td>{{ $adultsTotal + $childrenTotal . " PHP" }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
                                            <div class="alert alert-danger" role="alert">
                                                There are no reservations to fetch!
                                            </div>
                                        </td>
                                    </tr>
                               @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">EcoPark</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reservations</li>
        </ol>
    </nav>

    <div class="row">
        @if($errors->any())
            <div class="alert alert-danger mb-4" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        @if (!empty($error))
                            <li>{{ $error }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title">Tourist Reservations</h6>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newReservationModal"><i class="link-icon" data-feather="plus"></i> New Reservation</button>
                    </div>
                    <p class="text-muted mb-3">List of tourist reservations along with their complete information and assigned tour guide.</p>
                    <div class="table-responsive">
                        <table id="reservationsTable" class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Cellphone No.</th>
                                    <th>Date / Time</th>
                                    <th>Number of Tourists</th>
                                    <th>Assigned Tour GUide</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Reservation Modal -->
    <div class="modal fade" id="newReservationModal" tabindex="-1" aria-labelledby="newReservationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newReservationModalLabel">Add Reservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>

                <form action="{{ route('admin.add-reservation') }}" method="post" autocomplete="off">
                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" class="form-control" name="name" type="text" placeholder="Enter fullname..." value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="gender" value="male" id="gender1" @if(!empty(old('gender')) && old('gender') === 'male') checked @endif>
                                    <label class="form-check-label" for="gender1">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="gender" value="female" id="gender2" @if(!empty(old('gender')) && old('gender') === 'female') checked @endif>
                                    <label class="form-check-label" for="gender2">
                                        Female
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input id="age" class="form-control" name="age" type="number" placeholder="Enter age..." value="{{ old('age') }}">
                        </div>

                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input id="contact_number" class="form-control" name="contact_number" type="phone" placeholder="Enter contact number..." value="{{ old('contact_number') }}">
                        </div>

                        <div class="mb-3">
                            <label for="number_of_tourist" class="form-label">Number of tourist</label>
                            <input id="number_of_tourist" class="form-control" name="number_of_tourist" type="number" placeholder="Enter number of tourist..." value="{{ old('number_of_tourist') }}">
                        </div>

                        <div class="mb-3">
                            <label for="tour_guide_name" class="form-label">Tour Guide Name</label>
                            <input id="tour_guide_name" class="form-control" name="tour_guide_name" type="text" placeholder="Enter tour guide name..." value="{{ old('tour_guide_name') }}">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Add</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div> --}}
@endsection
