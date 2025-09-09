@extends('layouts.app')

@section('content')
<div class="login-wrapper d-flex align-items-center justify-content-center min-vh-100">
    <!-- Overlay -->
    <div class="bg-overlay"></div>

    <div class="col-md-4 position-relative">
        <div class="card border-0 shadow-lg rounded-5 hover-lift animate__animated animate__fadeInUp" 
             style="border-radius: 1.5rem; backdrop-filter: blur(10px); background: rgba(255,255,255,0.9);">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-2" style="color:#EA5B6F;">{{ __('Welcome Back 👋') }}</h3>
                    <p class="text-muted small">Sign in to continue</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text" 
                                  style="background:#f8f9fa; border:1px solid #ddd; border-top-left-radius:1rem; border-bottom-left-radius:1rem;">
                                <i class="fas fa-user" style="color:#EA5B6F;"></i>
                            </span>
                            <input id="nik" type="text" 
                                   class="form-control form-control-lg shadow-sm @error('nik') is-invalid @enderror" 
                                   style="border-top-right-radius: 1rem; border-bottom-right-radius: 1rem; font-size:14px;"
                                   name="nik" value="{{ old('nik') }}" placeholder="Enter NIK" required autofocus>
                        </div>
                        @error('nik')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text" 
                                  style="background:#f8f9fa; border:1px solid #ddd; border-top-left-radius:1rem; border-bottom-left-radius:1rem;">
                                <i class="fas fa-lock" style="color:#EA5B6F;"></i>
                            </span>
                            <input id="password" type="password" 
                                   class="form-control form-control-lg shadow-sm @error('password') is-invalid @enderror" 
                                   style="border-right:0; font-size:14px;"
                                   name="password" placeholder="Enter Password" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="showPass()"
                                    style="border-top-right-radius: 1rem; border-bottom-right-radius: 1rem;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a class="small text-decoration-none" href="{{ route('password.request') }}" style="color:#EA5B6F;">
                            {{ __('Forgot Password?') }}
                        </a>
                        <a href="{{ asset('DokumentasiAlurSistemUser.pdf') }}" 
                           target="_blank" class="btn btn-sm shadow-sm hover-lift"
                           style="border:1px solid #5EABD6; color:#5EABD6; border-radius: 1rem;">
                           <i class="fas fa-book me-1"></i> Manual
                        </a>
                    </div>

                    <button type="submit" class="btn w-100 fw-semibold shadow-sm hover-lift"
                            style="background:#EA5B6F; color:#fff; border-radius: 1rem;">
                        {{ __('Login') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showPass() {
    let pass = document.getElementById("password");
    pass.type = (pass.type === "password") ? "text" : "password";
}
</script>

<style>
body {
    font-family: 'Poppins', sans-serif;
}

/* Background image dengan overlay */
.login-wrapper {
    position: relative;
    background: url('{{ asset('images/bg-login.jpg') }}') no-repeat center center;
    background-size: cover;
}
.bg-overlay {
    position: absolute;
    inset: 0;
    background: rgba(33,53,85,0.7); /* overlay transparan */
    z-index: 1;
}
.login-wrapper .col-md-4 {
    z-index: 2; /* biar card di atas overlay */
}

/* Hover animasi */
.hover-lift {
    transition: all 0.3s ease-in-out;
}
.hover-lift:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.25);
}

.card {
    transition: all 0.4s ease;
}
.card:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow: 0 14px 35px rgba(0,0,0,0.3);
}
</style>
@endsection
