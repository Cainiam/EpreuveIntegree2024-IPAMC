<div class="container mx-auto py-8">

    @if(session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">{{ session('message') }}</div>
    @endif

    <h1 class="text-2xl font-bold mb-4 bg-blue-50 border border-gray-300 rounded-lg p-4 pl-6 shadow">Figurine : {{ $figure->name }}</h1>

    <div class="border mb-4 p-6 rounded-lg bg-white flex flex-col md:flex-row items-start">
        <!-- Image -->
        @if($figure->image_path)
            <div class="w-full md:w-1/2">
                <img src="{{ Storage::url(''.$figure->image_path.'') }}" alt="{{ $figure->name }}" class="w-full h-auto rounded-lg shadow-lg">
            </div>
        @endif
        <!-- Details -->
        <div class="w-full md:w-1/2 md:pl-8">
            <p><span class="font-semibold">Prix TTC :</span> {{ $figure->price }}€</p>
            <p><span class="font-semibold">Description de la figurine :</span><br> {{ $figure->description }}</p>
            <p><span class="font-semibold">Brand :</span> {{ $brand->name }}</p>
            <p><span class="font-semibold">Collection :</span> {{ $figure->collection }}</p>
            <p><span class="font-semibold">Nom du personnage :</span> {{ $figure->character_name }}</p>
            <p><span class="font-semibold">Série :</span> {{ $figure->series_title }}</p>
            <p><span class="font-semibold">Sculpteur :</span> {{ $figure->sculptor_name }}</p>
            <p><span class="font-semibold">Matériel :</span> {{ $figure->material }}</p>
            <p><span class="font-semibold">Taille :</span> {{ $figure->height }}</p>
            <p><span class="font-semibold">Scale :</span>  {{ $scale->name }}</p>
            <p><span class="font-semibold">Date de sortie :</span> {{ $figure->release_date }}</p>
            <p><span class="font-semibold">Référence :</span> {{ $figure->reference }}</p>
            <p><span class="font-semibold">EAN :</span> {{ $figure->ean }}</p>
            <p><span class="font-semibold">Etat :</span> {{ $figure->state }}</p>
            <p><span class="font-semibold">Catégorie :</span> {{ $category->name }}</p>
        </div>
    </div>

    <div class="px-2 py-2">
        @if($figure->stock_qty > 0 && $figure->isVisible)
            <button wire:click="addToCart({{ $figure->id }})" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded-lg">Ajouter au panier</button>
        @else
            <a href=# class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded-lg">Rupture de stock</a>
        @endif
        <a href="{{ route('figures.index') }}" class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded-lg">Retour</a>
    </div>
</div>
