       <!-- Get In Touch -->
        <section class="pt-0 flat-spacing">
            <div class="container">
                <div class="text-center heading-section">
                    <h3 class="heading">Get In Touch</h3>
                    <p class="subheading">Use the form below to get in touch with the sales team</p>
                </div>
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Error Messages --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Please fix the following issues:
                        <ul class="mt-2 mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form id="contactform" action="{{ route('contact.store') }}" method="post" class="form-leave-comment">
                    @csrf
                    <div class="wrap">
                        <div class="cols">
                            <fieldset class="">
                                <input class="" type="text" placeholder="Your Name*" name="name" id="name" tabindex="2" value="{{ old('name') }}" aria-required="true" required="">
                            </fieldset>
                            <fieldset class="">
                                <input class="" type="email" placeholder="Your Email*" name="email" id="email" tabindex="2" value="{{ old('email') }}" aria-required="true" required="">
                            </fieldset>
                            <fieldset class="">
                                <input class="" type="text" placeholder="Your Phone*" name="phone" id="phone" tabindex="2" value="{{ old('phone') }}" aria-required="true" required="">
                            </fieldset>
                        </div>
                        <fieldset class="">
                            <textarea name="message" id="message" rows="4" placeholder="Your Message*" tabindex="2" aria-required="true" required="">{{ old('message') }}</textarea>
                        </fieldset>
                    </div>
                    <div class="button-submit send-wrap">
                        <button class="tf-btn btn-fill" type="submit">
                            <span class="text text-button">Send message</span>
                        </button>
                    </div>
                </form>
            </div>
        </section>
        <!-- /Get In Touch -->
