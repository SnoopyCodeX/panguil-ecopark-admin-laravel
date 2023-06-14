@extends('admin.index')

@section('dashboard-css')

<!-- Plugin css for this page -->
<link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
<!-- End plugin css for this page -->

@endsection

@section('dashboard-scripts')

 <!-- Plugin js for this page -->
 <script src="{{ asset('assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
 <script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
 <!-- End plugin js for this page -->

<script>
    document.addEventListener('DOMContentLoaded', () => {
        console.log('dashboard content loaded!');
        console.log(@json(Session::get('success')))
    });
</script>

@endsection

@section('dashboard')
<div class="page-content">
    {{-- <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Dashboard</h4>
        </div>

        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <!-- Calendar dropdown -->
            <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                <span class="input-group-text input-group-addon bg-transparent border-primary"
                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                <input type="text" class="form-control bg-transparent border-primary"
                    placeholder="Select date" data-input>
            </div>
            <!-- End Calendar dropdown -->
        </div>
    </div> --}}

    <!-- Quick Summary row -->
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                                <h6 class="card-title mb-0">Total Registered Tourists</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">3,897</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-success">
                                            <span>+3.3%</span>
                                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                                <h6 class="card-title mb-0">Total Reservations</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">35,084</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-danger">
                                            <span>-2.8%</span>
                                            <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                                <h6 class="card-title mb-0">Total Tourists to Guide</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">3,200</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-success">
                                            <span>+2.8%</span>
                                            <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Quick Summary row -->

    <div class="row">
        <!-- Overall Tourists Graph -->
        <div class="col-lg-7 col-xl-8 grid-margin grid-margin-xl-0 stretch-card">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                        <h6 class="card-title mb-0">Tourists</h6>
                    </div>
                    <div class="row align-items-start">
                        <div class="col-md-7">
                            <p class="text-muted tx-13 mb-3 mb-md-0">This graph shows the visual representation of the number of tourists that have visited last year and this year.</p>
                        </div>
                    </div>
                    <div id="revenueChart"></div>
                </div>
            </div>
        </div>
        <!-- End Overall Tourists Graph -->

        <!-- Reminders Section -->
        <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card" style="max-height: 525px; height: 525px;">
            <div class="card">
                <div class="card-body" style="max-height: 100%; height: 100%;">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-1">Reminders</h6>
                    </div>
                    <div class="d-flex flex-column reminders-container" style="max-height: 100%; height: 100%;">
                        <a href="javascript:;" class="d-flex align-items-center border-bottom pb-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/35x35"
                                    class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">Leonardo Payne</h6>
                                    <p class="text-muted tx-12">12.30 PM</p>
                                </div>
                                <p class="text-muted tx-13">Hey! there I'm available...</p>
                            </div>
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/35x35"
                                    class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">Carl Henson</h6>
                                    <p class="text-muted tx-12">02.14 AM</p>
                                </div>
                                <p class="text-muted tx-13">I've finished it! See you so..</p>
                            </div>
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/35x35"
                                    class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">Jensen Combs</h6>
                                    <p class="text-muted tx-12">08.22 PM</p>
                                </div>
                                <p class="text-muted tx-13">This template is awesome!</p>
                            </div>
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/35x35"
                                    class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">Amiah Burton</h6>
                                    <p class="text-muted tx-12">05.49 AM</p>
                                </div>
                                <p class="text-muted tx-13">Nice to meet you</p>
                            </div>
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/35x35"
                                    class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">Yaretzi Mayo</h6>
                                    <p class="text-muted tx-12">01.19 AM</p>
                                </div>
                                <p class="text-muted tx-13">Hey! there I'm available...</p>
                            </div>
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/35x35"
                                    class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">Yaretzi Mayo</h6>
                                    <p class="text-muted tx-12">01.19 AM</p>
                                </div>
                                <p class="text-muted tx-13">Hey! there I'm available...</p>
                            </div>
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/35x35"
                                    class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">Yaretzi Mayo</h6>
                                    <p class="text-muted tx-12">01.19 AM</p>
                                </div>
                                <p class="text-muted tx-13">Hey! there I'm available...</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Reminders Section -->
    </div> <!-- row -->
</div>
@endsection
