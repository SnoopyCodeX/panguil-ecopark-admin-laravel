@extends('tourist.index')

@section('my_reservations')

<script>
    // Adult Total Price: pricePerHead x numberOfAdults
    // Children Total Price: (pricePerHead - (pricePerHead x childrenDiscountPercent)) x numberOfChildren

    function increaseNumberOfAdults(currentId, pricePerHead) {
        let numberOfAdultsInput = document.querySelector(`#number_of_adults${currentId}`);
        let adultsTotalInput = document.querySelector(`#adultsTotal${currentId}`);
        let childrenTotalInput = document.querySelector(`#childrenTotal${currentId}`);

        let childrenTotal = parseFloat(childrenTotalInput.value);
        let numberOfAdults = parseInt(numberOfAdultsInput.value) + 1;
        numberOfAdultsInput.value = numberOfAdults;

        let totalPriceInput = document.querySelector(`#total_price${currentId}`);
        let totalPrice = (numberOfAdults * pricePerHead);
        adultsTotalInput.value = totalPrice;

        totalPrice += childrenTotal;
        totalPriceInput.value = totalPrice;
    }

    function decreaseNumberOfAdults(currentId, pricePerHead) {
        let numberOfAdultsInput = document.querySelector(`#number_of_adults${currentId}`);
        let adultsTotalInput = document.querySelector(`#adultsTotal${currentId}`);
        let childrenTotalInput = document.querySelector(`#childrenTotal${currentId}`);

        if(parseInt(numberOfAdultsInput.value) == 1) return;

        let childrenTotal = parseFloat(childrenTotalInput.value);
        let numberOfAdults = parseInt(numberOfAdultsInput.value) - 1;
        numberOfAdultsInput.value = numberOfAdults;

        let totalPriceInput = document.querySelector(`#total_price${currentId}`);
        let totalPrice = (numberOfAdults * pricePerHead);
        adultsTotalInput.value = totalPrice;

        totalPrice += childrenTotal;
        totalPriceInput.value = totalPrice;
    }

    function increaseNumberOfChildren(currentId, pricePerHead, childrenDiscount) {
        let numberOfChildrenInput = document.querySelector(`#number_of_children${currentId}`);
        let adultsTotalInput = document.querySelector(`#adultsTotal${currentId}`);
        let childrenTotalInput = document.querySelector(`#childrenTotal${currentId}`);

        let adultTotal = parseInt(adultsTotalInput.value);
        let numberOfChildren = parseInt(numberOfChildrenInput.value) + 1;
        numberOfChildrenInput.value = numberOfChildren;

        let totalPriceInput = document.querySelector(`#total_price${currentId}`);

        let totalPrice = (pricePerHead - (pricePerHead * childrenDiscount)) * numberOfChildren;
        childrenTotalInput.value = totalPrice;

        totalPriceInput.value = totalPrice + adultTotal;
    }

    function decreaseNumberOfChildren(currentId, pricePerHead, childrenDiscount) {
        let numberOfChildrenInput = document.querySelector(`#number_of_children${currentId}`);
        let adultsTotalInput = document.querySelector(`#adultsTotal${currentId}`);
        let childrenTotalInput = document.querySelector(`#childrenTotal${currentId}`);

        if(numberOfChildrenInput.value == 0) return;

        let adultTotal = parseInt(adultsTotalInput.value);
        let numberOfChildren = parseInt(numberOfChildrenInput.value) - 1;
        numberOfChildrenInput.value = numberOfChildren;

        let totalPriceInput = document.querySelector(`#total_price${currentId}`);

        let totalPrice = (pricePerHead - (pricePerHead * childrenDiscount)) * numberOfChildren;
        childrenTotalInput.value = totalPrice;

        totalPriceInput.value = totalPrice + adultTotal;
    }

</script>

