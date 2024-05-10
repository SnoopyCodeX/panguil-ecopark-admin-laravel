<link href="{{ asset('assets/vendors/prismjs/themes/prism.css') }}" rel="stylesheet" />

<script src="{{ asset('assets/vendors/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/vendors/toastr.js/toastr.min.js') }}"></script>

<div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card" style="max-height: 530px; height: 530px;">
    <div class="card">
        <div class="card-body" style="max-height: 100%; height: 100%;">
            <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0">
                    Reminders
                </h6>
                <button class="btn btn-xs btn-icon-text btn-primary" data-bs-toggle="modal" data-bs-target="#newReminderModal">
                    <i data-feather="plus"></i>
                    New Reminder
                </button>
            </div>
            <div class="d-flex flex-column reminders-container" style="max-height: 100%; height: 100%;"
                id="reminders-container">
                @foreach ($reminders as $reminder)
                    <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                        <div class="me-3">
                            <img src="{{ $reminder->profile }}" class="rounded-circle wd-40 ht-40" alt="user">
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-body mb-2">{{ $reminder->name }}</h6>
                                <p class="text-muted tx-12" id="time-created-{{ $reminder->id }}">
                                    @if (\Carbon\Carbon::parse($reminder->created_at)->isPast())
                                        <script>
                                            document.querySelector('#time-created-{{ $reminder->id }}').innerHTML =
                                                `${moment('{{ $reminder->created_at }}').fromNow()}`;
                                        </script>
                                    @else
                                        {{ \Carbon\Carbon::parse($reminder->created_at)->format('h:i A') }}
                                    @endif
                                </p>
                            </div>
                            <p class="text-muted tx-13">{{ $reminder->content }}</p>
                        </div>
                    </a>
                @endforeach

                @if ($reminders->hasMorePages())
                    <div class="d-flex align-items-center border-bottom py-3 text-muted" id="load-more">
                        <a class='text-center' href="#" data-next='{{ $reminders->nextPageUrl() }}'>Scroll down to
                            load more...</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- New Reminder Modal -->
<div class="modal fade" id="newReminderModal" tabindex="-1" aria-labelledby="newReminderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newReminderModalLabel">Add Reminder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>

            <form action="{{ route('admin.add-reminder') }}" method="post">
                @csrf

                <div class="modal-body">
                    <div class="mb-3">
                        <textarea name="reminder-content" class="form-control" maxlength="100" rows="8" placeholder="Type here..." style="height: 277px;"></textarea>
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
