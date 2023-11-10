@extends('tourist.index')

@section('reservations')

<script>
    // Adult Total Price: pricePerHead x numberOfAdults
    // Children Total Price: (pricePerHead - (pricePerHead x childrenDiscountPercent)) x numberOfChildren

    function increaseNumberOfAdults(currentId, pricePerHead, type) {
        let numberOfAdultsInput = document.querySelector(`#number_of_adults${currentId}_${type}`);
        let adultsTotalInput = document.querySelector(`#adultsTotal${currentId}_${type}`);
        let childrenTotalInput = document.querySelector(`#childrenTotal${currentId}_${type}`);

        let childrenTotal = parseFloat(childrenTotalInput.value);
        let numberOfAdults = parseInt(numberOfAdultsInput.value) + 1;
        numberOfAdultsInput.value = numberOfAdults;

        let totalPriceInput = document.querySelector(`#total_price${currentId}_${type}`);
        let totalPrice = (numberOfAdults * pricePerHead);
        adultsTotalInput.value = totalPrice;

        totalPrice += childrenTotal;
        totalPriceInput.value = totalPrice;
    }

    function decreaseNumberOfAdults(currentId, pricePerHead, type) {
        let numberOfAdultsInput = document.querySelector(`#number_of_adults${currentId}_${type}`);
        let adultsTotalInput = document.querySelector(`#adultsTotal${currentId}_${type}`);
        let childrenTotalInput = document.querySelector(`#childrenTotal${currentId}_${type}`);

        if(parseInt(numberOfAdultsInput.value) == 1) return;

        let childrenTotal = parseFloat(childrenTotalInput.value);
        let numberOfAdults = parseInt(numberOfAdultsInput.value) - 1;
        numberOfAdultsInput.value = numberOfAdults;

        let totalPriceInput = document.querySelector(`#total_price${currentId}_${type}`);
        let totalPrice = (numberOfAdults * pricePerHead);
        adultsTotalInput.value = totalPrice;

        totalPrice += childrenTotal;
        totalPriceInput.value = totalPrice;
    }

    function increaseNumberOfChildren(currentId, pricePerHead, childrenDiscount, type) {
        let numberOfChildrenInput = document.querySelector(`#number_of_children${currentId}_${type}`);
        let adultsTotalInput = document.querySelector(`#adultsTotal${currentId}_${type}`);
        let childrenTotalInput = document.querySelector(`#childrenTotal${currentId}_${type}`);

        let adultTotal = parseInt(adultsTotalInput.value);
        let numberOfChildren = parseInt(numberOfChildrenInput.value) + 1;
        numberOfChildrenInput.value = numberOfChildren;

        let totalPriceInput = document.querySelector(`#total_price${currentId}_${type}`);

        let totalPrice = (pricePerHead - (pricePerHead * childrenDiscount)) * numberOfChildren;
        childrenTotalInput.value = totalPrice;

        totalPriceInput.value = totalPrice + adultTotal;
    }

    function decreaseNumberOfChildren(currentId, pricePerHead, childrenDiscount, type) {
        let numberOfChildrenInput = document.querySelector(`#number_of_children${currentId}_${type}`);
        let adultsTotalInput = document.querySelector(`#adultsTotal${currentId}_${type}`);
        let childrenTotalInput = document.querySelector(`#childrenTotal${currentId}_${type}`);

        if(numberOfChildrenInput.value == 0) return;

        let adultTotal = parseInt(adultsTotalInput.value);
        let numberOfChildren = parseInt(numberOfChildrenInput.value) - 1;
        numberOfChildrenInput.value = numberOfChildren;

        let totalPriceInput = document.querySelector(`#total_price${currentId}_${type}`);

        let totalPrice = (pricePerHead - (pricePerHead * childrenDiscount)) * numberOfChildren;
        childrenTotalInput.value = totalPrice;

        totalPriceInput.value = totalPrice + adultTotal;
    }

</script>