<div class="col d-flex flex-column justify-content-center align-items-center" style="width: 100vw; height: 100%;">

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="link-unstyled mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error') }}
        </div>
    @endif

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="col" style="min-width: 30%; max-width: 50%;">
        <h3 class="landing-heading-title">My Reservations</h3>
        @if(count($myReservations) > 0)
            @foreach($myReservations as $reservations)
                @php
                    $reservationType = $reservations['reservation_type'];
                    $adultsTotal = $reservationType['price_per_head'] * $reservations['number_of_adults'];
                    $childrenTotal = ($reservationType['price_per_head'] - ($reservationType['price_per_head'] * $reservationType['children_discount'])) * $reservations['number_of_children'];
                @endphp

                <div class="card mt-2 mx-0 w-60 rounded text-white" style="backdrop-filter: blur(5px); background-color:rgba(0,0,0, 0.15); outline: none;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md">
                                <h5>{{ $reservationType['name_of_spot'] }}</h5>
                                <img src="{{ $reservationType['photo'] }}" alt="Photo of {{ $reservationType['name_of_spot'] }}" class="img-fluid" width="300px" height="200px">
                            </div>

                            <div class="col-md">
                                <h5 class="text-center">{{ ucfirst($reservationType['size_of_spot']) }}</h5>
                                <ul>
                                    @foreach (explode('\n', $reservationType['description']) as $description)
                                        <li>{{ $description }}</li>
                                    @endforeach
                                </ul>

                                <p>Price per head: {{ $reservationType['price_per_head'] }} PHP<br>Adults Total: {{ $adultsTotal }} PHP<br>Children Total: {{ $childrenTotal }} PHP<br>Total: {{ $adultsTotal + $childrenTotal }} PHP</p>
                                <p>Child discount: {{ $reservationType['children_discount'] * 100 }}%</p>
                                <div class="d-grid grap-2">
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#viewReservation{{ $reservations['id'] }}">View Reservation</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="viewReservation{{ $reservations['id'] }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="viewReservationModal{{ $reservations['id'] }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <form action="{{ route('tourist.reservation.update') }}" method="post" autocomplete="off">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewReservationModal{{ $reservations['id'] }}">Reserved {{ $reservationType['name_of_spot'] }}</h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="col">
                                        <input type="hidden" class="form-control" name="adultsTotal" id="adultsTotal{{ $reservations['id'] }}" value="{{ $adultsTotal }}">
                                        <input type="hidden" class="form-control" name="childrenTotal" id="childrenTotal{{ $reservations['id'] }}" value="{{ $childrenTotal }}">
                                        <input type="hidden" name="reservation_id" class="form-control" value="{{ $reservationType['id'] }}">
                                        <input type="hidden" name="tourist_reservation_id" class="form-control" value="{{ $reservations['id'] }}">

                                        <div class="row mb-2">
                                            <div class="col-md">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        Adults
                                                    </div>

                                                    <button type="button" class="btn btn-outline-secondary" onclick="decreaseNumberOfAdults({{ $reservations['id'] }}, {{ $reservationType['price_per_head'] }})">-</button>
                                                    <input type="number" name="number_of_adults" id="number_of_adults{{ $reservations['id'] }}" value="{{ $reservations['number_of_adults'] }}" class="form-control" min="1" value="1" readonly required>
                                                    <button type="button" class="btn btn-outline-secondary" onclick="increaseNumberOfAdults({{ $reservations['id'] }}, {{ $reservationType['price_per_head'] }})">+</button>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        Children
                                                    </div>

                                                    <button type="button" class="btn btn-outline-secondary" onclick="decreaseNumberOfChildren({{ $reservations['id'] }}, {{ $reservationType['price_per_head'] }}, {{ $reservationType['children_discount'] }})">-</button>
                                                    <input type="number" name="number_of_children" id="number_of_children{{ $reservations['id'] }}" value="{{ $reservations['number_of_children'] }}" class="form-control" min="0" value="0" readonly required>
                                                    <button type="button" class="btn btn-outline-secondary" onclick="increaseNumberOfChildren({{ $reservations['id'] }}, {{ $reservationType['price_per_head'] }}, {{ $reservationType['children_discount'] }})">+</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md">
                                                <div class="input-group" id="datepicker{{ $reservations['id'] }}">
                                                    <div class="input-group-text">
                                                        Date
                                                    </div>
                                                    <input type="date" name="reserve_date" id="reserve_date{{ $reservations['id'] }}" class="form-control" value="{{ $reservations['reserve_date'] }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        Time
                                                    </div>
                                                    <input type="time" name="arrival_time" id="arrival_time{{ $reservations['id'] }}" class="form-control" value="{{ $reservations['arrival_time'] }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group mb-2">
                                            <div class="input-group-text">
                                                Phone No.
                                            </div>
                                            <input type="tel" name="phone_number" id="phone_number{{ $reservations['id'] }}" class="form-control" value="{{ $reservations['phone_number'] }}" required>
                                        </div>

                                        <div class="input-group mb-2">
                                            <div class="input-group-text">
                                                Total
                                            </div>
                                            <div class="input-group-text">
                                                ₱
                                            </div>
                                            <input type="number" name="total_price" id="total_price{{ $reservations['id'] }}" value="{{ $adultsTotal + $childrenTotal }}" class="form-control" readonly required>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="action" value="cancel_reservation" class="btn btn-danger">Cancel Reservation</button>
                                    <button type="submit" name="action" value="update_reservation" class="btn btn-primary">Update Reservation</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-danger" role="alert">
                You have no reservations yet. Go to <a href="{{ route('tourist.reservation') }}">Reservations</a> to create one!
            </div>
        @endif
    </div>
</div>

@endsection
