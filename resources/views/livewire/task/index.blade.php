<div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


    <div class="container mt-5" dir="rtl">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white text-end">
                <h5 class="mb-0"><i class="bi bi-list-task ms-2"></i> لیست وظایف</h5>
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

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-4 text-end" role="alert">
                            <i class="bi bi-check2-circle me-2 fs-5"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </table>
            </div>
        </div>
    </div>


</div>
