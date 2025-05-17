<div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white text-end">
                <h5 class="mb-0"><i class="bi bi-plus-circle ms-2"></i>ایجاد وظیفه جدید</h5>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="save" dir="rtl">

                    <div class="row mb-4">
                        <div class="col-md-6 text-end">
                            <label class="form-label">عنوان</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-type"></i></span>
                                <input type="text" wire:model.defer="title" class="form-control" placeholder="مثلاً: طراحی صفحه اصلی">
                            </div>
                            @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 text-end">
                            <label class="form-label">تاریخ پایان</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                <input type="input" wire:model.defer="end_date" class="form-control">
                            </div>
                            @error('end_date') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 text-end">
                            <label class="form-label">اولویت</label>
                            <select wire:model.defer="priority" class="form-select">
                                <option value="">-- انتخاب اولویت --</option>
                                <option value="high">بالا</option>
                                <option value="medium">متوسط</option>
                                <option value="low">پایین</option>
                            </select>
                            @error('priority') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 text-end">
                            <label class="form-label">وضعیت</label>
                            <select wire:model.defer="status" class="form-select">
                                <option value="">-- انتخاب وضعیت --</option>
                                <option value="completed">تکمیل شده</option>
                                <option value="in_progress">در حال انجام</option>
                                <option value="pending">در انتظار</option>
                            </select>
                            @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4 text-end">
                        <label class="form-label">توضیحات</label>
                        <textarea wire:model.defer="description" class="form-control" rows="4" placeholder="توضیحاتی درباره وظیفه بنویسید..."></textarea>
                        @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-circle-fill ms-2"></i>ذخیره وظیفه
                        </button>
                    </div>

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-4 text-end" role="alert">
                            <i class="bi bi-check2-circle me-2 fs-5"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                </form>
            </div>
        </div>
    </div>


</div>
