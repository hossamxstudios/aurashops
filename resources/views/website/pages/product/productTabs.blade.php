<!-- Product_Description_Accordion -->
        <section class="">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul class="accordion-product-wrap" id="accordion-product">
                            <li class="accordion-product-item">
                                <a href="#accordion-1" class="accordion-title collapsed current" data-bs-toggle="collapse" aria-expanded="true" aria-controls="accordion-1">
                                    <h6>Description</h6>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="accordion-1" class="collapse" data-bs-parent="#accordion-product">
                                    <div class="accordion-content tab-description">
                                        <div class="right">
                                            <div class="letter-1 text-btn-uppercase mb_12">{{ $product->name }}</div>
                                            <p class="mb_12 text-secondary">{{ $product->details ?? 'No description available for this product.' }}</p>
                                            @if($product->categories->count())
                                                <p class="text-secondary mb_12"><strong>Category:</strong> {{ $product->categories->pluck('name')->join(', ') }}</p>
                                            @endif
                                            @if($product->brand)
                                                <p class="text-secondary"><strong>Brand:</strong> {{ $product->brand->name }}</p>
                                            @endif
                                        </div>
                                        <div class="left">
                                            <div class="letter-1 text-btn-uppercase mb_12">PRODUCT INFORMATION</div>
                                            <ul class="gap-6 list-text type-disc mb_12">
                                                <li><strong>SKU:</strong> {{ $product->sku }}</li>
                                                @if($product->brand)
                                                    <li><strong>Brand:</strong> {{ $product->brand->name }}</li>
                                                @endif
                                                @if($product->gender)
                                                    <li><strong>Gender:</strong> {{ $product->gender->name }}</li>
                                                @endif
                                                <li><strong>Price:</strong> EGP {{ number_format($product->getDisplayPrice(), 2) }}</li>
                                                @if($product->sale_price > 0)
                                                    <li><strong>Original Price:</strong> EGP {{ number_format($product->price, 2) }}</li>
                                                    <li><strong>You Save:</strong> EGP {{ number_format($product->price - $product->sale_price, 2) }} ({{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%)</li>
                                                @endif
                                            </ul>


                                        </div>
                                    </div>
                                </div>
                            </li>

                            @include('website.pages.product.productReviews')

                            <li class="accordion-product-item" style="display: none;">
                                <a href="#accordion-2-old" class="accordion-title current" data-bs-toggle="collapse" aria-expanded="true" aria-controls="accordion-2-old">
                                    <h6>Customer Reviews OLD</h6>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="accordion-2" class="collapse show" data-bs-parent="#accordion-product">
                                    <div class="accordion-content tab-reviews write-cancel-review-wrap">
                                        <div class="tab-reviews-heading">
                                            <div class="top">
                                                <div class="text-center">
                                                    <div class="number title-display">{{ $product->reviewStats['average'] ?? 0 }}</div>
                                                    <div class="list-star">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="icon icon-star{{ $i <= ($product->reviewStats['average'] ?? 0) ? '' : '-o' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <p>({{ $product->reviewStats['total'] ?? 0 }} {{ $product->reviewStats['total'] == 1 ? 'Rating' : 'Ratings' }})</p>
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
                                                <div class="btn-style-4 text-btn-uppercase letter-1 btn-comment-review btn-cancel-review">Cancel Review</div>
                                                <div class="btn-style-4 text-btn-uppercase letter-1 btn-comment-review btn-write-review">Write a review</div>
                                            </div>
                                        </div>
                                        <div class="reply-comment style-1 cancel-review-wrap">
                                            <div class="flex-wrap gap-20 d-flex mb_24 align-items-center justify-content-between">
                                                <h4 class="">03 Comments</h4>
                                                <div class="gap-12 d-flex align-items-center">
                                                    <div class="text-caption-1">Sort by:</div>
                                                    <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                                                        <div class="btn-select">
                                                            <span class="text-sort-value">Most Recent</span>
                                                            <span class="icon icon-arrow-down"></span>
                                                        </div>
                                                        <div class="dropdown-menu">
                                                            <div class="select-item active">
                                                                <span class="text-value-item">Most Recent</span>
                                                            </div>
                                                            <div class="select-item">
                                                                <span class="text-value-item">Oldest</span>
                                                            </div>
                                                            <div class="select-item">
                                                                <span class="text-value-item">Most Popular</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="reply-comment-wrap">
                                                <div class="reply-comment-item">
                                                    <div class="user">
                                                        <div class="image">
                                                            <img src="images/avatar/user-default.jpg" alt="">
                                                        </div>
                                                        <div>
                                                            <h6>
                                                                <a href="#" class="link">Superb quality apparel that exceeds expectations</a>
                                                            </h6>
                                                            <div class="day text-secondary-2 text-caption-1">1 days ago  &nbsp;&nbsp;&nbsp;-</div>
                                                        </div>
                                                    </div>
                                                    <p class="text-secondary">Great theme - we were looking for a theme with lots of built in features and flexibility and this was perfect. We expected to need to employ a developer to add a few finishing touches. But we actually managed to do everything ourselves. We did have one small query and the support given was swift and helpful.</p>
                                                </div>
                                                <div class="reply-comment-item type-reply">
                                                    <div class="user">
                                                        <div class="image">
                                                            <img src="images/avatar/user-default.jpg" alt="">
                                                        </div>
                                                        <div>
                                                            <h6>
                                                                <a href="#" class="link">Reply from Modave</a>
                                                            </h6>
                                                            <div class="day text-secondary-2 text-caption-1">1 days ago  &nbsp;&nbsp;&nbsp;-</div>
                                                        </div>
                                                    </div>
                                                    <p class="text-secondary">We love to hear it! Part of what we love most about Modave is how much it empowers store owners like yourself to build a beautiful website without having to hire a developer :) Thank you for this fantastic review!</p>
                                                </div>
                                                <div class="reply-comment-item">
                                                    <div class="user">
                                                        <div class="image">
                                                            <img src="images/avatar/user-default.jpg" alt="">
                                                        </div>
                                                        <div>
                                                            <h6>
                                                                <a href="#" class="link">Superb quality apparel that exceeds expectations</a>
                                                            </h6>
                                                            <div class="day text-secondary-2 text-caption-1">1 days ago  &nbsp;&nbsp;&nbsp;-</div>
                                                        </div>
                                                    </div>
                                                    <p class="text-secondary">Great theme - we were looking for a theme with lots of built in features and flexibility and this was perfect. We expected to need to employ a developer to add a few finishing touches. But we actually managed to do everything ourselves. We did have one small query and the support given was swift and helpful.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <form class="form-write-review write-review-wrap">
                                            <div class="heading">
                                                <h4>Write a review:</h4>
                                                <div class="list-rating-check">
                                                    <input type="radio" id="star5" name="rate" value="5">
                                                    <label for="star5" title="text"></label>
                                                    <input type="radio" id="star4" name="rate" value="4">
                                                    <label for="star4" title="text"></label>
                                                    <input type="radio" id="star3" name="rate" value="3">
                                                    <label for="star3" title="text"></label>
                                                    <input type="radio" id="star2" name="rate" value="2">
                                                    <label for="star2" title="text"></label>
                                                    <input type="radio" id="star1" name="rate" value="1">
                                                    <label for="star1" title="text"></label>
                                                </div>
                                            </div>
                                            <div class="mb_32">
                                                <div class="mb_8">Review Title</div>
                                                <fieldset class="mb_20">
                                                    <input class="" type="text" placeholder="Give your review a title" name="text" tabindex="2" value="" aria-required="true" required="">
                                                </fieldset>
                                                <div class="mb_8">Review</div>
                                                <fieldset class="mb_20">
                                                    <textarea class="" rows="4" placeholder="Write your comment here" tabindex="2" aria-required="true" required=""></textarea>
                                                </fieldset>
                                                <div class="cols mb_20">
                                                    <fieldset class="">
                                                        <input class="" type="text" placeholder="You Name (Public)" name="text" tabindex="2" value="" aria-required="true" required="">
                                                    </fieldset>
                                                    <fieldset class="">
                                                        <input class="" type="email" placeholder="Your email (private)" name="email" tabindex="2" value="" aria-required="true" required="">
                                                    </fieldset>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <input type="radio" name="availability" class="tf-check" id="check1">
                                                    <label class="text-secondary" for="check1">Save my name, email, and website in this browser for the next time I comment.</label>
                                                </div>
                                            </div>
                                            <div class="button-submit">
                                                <button class="text-btn-uppercase" type="submit">Submit Reviews</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            <li class="accordion-product-item">
                                <a href="#accordion-3" class="accordion-title collapsed current" data-bs-toggle="collapse" aria-expanded="true" aria-controls="accordion-3">
                                    <h6>Shipping & Returns</h6>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="accordion-3" class="collapse" data-bs-parent="#accordion-product">
                                    <div class="accordion-content tab-shipping">
                                        <div class="w-100">
                                            <div class="text-btn-uppercase mb_12">We've got your back</div>
                                            <p class="mb_12">One delivery fee to most locations (check our Orders & Delivery page)</p>
                                            <p class="">Free returns within 14 days (excludes final sale and made-to-order items, face masks and certain products containing hazardous or flammable materials, such as fragrances and aerosols)</p>
                                        </div>
                                        <div class="w-100">
                                            <div class="text-btn-uppercase mb_12">Import duties information</div>
                                            <p>Let us handle the legwork. Delivery duties are included in the item price when shipping to all EU countries (excluding the Canary Islands), plus The United Kingdom, USA, Canada, China Mainland, Australia, New Zealand, Puerto Rico, Switzerland, Singapore, Republic Of Korea, Kuwait, Mexico, Qatar, India, Norway, Saudi Arabia, Taiwan Region, Thailand, U.A.E., Japan, Brazil, Isle of Man, San Marino, Colombia, Chile, Argentina, Egypt, Lebanon, Hong Kong SAR, Bahrain and Turkey. All import duties are included in your order – the price you see is the price you pay.</p>
                                        </div>
                                        <div class="w-100">
                                            <div class="text-btn-uppercase mb_12">Estimated delivery</div>
                                            <p class="mb_6 font-2">Express: May 10 - May 17</p>
                                            <p class="font-2">Sending from USA</p>
                                        </div>
                                        <div class="w-100">
                                            <div class="text-btn-uppercase mb_12">Need more information?</div>
                                            <div>
                                                <a href="#" class="link text-secondary text-decoration-underline mb_6 font-2">Orders & delivery</a>
                                            </div>
                                            <div>
                                                <a href="#" class="link text-secondary text-decoration-underline mb_6 font-2">Returns & refunds</a>
                                            </div>
                                            <div>
                                                <a href="#" class="link text-secondary text-decoration-underline font-2">Duties & taxes</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="accordion-product-item">
                                <a href="#accordion-4" class="accordion-title collapsed current" data-bs-toggle="collapse" aria-expanded="true" aria-controls="accordion-4">
                                    <h6>Return Policies</h6>
                                    <span class="btn-open-sub"></span>
                                </a>
                                <div id="accordion-4" class="collapse" data-bs-parent="#accordion-product">
                                    <div class="accordion-content tab-policies">
                                        <div class="text-btn-uppercase mb_12">Return Policies</div>
                                        <p class="mb_12 text-secondary">At Modave, we stand behind the quality of our products. If you're not completely satisfied with your purchase, we offer hassle-free returns within 30 days of delivery.</p>
                                        <div class="text-btn-uppercase mb_12">Easy Exchanges or Refunds</div>
                                        <ul class="gap-6 list-text type-disc mb_12">
                                            <li class="text-secondary">Exchange your item for a different size, color, or style, or receive a full refund.</li>
                                            <li class="text-secondary">All returned items must be unworn, in their original packaging, and with tags attached.</li>
                                        </ul>
                                        <div class="text-btn-uppercase mb_12">Simple Process</div>
                                        <ul class="gap-6 list-text type-number mb_12">
                                            <li class="text-secondary">Initiate your return online or contact our customer service team for assistance.</li>
                                            <li class="text-secondary">Pack your item securely and include the original packing slip.</li>
                                            <li class="text-secondary">Ship your return back to us using our prepaid shipping label.</li>
                                            <li class="text-secondary">Once received, your refund will be processed promptly.</li>
                                        </ul>
                                        <p class="text-secondary">For any questions or concerns regarding returns, don't hesitate to reach out to our dedicated customer service team. Your satisfaction is our priority.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Product_Description_Accordion -->
