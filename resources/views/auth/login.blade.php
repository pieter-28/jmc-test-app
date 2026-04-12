@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">{{ __('Login') }}</h4>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Credential Input -->
                            <div class="mb-3">
                                <label for="credential"
                                    class="form-label">{{ __('Username / Email / Nomor Telepon') }}</label>
                                <input type="text" class="form-control @error('credential') is-invalid @enderror"
                                    id="credential" name="credential" value="{{ old('credential') }}"
                                    placeholder="Masukkan username, email, atau nomor telepon" required autofocus>
                                @error('credential')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- CAPTCHA -->
                            <div class="mb-3">
                                <label for="captcha" class="form-label">{{ __('CAPTCHA') }}</label>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div id="captcha-image" class="border p-2 bg-light text-center"
                                            style="min-height: 50px;">
                                            <img id="captcha-img" src="" alt="CAPTCHA" style="max-width: 100%;">
                                        </div>
                                        <button type="button" class="btn btn-sm btn-secondary w-100 mt-2"
                                            id="refresh-captcha" onclick="generateCaptcha()">
                                            {{ __('Refresh') }}
                                        </button>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control @error('captcha') is-invalid @enderror"
                                            id="captcha" name="captcha" placeholder="Masukkan kode CAPTCHA" required
                                            maxlength="6">
                                        @error('captcha')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me"
                                    value="1">
                                <label class="form-check-label" for="remember_me">
                                    {{ __('Ingat Saya') }}
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100">{{ __('Login') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateCaptcha() {
            fetch('{{ route('captcha.generate') }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('captcha-img').src = data.captcha_image;
                    document.getElementById('captcha').value = '';
                })
                .catch(error => console.error('Error:', error));
        }

        // Generate CAPTCHA on page load
        document.addEventListener('DOMContentLoaded', function() {
            generateCaptcha();
        });
    </script>
@endsection
