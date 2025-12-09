{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="text-indigo-600 rounded border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex justify-end items-center mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
<!DOCTYPE html>
@include('admin.main.html')

<head>
    @include('admin.main.meta')
</head>

<body>
    <div class="wrapper">
        <div class="overflow-hidden auth-box align-items-center d-flex">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-md-6 col-sm-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4 auth-brand">
                                    <a href="{{ route('login') }}" class="logo-dark">
                                        <span class="gap-1 d-flex align-items-center">
                                            <img src="{{ asset('admin/assets/images/logo-sm.png') }}" height="40" alt="Logo">
                                            <span class="logo-text text-body fw-bold fs-xxl">Aura</span>
                                        </span>
                                    </a>
                                    <a href="{{ route('login') }}" class="logo-light">
                                        <span class="gap-1 d-flex align-items-center">
                                            <span class="avatar avatar-xs rounded-circle text-bg-dark">
                                                <span class="avatar-title">
                                                    <i data-lucide="sparkles" class="fs-md"></i>
                                                </span>
                                            </span>
                                            <span class="text-white logo-text fw-bold fs-xl">Aura</span>
                                        </span>
                                    </a>
                                    <p class="mt-3 text-muted w-lg-75">Let’s get you signed in. Enter your email and password to continue.</p>
                                </div>

                                <div class="">
                                    <form action="{{ route('login') }}" method="POST">
                                        @method('POST')
                                        @csrf
                                        <div class="mb-3">
                                            <label for="Email" class="form-label" type="email" name="email" :value="old('email')" required autofocus autocomplete="username">Email address <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="email" class="mt-2 form-control" id="Email" name="email"  placeholder="you@example.com" required :messages="$errors->get('email')"  >
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="Password" class="form-label" :value="__('Password')" type="password" name="password" required autocomplete="current-password">Password <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="userPassword" name="password" placeholder="••••••••" required>
                                            </div>
                                        </div>

                                        <div class="mb-3 d-flex justify-content-between align-items-center">
                                            <a href="{{ route('password.request') }}"
                                                class="text-decoration-underline link-offset-3 text-muted">Forgot
                                                Password?</a>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="py-2 btn btn-primary fw-semibold">Sign In</button>
                                        </div>
                                    </form>

                                    <p class="mt-4 mb-0 text-center text-muted">
                                        New here? <a href="{{ route('register') }}"
                                            class="text-decoration-underline link-offset-3 fw-semibold">Create an
                                            account</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4 mb-0 text-center text-muted">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Aura — by <span class="fw-semibold">HossamXstudios</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
</body>

</html>
