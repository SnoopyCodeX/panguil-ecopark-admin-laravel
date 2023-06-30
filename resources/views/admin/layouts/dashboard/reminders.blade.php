<div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card" style="max-height: 525px; height: 525px;">
    <div class="card">
        <div class="card-body" style="max-height: 100%; height: 100%;">
            <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-1">Reminders</h6>
            </div>
            <div class="d-flex flex-column reminders-container" style="max-height: 100%; height: 100%;" id="reminders-container">
                @foreach ($reminders as $reminder)
                    <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                        <div class="me-3">
                            <img src="{{ $reminder->profile }}" class="rounded-circle wd-35" alt="user">
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-body mb-2">{{ $reminder->name }}</h6>
                                <p class="text-muted tx-12">
                                    {{ \Carbon\Carbon::parse($reminder->created_at)->format('h:i A') }}</p>
                            </div>
                            <p class="text-muted tx-13">{{ $reminder->content }}</p>
                        </div>
                    </a>
                @endforeach

                @if ($reminders->hasMorePages())
                    <div class="d-flex align-items-center border-bottom py-3 text-muted" id="load-more">
                        <a class='text-center' href="#" data-next='{{ $reminders->nextPageUrl() }}'>Scroll down to load more...</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
