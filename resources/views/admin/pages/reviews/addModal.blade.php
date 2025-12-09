<div class="modal fade" id="addReviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.reviews.store') }}" method="POST">
                @csrf
                @if(isset($product))
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                @endif
                <div class="modal-header">
                    <h5 class="modal-title">Add Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if(isset($client))
                        <div class="mb-3">
                            <label class="form-label">Product <span class="text-danger">*</span></label>
                            <select class="form-select" name="product_id" required>
                                <option value="">Select product...</option>
                                @foreach(\App\Models\Product::orderBy('name')->get() as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                    @else
                        <div class="mb-3">
                            <label class="form-label">Client <small class="text-muted">(optional)</small></label>
                            <select class="form-select" name="client_id">
                                <option value="">Anonymous Review</option>
                                @foreach(\App\Models\Client::orderBy('email')->get() as $c)
                                    <option value="{{ $c->id }}">{{ $c->full_name }} - {{ $c->email }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Rating <span class="text-danger">*</span></label>
                        <select class="form-select" name="rating" required>
                            <option value="">Select rating...</option>
                            <option value="5">★★★★★ (5 stars)</option>
                            <option value="4">★★★★☆ (4 stars)</option>
                            <option value="3">★★★☆☆ (3 stars)</option>
                            <option value="2">★★☆☆☆ (2 stars)</option>
                            <option value="1">★☆☆☆☆ (1 star)</option>
                        </select>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Comment</label>
                        <textarea class="form-control" name="comment" rows="4" placeholder="Write your review..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
