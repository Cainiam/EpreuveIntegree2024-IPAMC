<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4 border border-gray-300 rounded-lg p-4 pl-6 shadow bg-blue-100">Toutes les figurines disponibles :</h1>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">{{ session('message') }}</div>
    @endif

    <!-- Search bar & sorting -->
    <div class="mb-4 flex justify-between items-center">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher une figurine par son nom..." class="border rounded-lg p-2 w-full" />

        <select wire:model.live="sort" class="border rounded-lg p-2 ml-4">
            <option value="recent">Récent à ancien</option>
            <option value="oldest">Ancien à récent</option>
            <option value="price_asc">Prix croissant</option>
            <option value="price_desc">Prix décroissant</option>
        </select>
    </div>


    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($figures as $figure)
            @if($figure->isVisible)
                <div class="border border-gray-300 p-4 rounded bg-white flex flex-col">
                    <div class="ml-4">
                        <h2 class="text-lg font-semibold border-gray-400 text-center border rounded p-2 bg-blue-50 mb-4"> {{ $figure->name }}</h2>
                        <div class="flex items-start">
                            <!-- Image -->
                            @if($figure->image_path)
                                <div class="w-24 h-24 flex-shrink-0 mr-4">
                                    <img src="{{ Storage::url(''.$figure->image_path.'') }}" alt="{{ $figure->name }}" class="w-full h-full object-cover rounded-md">
                                </div>
                            @endif
                            <!-- Details -->
                            <div>
                                <p class="text-gray-600">Prix TTC : {{ $figure->price }}€</p>
                                <p class="text-gray-600">Personnage : {{ $figure->character_name }}</p>
                                <p class="text-gray-600">Taille : {{ $figure->height }}</p>
                                <p class="text-gray-600">Date de sortie : {{ $figure->release_date }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 px-2 py-2">
                        @if($figure->stock_qty > 0)
                            <button onclick="window.location.href='{{ route('figures.show', $figure->id) }}'" class="bg-green-500 hover:bg-green-600 text-white px-2 py-2 rounded-lg">Détails</button>
                        @else
                            <a href=# class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded-lg">Rupture de stock</a>
                        @endif
                        <button wire:click="addToCart({{ $figure->id }})" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded-lg">Ajouter au panier</button>
                    </div>
                </div>
            @endif
        @empty
            <p class="text-gray-500">Aucun produit n'a été trouvé.</p>
        @endforelse
    </div>
    <div class="mt-4">
            {{ $figures->links() }}
    </div>
</div>
