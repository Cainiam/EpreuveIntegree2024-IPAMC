<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ],
        [
            'password.required' => 'Le mot de passe est requis !',
            'password.current_password' => 'Le mot de passe est incorrect !',
        ]);

        //Modifying to only make user inactive
        Auth::user()->update([
            'isActive' => 0,
        ]);
        tap(Auth::user(), $logout(...));

        //tap(Auth::user(), $logout(...))->delete(); //to make it delete again, uncomment here

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Suppression de compte') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Une fois la suppression demandée, votre compte sera désactivé pendant une certaine durée. Vous ne pourrez donc plus y accéder, à moins de faire une demande par mail à une administrateur. Une fois que vos données ne seront plus nécessaires pour notre comptabilité, le compte sera définitivement supprimé. Veuillez alors enregistrer toutes les informations que vous jugez nécessaires avant de faire la demande.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Suppression de compte') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Êtes-vous sur de vouloir supprimer votre compte?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Une fois votre compte désactivé, vous ne pourrez plus l\'utiliser. Entrez votre mot de passe pour supprimer définitivement votre compte.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Mot de passe') }}" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Mot de passe') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annuler') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Supprimer le compte') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
