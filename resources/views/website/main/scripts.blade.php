    <script type="text/javascript" src="{{ asset('website/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript" src="{{ asset('website/js/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/lazysize.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/count-down.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/multiple-modal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/shop-features.js') }}"></script>
    <script type="module" src="{{ asset('website/js/model-viewer.min.js') }}"></script>
    <script type="module" src="{{ asset('website/js/zoom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/multiple-modal.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('website/js/nouislider.min.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('website/js/shop.js') }}"></script>
    <script src="{{ asset('website/js/sibforms.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('website/js/wishlist.js') }}"></script>

    <style>
        /* Toastr minimal custom styles */
        #toast-container {
            z-index: 99999;
        }
        #toast-container > div {
            opacity: 0.95;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 8px;
            margin-bottom: 10px;
            width: 300px;
        }
        #toast-container.toast-top-right > div {
            margin-top: 10px;
        }
        #toast-container .toast-success {
            background-color: #28a745;
        }
        #toast-container .toast-error {
            background-color: #dc3545;
        }
        #toast-container .toast-info {
            background-color: #17a2b8;
        }
        .toast-message {
            font-size: 14px;
            font-weight: 500;
        }
        /* Animation for stacked notifications */
        #toast-container > div:not(:first-child) {
            animation: slideInFromRight 0.3s ease-out;
        }
        @keyframes slideInFromRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 0.95;
            }
        }
        /* Wishlist button styles */
        .btn-add-to-wishlist.loading {
            opacity: 0.6;
            pointer-events: none;
        }
        .btn-add-to-wishlist[data-in-wishlist="true"] .icon-heart {
            color: #dc3545;
        }
        .btn-add-to-wishlist .icon-heart,
        .btn-add-to-wishlist .icon-heart-fill {
            transition: all 0.3s ease;
        }
        .btn-add-to-wishlist:hover .icon-heart,
        .btn-add-to-wishlist:hover .icon-heart-fill {
            transform: scale(1.1);
        }
    </style>
