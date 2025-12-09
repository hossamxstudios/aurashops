{{-- Reviews Section - to be included in product/client pages --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i data-lucide="star" class="icon-sm me-1"></i>
            Reviews
            @if(isset($product))
                <span class="badge bg-secondary">{{ $product->reviews->count() }}</span>
            @elseif(isset($client))
                <span class="badge bg-secondary">{{ $client->reviews->count() }}</span>
            @endif
        </h5>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addReviewModal">
            <i data-lucide="plus" class="icon-sm me-1"></i> Add Review
        </button>
    </div>
    <div class="card-body">
        @php
            $reviews = isset($product) ? $product->reviews : (isset($client) ? $client->reviews : collect());
        @endphp

        @forelse($reviews as $review)
            <div class="border-bottom pb-3 mb-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="mb-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i data-lucide="star" class="icon-sm text-warning"></i>
                                @else
                                    <i data-lucide="star" class="icon-sm text-muted"></i>
                                @endif
                            @endfor
                            <span class="ms-2 fw-bold">{{ $review->rating }}/5</span>
                        </div>
                        @if($review->client)
                            <small class="text-muted">
                                <i data-lucide="user" class="icon-xs me-1"></i>
                                {{ $review->client->full_name }}
                            </small>
                        @endif
                        @if(isset($client) && $review->product)
                            <small class="text-muted ms-2">
                                <i data-lucide="package" class="icon-xs me-1"></i>
                                {{ $review->product->name }}
                            </small>
                        @endif
                        <br>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" onclick="editReview({{ $review->id }})" title="Edit">
                            <i data-lucide="edit" class="icon-xs"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteReview({{ $review->id }})" title="Delete">
                            <i data-lucide="trash-2" class="icon-xs"></i>
                        </button>
                    </div>
                </div>
                @if($review->comment)
                    <p class="mt-2 mb-0">{{ $review->comment }}</p>
                @endif
            </div>
        @empty
            <div class="text-center text-muted py-4">
                <i data-lucide="star-off" class="icon-lg mb-2" style="opacity: 0.3;"></i>
                <p class="mb-0">No reviews yet</p>
            </div>
        @endforelse
    </div>
</div>

@include('admin.pages.reviews.addModal')
@include('admin.pages.reviews.editModal')
@include('admin.pages.reviews.deleteModal')

<script>
    function editReview(id) {
        fetch(`/admin/reviews/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editReviewForm').action = `/admin/reviews/${id}`;
                document.getElementById('edit_review_rating').value = data.rating;
                document.getElementById('edit_review_comment').value = data.comment || '';
                
                new bootstrap.Modal(document.getElementById('editReviewModal')).show();
            });
    }

    function deleteReview(id) {
        document.getElementById('deleteReviewForm').action = `/admin/reviews/${id}`;
        new bootstrap.Modal(document.getElementById('deleteReviewModal')).show();
    }

    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
