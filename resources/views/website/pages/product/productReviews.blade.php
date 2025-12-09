<li class="accordion-product-item">
    <a href="#accordion-reviews" class="accordion-title current" data-bs-toggle="collapse" aria-expanded="true" aria-controls="accordion-reviews">
        <h6>Customer Reviews</h6>
        <span class="btn-open-sub"></span>
    </a>
    <div id="accordion-reviews" class="collapse show" data-bs-parent="#accordion-product">
        <div class="accordion-content tab-reviews write-cancel-review-wrap">
            <!-- Reviews Heading with Stats -->
            <div class="tab-reviews-heading">
                <div class="top">
                    <div class="text-center">
                        <div class="number title-display">{{ $product->reviewStats['average'] ?? 0 }}</div>
                        <div class="list-star">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="icon icon-star{{ $i <= ($product->reviewStats['average'] ?? 0) ? '' : '-o' }}"></i>
                            @endfor
                        </div>
                        <p>({{ $product->reviewStats['total'] ?? 0 }} {{ ($product->reviewStats['total'] ?? 0) == 1 ? 'Rating' : 'Ratings' }})</p>
                    </div>
                    <div class="rating-score">
                        @foreach($product->reviewStats['distribution'] ?? [] as $rating => $data)
                        <div class="item">
                            <div class="number-1 text-caption-1">{{ $rating }}</div>
                            <i class="icon icon-star"></i>
                            <div class="line-bg">
                                <div style="width: {{ $data['percentage'] }}%;"></div>
                            </div>
                            <div class="number-2 text-caption-1">{{ $data['count'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <div class="btn-style-4 text-btn-uppercase letter-1 btn-comment-review btn-write-review">Write a review</div>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="reply-comment style-1">
                <h4 class="mb_24">{{ $product->reviews->count() }} {{ $product->reviews->count() == 1 ? 'Review' : 'Reviews' }}</h4>

                @if($product->reviews->count() > 0)
                    <div class="reply-comment-wrap" id="reviews-list">
                        @foreach($product->reviews as $review)
                        <div class="reply-comment-item">
                            <div class="user">
                                <div class="image">
                                    <img src="{{ asset('website/images/avatar/user-default.jpg') }}" alt="{{ $review->client?->name ?? 'Anonymous' }}">
                                </div>
                                <div>
                                    <h6>{{ $review->client?->name ?? 'Anonymous' }}</h6>
                                    <div class="mb-2 list-star">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="icon icon-star{{ $i <= $review->rating ? '' : '-o' }}" style="font-size: 12px;"></i>
                                        @endfor
                                    </div>
                                    <div class="day text-secondary-2 text-caption-1">{{ $review->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <p class="text-secondary">{{ $review->comment }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-5 text-center">
                        <p class="text-secondary">No reviews yet. Be the first to review this product!</p>
                    </div>
                @endif
            </div>

            <!-- Write Review Form -->
            <form class="form-write-review write-review-wrap" id="reviewForm" style="display: none;">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="heading">
                    <h4>Write a review:</h4>
                    <div class="list-rating-check">
                        <input type="radio" id="star5-{{ $product->id }}" name="rating" value="5" required>
                        <label for="star5-{{ $product->id }}" title="5 stars"></label>
                        <input type="radio" id="star4-{{ $product->id }}" name="rating" value="4">
                        <label for="star4-{{ $product->id }}" title="4 stars"></label>
                        <input type="radio" id="star3-{{ $product->id }}" name="rating" value="3">
                        <label for="star3-{{ $product->id }}" title="3 stars"></label>
                        <input type="radio" id="star2-{{ $product->id }}" name="rating" value="2">
                        <label for="star2-{{ $product->id }}" title="2 stars"></label>
                        <input type="radio" id="star1-{{ $product->id }}" name="rating" value="1">
                        <label for="star1-{{ $product->id }}" title="1 star"></label>
                    </div>
                </div>
                <div class="mb_32">
                    <div class="mb_8">Your Review *</div>
                    <fieldset class="mb_20">
                        <textarea name="comment" rows="4" placeholder="Write your review here (minimum 10 characters)" tabindex="2" aria-required="true" required minlength="10"></textarea>
                    </fieldset>
                    @guest('client')
                        <p class="mb-3 text-secondary text-caption-1">
                            <i class="icon-info-circle"></i> You are posting as Anonymous.
                            <a href="{{ route('client.login') }}" class="link">Login</a> to post with your name.
                        </p>
                    @else
                        <p class="mb-3 text-secondary text-caption-1">
                            Posting as: <strong>{{ Auth::guard('client')->user()->full_name }}</strong>
                        </p>
                    @endguest
                </div>
                <div class="gap-3 button-submit d-flex">
                    <button class="btn-style-4 text-btn-uppercase" type="submit">Submit Review</button>
                    <button class="btn-style-4 text-btn-uppercase btn-cancel-review-form" type="button">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</li>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reviewForm = document.getElementById('reviewForm');
    const writeReviewBtn = document.querySelector('.btn-write-review');
    const cancelReviewBtn = document.querySelector('.btn-cancel-review-form');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Show/Hide review form
    if (writeReviewBtn) {
        writeReviewBtn.addEventListener('click', function() {
            reviewForm.style.display = 'block';
            reviewForm.scrollIntoView({ behavior: 'smooth' });
        });
    }

    if (cancelReviewBtn) {
        cancelReviewBtn.addEventListener('click', function() {
            reviewForm.style.display = 'none';
            reviewForm.reset();
        });
    }

    // Submit review
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(reviewForm);
            const submitBtn = reviewForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            // Disable button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';

            fetch('{{ route("reviews.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                        window.ShopFeatures.showNotification(data.message, 'success');
                    } else {
                        alert(data.message);
                    }

                    // Reset and hide form
                    reviewForm.reset();
                    reviewForm.style.display = 'none';

                    // Reload page to show new review
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    // Show error
                    if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                        window.ShopFeatures.showNotification(data.message || 'Failed to submit review', 'error');
                    } else {
                        alert(data.message || 'Failed to submit review');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                    window.ShopFeatures.showNotification('An error occurred. Please try again.', 'error');
                } else {
                    alert('An error occurred. Please try again.');
                }
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }
});
</script>
