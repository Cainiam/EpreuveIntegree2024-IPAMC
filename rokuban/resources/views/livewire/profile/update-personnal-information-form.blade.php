<!-- Created by Boisdenghien Jordan -->
<!-- Allow user to update (or add, since they're not required to create an account) their personnal information -->

<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $address_line_1 = '';
    public string $address_line_2 = '';
    public string $postal_code = '';
    public string $city = '';

    public function mount(): void
    {
        //We check if the personnal are not NULL, in case of NULL we assign '' to allow new users to register their personnal informations  
        $this->first_name = (Auth::user()->first_name ?? '');
        $this->last_name = (Auth::user()->last_name ?? '');
        $this->address_line_1 = (Auth::user()->address_line_1 ?? '');
        $this->address_line_2 = (Auth::user()->address_line_2 ?? '');
        $this->postal_code = (Auth::user()->postal_code ?? '');
        $this->city = (Auth::user()->city ?? '');
    }

    public function updatePersonnalInformation(): void
    {
        $user = Auth::user();

        $pattern = '/^[0-9]+$/';

        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:255', 'min:2'], //at leat 2 characters for the first name
            'last_name' => ['required', 'string', 'max:255', 'min:2'], //at leat 2 characters for the name
            'address_line_1' => ['required', 'string', 'max:255', 'min:2'], //address line at least 2 characters
            'address_line_2' => ['nullable', 'string', 'max:255'], //line 2 is not required
            'postal_code' => ['required', 'integer', 'max:9992', 'min:1000'], //Bruxelles = 1000, Middelburg = 9992, we accepted all number between
            'city' => ['required', 'string', 'max:255', 'min:2'], //at least 2 character for city
        ]);

        $user->fill($validated);

        $user->save();

        $this->dispatch('profile-updated');
    }

    //Personalised message for error on validate
    protected $messages = 
    [
        'first_name.required' => 'Le prénom est requis.',
        'first_name.min' => 'Le prénom doit faire au moins 2 caractères.',
        'first_name.max' => 'Le prénom doit faire au maximum 255 caractères.',
        'last_name.required' => 'Le nom est requis.',
        'last_name.min' => 'Le nom doit faire au moins 2 caractères.',
        'last_name.max' => 'Le nom doit faire au maximum 255 caractères.',
        'address_line_1.required' => 'L\'addresse est requise.',
        'address_line_1.min' => 'L\'addresse doit faire au moins 2 caractères.',
        'address_line_1.max' => 'L\'addresse doit faire au maximum 255 caractères.',
        'address_line_2.max' => 'L\'addresse doit faire au maximum 255 caractères.',
        'postal_code.required' => 'Le code postal est requis.',
        'postal_code.integer' => 'Le code postal doit être écrit en chiffre entier.',
        'postal_code.min' => 'Le code postal ne peut être inférieur à 1000.',
        'postal_code.max' => 'Le code postal ne peut être supérieur à 9992.',
        'city.required' => 'Le nom de ville est requis.',
        'city.min' => 'Le nom de ville doit faire au moins 2 caractères.',
        'city.max' => 'Le nom de ville doit faire au maximum 255 caractères.',
    ];
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informations personnelles') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Ajouter votre nom et prénom ainsi que votre addresse pour les livraisons.") }}
        </p>
    </header>
    
    <form wire:submit="updatePersonnalInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="first_name" :value="__('Prénom')" />
            <x-text-input wire:model="first_name" id="first_name" name="first_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="first_name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>
        <div>
            <x-input-label for="last_name" :value="__('Nom de famille')" />
            <x-text-input wire:model="last_name" id="last_name" name="last_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="last_name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>
        <div>
            <x-input-label for="address_line_1" :value="__('Addresse et numéro')" />
            <x-text-input wire:model="address_line_1" id="address_line_1" name="address_line_1" type="text" class="mt-1 block w-full" required autofocus autocomplete="address_line_1" />
            <x-input-error class="mt-2" :messages="$errors->get('address_line_1')" />
        </div>
        <div>
            <x-input-label for="address_line_2" :value="__('Complément d\'adresse')" />
            <x-text-input wire:model="address_line_2" id="address_line_2" name="address_line_2" type="text" class="mt-1 block w-full" autofocus autocomplete="address_line_2" />
            <x-input-error class="mt-2" :messages="$errors->get('address_line_2')" />
        </div>
        <div>
            <x-input-label for="postal_code" :value="__('Code postal')" />
            <x-text-input wire:model="postal_code" id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" required autofocus autocomplete="postal_code" />
            <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
        </div>
        <div>
            <x-input-label for="city" :value="__('Ville')" />
            <x-text-input wire:model="city" id="city" name="city" type="text" class="mt-1 block w-full" required autofocus autocomplete="city" />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>
            <x-action-message class="me-3" on="profile-updated">
                {{ __('Enregistré.') }}
            </x-action-message>
        </div>
    </form>
</section>

