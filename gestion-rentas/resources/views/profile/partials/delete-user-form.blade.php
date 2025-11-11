<section class="space-y-6">
    <header class="mb-4">
        <h2 class="h5 text-dark mb-1">
            {{ __('Eliminar Cuenta') }}
        </h2>

        <p class="text-muted mb-0">
            {{ __('Una ves que se elimine la cuenta, toda la información será eliminada permanentemente') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Eliminar Cuenta') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable >
        <form method="post" action="{{ route('profile.destroy') }}" class="mt-3 p-6">
            @csrf
            @method('delete')

            <h2 class="h5 text-dark mb-1">
                {{ __('¿Está seguro de querer eliminar su cuenta?') }}
            </h2>

            <p class="text-muted mb-0">
                {{ __('Una ves que se elimine la cuenta, toda la información se eliminará permanentemente') }}
            </p>

            <div class="mt-3">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only form-label" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Escribe tu Contraseña') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Eliminar Cuenta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
