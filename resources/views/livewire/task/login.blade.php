<div>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


    <div class="container mt-5" dir="rtl">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-end">
                        <h5 class="mb-0"><i class="bi bi-box-arrow-in-right ms-2"></i> ورود به حساب کاربری</h5>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger text-end" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                            <form wire:submit.prevent="login">
                                <div class="mb-3 text-end">
                                    <label for="email" class="form-label">ایمیل</label>
                                    <input type="email" class="form-control text-end" id="email" wire:model="email" required>
                                </div>


                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">ورود</button>
                                </div>
                            </form>

                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show mt-4 text-end" role="alert">
                                    <i class="bi bi-check2-circle me-2 fs-5"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif


                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
