<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">Modification d'utilisateur</h1>

    @if(session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounder mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="updateUser" class="bg-blue-50 border border-gray-300 rounded-lg px-2 py-2">
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Pseudo</label>
            <input type="text" id="name" wire:model.defer="name" class="w-full mt-2 p-2 border rounder">
            @error('name') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Adresse mail</label>
            <input type="text" id="email" wire:model.defer="email" class="w-full mt-2 p-2 border rounder">
            @error('email') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="first_name" class="block text-gray-700">Prénom</label>
            <input type="text" id="first_name" wire:model.defer="first_name" class="w-full mt-2 p-2 border rounder">
            @error('first_name') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="last_name" class="block text-gray-700">Nom de famille</label>
            <input type="text" id="last_name" wire:model.defer="last_name" class="w-full mt-2 p-2 border rounder">
            @error('last_name') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="address_line_1" class="block text-gray-700">Adresse ligne 1</label>
            <input type="text" id="address_line_1" wire:model.defer="address_line_1" class="w-full mt-2 p-2 border rounder">
            @error('address_line_1') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="address_line_2" class="block text-gray-700">Adresse ligne 2</label>
            <input type="text" id="address_line_2" wire:model.defer="address_line_2" class="w-full mt-2 p-2 border rounder">
            @error('address_line_2') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="postal_code" class="block text-gray-700">Code postal</label>
            <input type="text" id="postal_code" wire:model.defer="postal_code" class="w-full mt-2 p-2 border rounder">
            @error('postal_code') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="city" class="block text-gray-700">Ville</label>
            <input type="text" id="city" wire:model.defer="city" class="w-full mt-2 p-2 border rounder">
            @error('city') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="px-2 py-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded-lg">Mettre à jour</button>
            <a href={{ route('gerantdashboard') }} class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded-lg">Annuler</a>
        </div>
    </form>
</div>
