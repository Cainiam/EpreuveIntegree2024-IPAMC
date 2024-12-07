<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">Ajout de moyen de livraison</h2>

    @if(session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounder mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="addShipping" class="bg-blue-50 border border-gray-300 rounded-lg px-2 py-2">
        <div class="mb-4">
            <label for="shippingcompany_id" class="block text-gray-700">Compagnie de transport :</label>
            <select id="shippingcompany_id" wire:model="shippingcompany_id" class="border rounded mt-2 p-2 w-full">
                <option value="">--- Choissisez la compagnie ---</option>
                @foreach($shippingcompanies as $shippingcompany)
                    <option value="{{ $shippingcompany->id }}">{{ $shippingcompany->name }}</option>
                @endforeach
            </select>
            @error('shippingcompany_id') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nom</label>
            <input type="text" id="name" wire:model.defer="name" class="w-full mt-2 p-2 border rounder">
            @error('name') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700">Prix</label>
            <input type="number" step="0.01" id="price" wire:model.defer="price" class="w-full mt-2 p-2 border rounder">
            @error('price') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <input type="text" id="description" wire:model.defer="description" class="w-full mt-2 p-2 border rounder">
            @error('description') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="isVisible" class="block text-gray-700">Visibilité</label>
            <label class="inline-flex items-center">
                <input type="radio" wire:model="isVisible" value="1" class="mr-2"> Oui
            </label>
            <label class="inline-flex items-center">
                <input type="radio" wire:model="isVisible" value="0" class="mr-2"> Non
            </label>
            @error('isVisible') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="px-2 py-2">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-2 py-2 rounded-lg">Ajouter la livraison</button>
            <a href={{ route('gerantdashboard') }} class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded-lg">Annuler l'ajout</a>
        </div>
    </form>
</div>
