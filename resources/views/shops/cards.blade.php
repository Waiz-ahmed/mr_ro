@extends('layouts.master')

@section('title', 'My Shops')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark">My Shops</h4>
            <!-- <button class="btn" style="background-color: #0d6efd; color: white; border: none;" data-bs-toggle="modal" data-bs-target="#addShopModal">Add Shop</button> -->
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                style="background-color: #d4edda; color: #155724; border: none;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($shops as $shop)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm"
                        style="background-color: white; border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title fw-semibold mb-0" style="color: #212529;">{{ $shop->name }}</h5>
                                <span class="badge"
                                    style="background-color: #e7f1ff; color: #0d6efd; font-size: 0.75rem; padding: 0.35rem 0.65rem; border-radius: 20px;">Shop</span>
                            </div>

                            <p class="card-text mb-3" style="color: #6c757d;">
                                <i class="bi bi-geo-alt-fill me-1" style="color: #0d6efd;"></i>
                                {{ $shop->location ?? 'No location specified' }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3"
                                style="border-top: 1px solid #f1f1f1;">
                                <p class="small mb-0" style="color: #adb5bd;">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $shop->created_at->diffForHumans() }}
                                </p>
                                <button class="btn btn-sm go-to-pos"
                                    data-shop-id="{{ $shop->id }}"
                                    style="background-color: #0d6efd; color: white; border: none; border-radius: 8px; padding: 0.5rem 1.2rem; font-weight: 500;">
                                    <i class="bi bi-cart me-1"></i>Go to POS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5"
                        style="background-color: white; border-radius: 12px; border: 1px dashed #dee2e6;">
                        <i class="bi bi-shop" style="font-size: 3rem; color: #0d6efd;"></i>
                        <p class="text-muted mt-3 mb-0">No shops found. Click "Add Shop" to create your first shop.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Add Shop Modal -->
    <div class="modal fade" id="addShopModal" tabindex="-1" aria-labelledby="addShopModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('shops.cards.store') }}" method="POST" class="modal-content border-0"
                style="border-radius: 16px;">
                @csrf
                <div class="modal-header border-0 pb-0" style="background-color: white;">
                    <h5 class="modal-title fw-bold" id="addShopModalLabel" style="color: #212529;">Add New Shop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-3" style="background-color: white;">
                    <div class="mb-3">
                        <label for="shopName" class="form-label fw-medium" style="color: #495057;">Shop Name</label>
                        <input type="text" name="name" id="shopName" class="form-control" required
                            style="border: 1px solid #e0e0e0; border-radius: 10px; padding: 0.6rem 1rem; background-color: white; color: #212529;">
                    </div>
                    <div class="mb-3">
                        <label for="shopLocation" class="form-label fw-medium" style="color: #495057;">Location</label>
                        <input type="text" name="location" id="shopLocation" class="form-control"
                            style="border: 1px solid #e0e0e0; border-radius: 10px; padding: 0.6rem 1rem; background-color: white; color: #212529;">
                        <div class="form-text" style="color: #6c757d;">Optional: Add your shop's address or location</div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0" style="background-color: white;">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                        style="background-color: #f8f9fa; color: #495057; border: none; border-radius: 10px; padding: 0.6rem 1.5rem;">Cancel</button>
                    <button type="submit" class="btn"
                        style="background-color: #0d6efd; color: white; border: none; border-radius: 10px; padding: 0.6rem 1.5rem; font-weight: 500;">
                        <i class="bi bi-plus-circle me-1"></i>Create Shop
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        button:hover {
            opacity: 0.9;
            transition: opacity 0.2s;
        }

        .btn-close:focus {
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        .badge {
            font-weight: 500;
        }

        /* Modal backdrop styling */
        .modal-content {
            overflow: hidden;
        }
    </style>

    <!-- Add Bootstrap Icons if not already included in master layout -->
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @endpush

    {{-- POS Enter Password Modal --}}
    <div class="modal fade" id="posEnterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
            <div class="modal-content border-0" style="border-radius: 16px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Enter POS Session</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3">Enter your password to start a POS session.</p>
                    <div id="posEnterError" class="alert alert-danger d-none"></div>
                    <input type="hidden" id="posEnterShopId">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Password</label>
                        <input type="password" id="posEnterPassword" class="form-control" placeholder="Enter your password">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="posEnterConfirm">
                        <span id="posEnterSpinner" class="spinner-border spinner-border-sm d-none me-1"></span>
                        Enter POS
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    // Open modal when Go to POS clicked
    document.querySelectorAll('.go-to-pos').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('posEnterShopId').value = this.dataset.shopId;
            document.getElementById('posEnterPassword').value = '';
            document.getElementById('posEnterError').classList.add('d-none');
            new bootstrap.Modal(document.getElementById('posEnterModal')).show();
        });
    });

    // Confirm entry
    document.getElementById('posEnterConfirm').addEventListener('click', function () {
        const password = document.getElementById('posEnterPassword').value;
        const shopId = document.getElementById('posEnterShopId').value;
        const spinner = document.getElementById('posEnterSpinner');
        const errorDiv = document.getElementById('posEnterError');

        if (!password) { errorDiv.textContent = 'Please enter your password.'; errorDiv.classList.remove('d-none'); return; }

        spinner.classList.remove('d-none');
        this.disabled = true;

        fetch('{{ route("pos.verify") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ password, shop_id: shopId })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                errorDiv.textContent = data.message;
                errorDiv.classList.remove('d-none');
                spinner.classList.add('d-none');
                this.disabled = false;
            }
        });
    });

    // Auto-trigger if redirected back requiring auth
    @if(session('pos_require_auth'))
        document.getElementById('posEnterShopId').value = '{{ session("pos_require_auth") }}';
        new bootstrap.Modal(document.getElementById('posEnterModal')).show();
    @endif
    </script>
    @endpush
@endsection
