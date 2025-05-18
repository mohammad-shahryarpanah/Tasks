<div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">--}}



    {{--    <div class="container mt-3" dir="rtl">--}}
{{--        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded shadow-sm bg-light">--}}
{{--            <div class="d-flex align-items-center">--}}
{{--                <img src="{{ Auth::user()->profile_photo_url ?? 'https://via.placeholder.com/40' }}"--}}
{{--                     alt="Profile"--}}
{{--                     class="rounded-circle me-2"--}}
{{--                     style="width: 40px; height: 40px; object-fit: cover;">--}}
{{--                <span class="fw-bold">{{ Auth::user()->name ?? 'کاربر مهمان' }}</span>--}}
{{--            </div>--}}
{{--            <div>--}}
{{--                <a href="#" class="position-relative text-dark">--}}
{{--                    <i class="bi bi-bell fs-4"></i>--}}
{{--                    <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">--}}
{{--                    3--}}
{{--                    <span class="visually-hidden">اعلان جدید</span>--}}
{{--                </span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


    <div class="container mt-3" dir="rtl">
        <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded shadow-sm bg-light">

            <div class="dropdown">
                <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>{{ Auth::check() ? Auth::user()->name : 'کاربر مهمان' }}</span>
                </button>
                <ul class="dropdown-menu text-end" aria-labelledby="userMenu">
                    @auth
                        <li>

                                <button wire:click.prevent="logout" class="dropdown-item text-danger">خروج</button>
                        </li>
                    @endauth
                </ul>
            </div>

            <div class="dropdown">
                <button class="btn position-relative" type="button" id="notifMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-4"></i>
                    <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end text-end p-2" aria-labelledby="notifMenu" style="min-width: 250px;">
                </ul>
            </div>

        </div>
    </div>






    <div class="container mt-5" dir="rtl">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-list-task ms-2"></i> لیست وظایف
                </h5>

                <a href="{{ route('tasks.create') }}" class="btn btn-light btn-sm text-primary">
                    <i class="bi bi-plus-circle me-1"></i> ایجاد وظیفه
                </a>
            </div>


            <div class="card-body">
                <table class="table table-bordered text-center align-middle">
                    <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>تاریخ پایان</th>
                        <th>اولویت</th>
                        <th>وضعیت</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->end_date }}</td>
                            <td>
                                @if($task->priority === 'high')
                                    <span class="badge bg-danger">بالا</span>
                                @elseif($task->priority === 'medium')
                                    <span class="badge bg-warning text-dark">متوسط</span>
                                @else
                                    <span class="badge bg-secondary">پایین</span>
                                @endif
                            </td>
                            <td>
                                <select wire:change="updateStatus({{ $task->id }}, $event.target.value)" class="form-select">
                                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>در انتظار</option>
                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>در حال انجام</option>
                                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                                </select>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted">هیچ وظیفه‌ای ثبت نشده است.</td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>


</div>
