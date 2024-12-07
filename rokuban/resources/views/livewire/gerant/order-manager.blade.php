<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">Gestion de la commande #{{ $orderId }} </h2>

        @if(session()->has('message'))
            <div class="bg-green-500 text-white p-4 rounder mb-4">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="updateOrder" class="bg-blue-50 border border-gray-300 rounded-lg px-2 py-2">
            <div class="mb-4">
                <label for="status" class="block text-gray-700">Statut de la commande :</label>
                <select wire:model.defer="status" id="status" class="w-full mt-2 p-2 border rounder">
                    <option value="">--- Choissisez un statut ici ---</option>
                    <option value="Reçue">Reçue</option>
                    <option value="En préparation">En préparation</option>
                    <option value="Prête à être expédiée">Prête à être expédiée</option>
                    <option value="Expédiée">Expédiée</option>
                    <option value="Annulée">Annulée</option>
                </select>
                @error('status') <span class="text-red-500"> {{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="tracker" class="block text-gray-700">Lien du tracker :</label>
                <input type="url" wire:model.defer="tracker" id="tracker" class="w-full mt-2 p-2 border rounder">
                @error('tracker') <span class="text-red-500"> {{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="isVisible" class="block text-gray-700">Visibilité de la commande :</label>
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="isVisible" value="1" class="mr-2"> Oui
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="isVisible" value="0" class="mr-2"> Non
                </label>
                @error('isVisible') <span class="text-red-500"> {{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Mettre à jour la commande</button>
            <a href={{ route('gerantdashboard') }} class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Annuler la modification</a>
        </form>
</div>
