<x-guest-layout>
    <div class="text-center mb-4">
        <i class="fas fa-sign-in-alt fa-2x text-primary mb-3"></i>
        <h2 class="fw-bold">Iniciar Sesión</h2>
        <p class="text-muted">Accede a tu cuenta de administración</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                   name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                   name="password" required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">Recordar sesión</label>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
            </button>
        </div>

        <div class="text-center mt-3">
            @if (Route::has('password.request'))
                <a class="text-decoration-none" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>
    </form>

    
</x-guest-layout>