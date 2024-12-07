<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('home', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Merci de vous êtes enregistré! Avant de commencer, pouvez-vous cliquer sur le lien que nous venons de vous envoyer par mail ? Si vous ne le recevez pas, nous pouvons vous en envoyer un nouveau.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Un nouveau lien de vérification a été envoyé à votre mail indiqué à l\'inscription.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <x-primary-button wire:click="sendVerification">
            {{ __('Renvoyer le mail de vérification') }}
        </x-primary-button>

        <button wire:click="logout" type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Déconnexion') }}
        </button>
    </div>
</div>
