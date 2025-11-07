<section>
    <header class="mb-4">
        <h2 class="h5 text-dark mb-1">
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p class="text-muted mb-0">
            {{ __('Asegurate de usar una contraseña larga, usa una aleatoria para estar seguro') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-3">
        @csrf
        @method('put')

        <div class="mb-3">
            <x-input-label class="form-label" for="update_password_current_password" :value="__('Contraseña Actual')" />
            <x-text-input class="form-control" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="invalid-feedback d-block" />
        </div>

        <div class="mb-3">
            <x-input-label class="form-label" for="update_password_password" :value="__('Nueva Contraseña')" />
            <x-text-input class="form-control" id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="invalid-feedback d-block" />
        </div>

        <div class="mb-3">
            <x-input-label class="form-label" for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input class="form-control" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="invalid-feedback d-block" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-success mb-0"
                >{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>
