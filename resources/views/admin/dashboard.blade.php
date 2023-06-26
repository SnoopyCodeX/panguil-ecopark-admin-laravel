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
        const colors = {
            primary: "#6571ff",
            secondary: "#7987a1",
            success: "#05a34a",
            info: "#66d1d1",
            warning: "#fbbc06",
            danger: "#ff3366",
            light: "#e9ecef",
            dark: "#060c17",
            muted: "#7987a1",
            gridBorder: "rgba(77, 138, 240, .15)",
            bodyColor: "#b8c3d9",
            cardBg: "#0c1427"
        };
        const fontFamily = "'Roboto', Helvetica, sans-serif";
        const months = [
            'Jan', 'Feb', 'Mar', 'Apr',
            'May', 'Jun', 'Jul', 'Aug',
            'Sep', 'Oct', 'Nov', 'Dec'
        ];
        let isLoading = false;

        document.addEventListener('DOMContentLoaded', () => {
            let quickSummariesData = @json($quickSummaries);
            let touristsData = @json($totalTouristsVisited);

            if ($('#total_rt_chart').length) {
                let dataRT = quickSummariesData.registered_tourists;
                let totalCount = dataRT.total_count;
                let percentage = dataRT.percentage;
                let perDayGraph = dataRT.per_day_graph_count;

                $('#total_rt_count').text(totalCount);
                $('#total_rt_percentage').html(`
                    <p class="${percentage >= 0 ? 'text-success' : 'text-danger'}">
                        <span>${percentage >= 0 ? '+' : ''}${percentage}%</span>
                        <i data-feather="${percentage >= 0 ? 'arrow-up' : 'arrow-down'}" class="icon-sm mb-1"></i>
                    </p>
                `);

                renderQuickSummaryChartFor('#total_rt_chart', perDayGraph);
            }

            if ($('#total_rv_chart').length) {
                let dataRV = quickSummariesData.reservations;
                let totalCount = dataRV.total_count;
                let percentage = dataRV.percentage;
                let perDayGraph = dataRV.per_day_graph_count;

                $('#total_rv_count').text(totalCount);
                $('#total_rv_percentage').html(`
                    <p class="${percentage >= 0 ? 'text-success' : 'text-danger'}">
                        <span>${percentage >= 0 ? '+' : ''}${percentage}%</span>
                        <i data-feather="${percentage >= 0 ? 'arrow-up' : 'arrow-down'}" class="icon-sm mb-1"></i>
                    </p>
                `);

                renderQuickSummaryChartFor('#total_rv_chart', perDayGraph);
            }

            if ($('#total_ttg_chart').length) {
                let dataRV = quickSummariesData.tourists_to_guide;
                let totalCount = dataRV.total_count;
                let percentage = dataRV.percentage;
                let perDayGraph = dataRV.per_day_graph_count;

                $('#total_ttg_count').text(totalCount);
                $('#total_ttg_percentage').html(`
                    <p class="${percentage >= 0 ? 'text-success' : 'text-danger'}">
                        <span>${percentage >= 0 ? '+' : ''}${percentage}%</span>
                        <i data-feather="${percentage >= 0 ? 'arrow-up' : 'arrow-down'}" class="icon-sm mb-1"></i>
                    </p>
                `);

                renderQuickSummaryChartFor('#total_ttg_chart', perDayGraph);
            }

            if ($('#total_tourists_chart').length) {
                let dataTourists = touristsData.data;
                renderTotalTouristsVisitedChart(dataTourists);
            }

            feather.replace();

            $('#reminders-container').scroll(function() {
                if(isScrolledToBottom()){
                    loadMoreData();
                }
            });
        });

        let renderQuickSummaryChartFor = (chartID, data) => {
            let options = {
                chart: {
                    type: "line",
                    height: 60,
                    sparkline: {
                        enabled: !0
                    }
                },
                series: [{
                    name: '',
                    data: data.map((dates) => dates[1]),
                }],
                xaxis: {
                    categories: data.map((dates) => dates[0]),
                },
                stroke: {
                    width: 2,
                    curve: "smooth"
                },
                markers: {
                    size: 0
                },
                colors: [colors.primary],
            };

            new ApexCharts(document.querySelector(chartID), options).render();
        };

        let renderTotalTouristsVisitedChart = (data) => {
            let currentYear = {{ Carbon\Carbon::now()->format('Y') }};
            let previousYear = currentYear - 1;

            let lineChartOptions = {
                chart: {
                    type: "area",
                    height: '400',
                    parentHeightOffset: 0,
                    foreColor: colors.bodyColor,
                    background: colors.cardBg,
                    toolbar: {
                        show: true
                    },
                },
                theme: {
                    mode: 'light'
                },
                tooltip: {
                    theme: 'light'
                },
                colors: [colors.primary, colors.muted, colors.danger, colors.warning],
                grid: {
                    padding: {
                        bottom: -4,
                    },
                    borderColor: colors.gridBorder,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                series: [
                    {
                        name: `${currentYear}`,
                        data: data[currentYear].map(count => count[1]),
                    },
                    {
                        name: `${previousYear}`,
                        data: data[previousYear].map(count => count[1]),
                    }
                ],
                dataLabels: {
                    enabled: false
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'center'
                },
                xaxis: {
                    categories: months,
                    labels: {
                        rotate: -45,
                    },
                    tickPlacement: 'on',
                    title: {
                        text: 'Months of each Year',
                        style: {
                            size: 9,
                            color: colors.muted
                        }
                    },
                    lines: {
                        show: true
                    },
                    axisBorder: {
                        color: colors.gridBorder,
                    },
                    axisTicks: {
                        color: colors.gridBorder,
                    },
                    crosshairs: {
                        stroke: {
                            color: colors.secondary,
                        },
                    },
                },
                yaxis: {
                    title: {
                        text: 'Tourists Visited',
                        style: {
                            size: 9,
                            color: colors.muted
                        }
                    },
                    tickAmount: 4,
                    tooltip: {
                        enabled: true
                    },
                    crosshairs: {
                        stroke: {
                            color: colors.secondary,
                        },
                    },
                },
                markers: {
                    size: 0,
                },
                stroke: {
                    width: 2,
                    curve: "smooth",
                },
            };

            new ApexCharts(document.querySelector('#total_tourists_chart'), lineChartOptions).render();
        };

        let isScrolledToBottom = () => {
            const container = document.getElementById('reminders-container');
            const scrollTop = container.scrollTop;
            const visibleHeight = container.clientHeight;
            const totalHeight = container.scrollHeight;

            return Math.round(scrollTop + visibleHeight) >= totalHeight;
        };

        let loadMoreData = () => {
            // Guard statement to check if we've got an on-going
            // AJAX request
            if(isLoading)
                return;

            isLoading = true;

            let url = $('#load-more a').data('next');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('#load-more').text('Loading more...');
                },
                success: function(response) {
                    $('#load-more').remove();
                    let data = response.data;

                    // 2 seconds timeout to prevent duplicate
                    // request to the server
                    setTimeout(() => {
                        isLoading = false;
                    }, 2000);

                    data.forEach(reminder => {
                        $('#reminders-container').append(`
                            <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                                <div class="me-3">
                                    <img src="${reminder.profile}" class="rounded-circle wd-35"
                                        alt="user">
                                </div>
                                <div class="w-100">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="text-body mb-2">${reminder.name}</h6>
                                        <p class="text-muted tx-12">${(new Date(reminder.created_at)).toLocaleTimeString('en-PH', {hour: 'numeric', minute: 'numeric', hour12: true})}</p>
                                    </div>
                                    <p class="text-muted tx-13">${reminder.content}</p>
                                </div>
                            </a>
                        `);
                    });

                    // Remove scroll listener on the #reminders-container
                    // if we have reached the last page
                    if(response.current_page === response.last_page) {
                        $('#reminders-container').off('scroll');
                    } else {
                        $('#reminders-container').append(`
                            <div class="d-flex align-items-center border-bottom text-muted py-3" id="load-more">
                                <a class='text-center' href='#' data-next="${response.next_page_url}">Scroll down to load more...</a>
                            </div>
                        `);
                    }
                },
                error: function(response) {
                    console.error(response);
                }
            });
        };
    </script>
@endsection

@section('dashboard')
    <div class="page-content">
        <!-- Quick Summary row -->
        <div class="row">
            @include('admin.layouts.dashboard.quick-summary')
        </div>
        <!-- End Quick Summary row -->

        <div class="row">
            <!-- Overall Tourists Graph -->
            @include('admin.layouts.dashboard.tourists-visited-graph')
            <!-- End Overall Tourists Graph -->

            <!-- Reminders Section -->
            @include('admin.layouts.dashboard.reminders')
            <!-- End Reminders Section -->
        </div> <!-- row -->
    </div>
@endsection
