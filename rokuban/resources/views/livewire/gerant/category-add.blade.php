<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">Ajout de catégorie</h2>

    @if(session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounder mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="addCategory" class="bg-blue-50 border border-gray-300 rounded-lg px-2 py-2">
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nom</label>
            <input type="text" id="name" wire:model.defer="name" class="w-full mt-2 p-2 border rounder">
            @error('name') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <input type="text" id="description" wire:model.defer="description" class="w-full mt-2 p-2 border rounder">
            @error('description') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="px-2 py-2">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-2 py-2 rounded-lg">Ajouter l'échelle</button>
            <a href={{ route('gerantdashboard') }} class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded-lg">Annuler l'ajout</a>
        </div>
    </form>
</div>