<div class="row bg-white" style="width: 100vw; height: 100%;">

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

    {{-- Kubos --}}
    <div class="col-lg px-4">
        <h3 class="landing-heading-title">Available Kubos</h3>
        @foreach($kubos as $kubo)
            <div class="card mt-2 mx-0 w-60 rounded" style="backdrop-filter: blur(5px); background-color:rgba(0,0,0, 0.15); outline: none;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md">
                            <h5>{{ $kubo['name_of_spot'] }}</h5>
                            <img src="{{ $kubo['photo'] }}" alt="Photo of {{ $kubo['name_of_spot'] }}" class="img-fluid" width="300px" height="200px">
                        </div>

                        <div class="col-md">
                            <h5 class="text-center">{{ ucfirst($kubo['size_of_spot']) }}</h5>
                            <ul>
                                @foreach (explode('\n', $kubo['description']) as $description)
                                    <li>{{ $description }}</li>
                                @endforeach
                            </ul>

                            <p>Price: {{ $kubo['price_per_head'] }} PHP</p>
                            <p>Child discount: {{ $kubo['children_discount'] * 100 }}%</p>
                            <div class="d-grid grap-2">
                                @if(!Auth::guard('tourist')->check())
                                    <a class="btn btn-warning" href="{{ route('tourist.login') }}">Reserve</a>
                                @else
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createKuboReservation{{ $kubo['id'] }}">Reserve</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="createKuboReservation{{ $kubo['id'] }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="createKuboReservationModal{{ $kubo['id'] }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form action="{{ route('tourist.reservation.create') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createKuboReservationModal{{ $kubo['id'] }}">Reserve {{ $kubo['name_of_spot'] }}</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="col">
                                    <input type="hidden" class="form-control" name="adultsTotal" id="adultsTotal{{ $kubo['id'] }}_kubo" value="{{ $kubo['price_per_head'] }}">
                                    <input type="hidden" class="form-control" name="childrenTotal" id="childrenTotal{{ $kubo['id'] }}_kubo" value="0">
                                    <input type="hidden" name="reservation_id" class="form-control" value="{{ $kubo['id'] }}">

                                    <div class="row mb-2">
                                        <div class="col-md">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    Adults
                                                </div>

                                                <button type="button" class="btn btn-outline-secondary" onclick="decreaseNumberOfAdults({{ $kubo['id'] }}, {{ $kubo['price_per_head'] }}, 'kubo')">-</button>
                                                <input type="number" name="number_of_adults" id="number_of_adults{{ $kubo['id'] }}_kubo" class="form-control" min="1" value="1" readonly required>
                                                <button type="button" class="btn btn-outline-secondary" onclick="increaseNumberOfAdults({{ $kubo['id'] }}, {{ $kubo['price_per_head'] }}, 'kubo')">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    Children
                                                </div>

                                                <button type="button" class="btn btn-outline-secondary" onclick="decreaseNumberOfChildren({{ $kubo['id'] }}, {{ $kubo['price_per_head'] }}, {{ $kubo['children_discount'] }}, 'kubo')">-</button>
                                                <input type="number" name="number_of_children" id="number_of_children{{ $kubo['id'] }}_kubo" class="form-control" min="0" value="0" readonly required>
                                                <button type="button" class="btn btn-outline-secondary" onclick="increaseNumberOfChildren({{ $kubo['id'] }}, {{ $kubo['price_per_head'] }}, {{ $kubo['children_discount'] }}, 'kubo')">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md">
                                            <div class="input-group" id="datepicker{{ $kubo['id'] }}_kubo">
                                                <div class="input-group-text">
                                                    Date
                                                </div>
                                                <input type="date" name="reserve_date" id="reserve_date{{ $kubo['id'] }}_kubo" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    Time
                                                </div>
                                                <input type="time" name="arrival_time" id="arrival_time{{ $kubo['id'] }}_kubo" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group mb-2">
                                        <div class="input-group-text">
                                            Phone No.
                                        </div>
                                        <input type="tel" name="phone_number" id="phone_number{{ $kubo['id'] }}_kubo" class="form-control" required>
                                    </div>

                                    <div class="input-group mb-2">
                                        <div class="input-group-text">
                                            Total
                                        </div>
                                        <div class="input-group-text">
                                            ₱
                                        </div>
                                        <input type="number" name="total_price" id="total_price{{ $kubo['id'] }}_kubo" value="{{ $kubo['price_per_head'] }}" class="form-control" readonly required>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Reserve</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @endforeach
    </div>

    {{-- Cottages --}}
    <div class="col-lg px-4">
        <h3 class="landing-heading-title">Available Cottages</h3>

        @foreach($cottages as $cottage)
            <div class="card mt-2 mx-0 w-60 rounded" style="backdrop-filter: blur(5px); background-color:rgba(0,0,0, 0.15); outline: none;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md">
                            <h5>{{ $cottage['name_of_spot'] }}</h5>
                            <img src="{{ $cottage['photo'] }}" alt="Photo of {{ $cottage['name_of_spot'] }}" class="img-fluid" width="300px" height="200px">
                        </div>

                        <div class="col-md">
                            <h5 class="text-center">{{ ucfirst($cottage['size_of_spot']) }}</h5>
                            <ul>
                                @foreach (explode('\n', $cottage['description']) as $description)
                                    <li>{{ $description }}</li>
                                @endforeach
                            </ul>

                            <p>Price: {{ $cottage['price_per_head'] }} PHP</p>
                            <p>Child discount: {{ $cottage['children_discount'] * 100 }}%</p>
                            <div class="d-grid grap-2">
                                @if(!Auth::guard('tourist')->check())
                                    <a class="btn btn-warning" href="{{ route('tourist.login') }}">Reserve</a>
                                @else
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createCottageReservation{{ $cottage['id'] }}">Reserve</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="createCottageReservation{{ $cottage['id'] }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="createCottageReservationModal{{ $cottage['id'] }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form action="{{ route('tourist.reservation.create') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createCottageReservationModal{{ $cottage['id'] }}">Reserve {{ $cottage['name_of_spot'] }}</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="col">
                                    <input type="hidden" class="form-control" name="adultsTotal" id="adultsTotal{{ $cottage['id'] }}_cottage" value="{{ $cottage['price_per_head'] }}">
                                    <input type="hidden" class="form-control" name="childrenTotal" id="childrenTotal{{ $cottage['id'] }}_cottage" value="0">
                                    <input type="hidden" name="reservation_id" class="form-control" value="{{ $cottage['id'] }}">

                                    <div class="row mb-2">
                                        <div class="col-md">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    Adults
                                                </div>

                                                <button type="button" class="btn btn-outline-secondary" onclick="decreaseNumberOfAdults({{ $cottage['id'] }}, {{ $cottage['price_per_head'] }}, 'cottage')">-</button>
                                                <input type="number" name="number_of_adults" id="number_of_adults{{ $cottage['id'] }}_cottage" class="form-control" min="1" value="1" readonly required>
                                                <button type="button" class="btn btn-outline-secondary" onclick="increaseNumberOfAdults({{ $cottage['id'] }}, {{ $cottage['price_per_head'] }}, 'cottage')">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    Children
                                                </div>

                                                <button type="button" class="btn btn-outline-secondary" onclick="decreaseNumberOfChildren({{ $cottage['id'] }}, {{ $cottage['price_per_head'] }}, {{ $cottage['children_discount'] }}, 'cottage')">-</button>
                                                <input type="number" name="number_of_children" id="number_of_children{{ $cottage['id'] }}_cottage" class="form-control" min="0" value="0" readonly required>
                                                <button type="button" class="btn btn-outline-secondary" onclick="increaseNumberOfChildren({{ $cottage['id'] }}, {{ $cottage['price_per_head'] }}, {{ $cottage['children_discount'] }}, 'cottage')">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    Date
                                                </div>
                                                <input type="date" name="reserve_date" id="reserve_date{{ $cottage['id'] }}_cottage" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    Time
                                                </div>
                                                <input type="time" name="arrival_time" id="arrival_time{{ $cottage['id'] }}_cottage" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group mb-2">
                                        <div class="input-group-text">
                                            Phone No.
                                        </div>
                                        <input type="tel" name="phone_number" id="phone_number{{ $cottage['id'] }}_cottage" class="form-control" required>
                                    </div>

                                    <div class="input-group mb-2">
                                        <div class="input-group-text">
                                            Total
                                        </div>
                                        <div class="input-group-text">
                                            ₱
                                        </div>
                                        <input type="number" name="total_price" id="total_price{{ $cottage['id'] }}_cottage" value="{{ $cottage['price_per_head'] }}" class="form-control" readonly required>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Reserve</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
