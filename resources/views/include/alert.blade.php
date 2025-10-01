@if(session('success'))
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert"
     style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 0.5rem 1rem; border-radius: 0.375rem;">
    <div class="flex-grow-1" style="line-height: 1.5;">
        {{ session('success') }}
    </div>
    <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"
            style="padding: 0.85rem 1rem;"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert"
     style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 0.5rem 1rem; border-radius: 0.375rem;">
    <div class="flex-grow-1" style="line-height: 1.5;">
        {{ session('error') }}
    </div>
    <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"
            style="padding: 0.85rem 1rem;"></button>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert"
     style="background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; padding: 0.5rem 1rem; border-radius: 0.375rem;">
    <div class="flex-grow-1" style="line-height: 1.5;">
        {{ session('warning') }}
    </div>
    <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"
            style="padding: 0.85rem 1rem;"></button>
</div>
@endif

@if(session('info'))
<div class="alert alert-info alert-dismissible fade show d-flex align-items-center" role="alert"
     style="background-color: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; padding: 0.5rem 1rem; border-radius: 0.375rem;">
    <div class="flex-grow-1" style="line-height: 1.5;">
        {{ session('info') }}
    </div>
    <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"
            style="padding: 0.85rem 1rem;"></button>
</div>
@endif
