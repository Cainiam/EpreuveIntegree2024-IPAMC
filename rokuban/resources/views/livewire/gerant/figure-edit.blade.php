<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">Modification de figurine</h1>

    @if(session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounder mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="updateFigure" class="bg-blue-50 border border-gray-300 rounded-lg px-2 py-2">
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nom :</label>
            <input type="text" id="name" wire:model.defer="name" class="w-full mt-2 p-2 border rounder">
            @error('name') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700">Prix TTC :</label>
            <input type="number" step="0.01" id="price" wire:model.defer="price" class="w-full mt-2 p-2 border rounder">
            @error('price') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description :</label>
            <input type="text" id="description" wire:model.defer="description" class="w-full mt-2 p-2 border rounder">
            @error('description') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="image_path" class="block text-gray-700">Image :</label>
            <input type="file" id="image_path" accept="image/*" wire:model.defer="image_path" class="w-full mt-2 p-2 border rounder">
            @error('image_path') <span class="text-red-500"> {{ $message }}</span> @enderror
            @if($image_path)
                <p class="mt-2">Prévisualisation de l'image :</p>
                <img src="{{ $image_path->temporaryUrl() }}" alt="Preview" class="max-w-sm">
            @elseif($existing_path)
                <p class="mt-2">Image actuelle :</p>
                <img src="{{ Storage::url(''. $existing_path .'') }}" alt="Actuelle" class="max-w-sm">
            @endif
        </div>

        <div class="mb-4">
            <label for="tva_id" class="block text-gray-700">TVA :</label>
            <select id="tva_id" wire:model="tva_id" class="border rounded mt-2 p-2 w-full">
                <option value="">--- Choissisez la TVA ---</option>
                @foreach($tvas as $tva)
                    <option value="{{ $tva->id }}">{{ number_format($tva->purcent * 100) }}%</option>
                @endforeach
            </select>
            @error('tva_id') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="brand_id" class="block text-gray-700">Marque :</label>
            <select id="brand_id" wire:model="brand_id" class="border rounded mt-2 p-2 w-full">
                <option value="">--- Choissisez la marque ---</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
            @error('brand_id') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="collection" class="block text-gray-700">Collection :</label>
            <input type="text" id="collection" wire:model.defer="collection" class="w-full mt-2 p-2 border rounder">
            @error('collection') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="character_name" class="block text-gray-700">Personnage :</label>
            <input type="text" id="character_name" wire:model.defer="character_name" class="w-full mt-2 p-2 border rounder">
            @error('character_name') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="series_title" class="block text-gray-700">Série :</label>
            <input type="text" id="series_title" wire:model.defer="series_title" class="w-full mt-2 p-2 border rounder">
            @error('series_title') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="sculptor_name" class="block text-gray-700">Sculpteur :</label>
            <input type="text" id="sculptor_name" wire:model.defer="sculptor_name" class="w-full mt-2 p-2 border rounder">
            @error('sculptor_name') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="material" class="block text-gray-700">Matériel :</label>
            <input type="text" id="material" wire:model.defer="material" class="w-full mt-2 p-2 border rounder">
            @error('material') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label for="height" class="block text-gray-700">Taille :</label>
            <input type="text" id="height" wire:model.defer="height" class="w-full mt-2 p-2 border rounder">
            @error('height') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="scale_id" class="block text-gray-700">Echelle :</label>
            <select id="scale_id" wire:model="scale_id" class="border rounded mt-2 p-2 w-full">
                <option value="">--- Choissisez l'échelle ---</option>
                @foreach($scales as $scale)
                    <option value="{{ $scale->id }}">{{ $scale->name }}</option>
                @endforeach
            </select>
            @error('scale_id') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="release_date" class="block text-gray-700">Date de sortie :</label>
            <input type="text" id="release_date" wire:model.defer="release_date" class="w-full mt-2 p-2 border rounder">
            @error('release_date') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="stock_qty" class="block text-gray-700">Stock :</label>
            <input type="number" id="stock_qty" wire:model.defer="stock_qty" class="w-full mt-2 p-2 border rounder">
            @error('stock_qty') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="reference" class="block text-gray-700">Référence :</label>
            <input type="text" id="reference" wire:model.defer="reference" class="w-full mt-2 p-2 border rounder">
            @error('reference') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="ean" class="block text-gray-700">EAN :</label>
            <input type="number" id="ean" wire:model.defer="ean" class="w-full mt-2 p-2 border rounder">
            @error('ean') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>        

        <div class="mb-4">
            <label for="state" class="block text-gray-700">Etat :</label>
            <select id="state" wire:model="state" class="border rounded mt-2 p-2 w-full">
                <option value="">--- Choissisez l'état ---</option>
                <option value="Neuve">Neuve</option>
                <option value="Comme neuve">Comme neuve</option>
                <option value="Boite ouverte mais neuve">Boite ouverte mais neuve</option>
                <option value="Occassion">Occassion</option>
            </select>
            @error('state') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700">Catégorie :</label>
            <select id="category_id" wire:model="category_id" class="border rounded mt-2 p-2 w-full">
                <option value="">--- Choissisez la catégorie ---</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="isVisible" class="block text-gray-700">Visibilité :</label>
            <label class="inline-flex items-center">
                <input type="radio" wire:model="isVisible" value="1" class="mr-2"> Oui
            </label>
            <label class="inline-flex items-center">
                <input type="radio" wire:model="isVisible" value="0" class="mr-2"> Non
            </label>
            @error('isVisible') <span class="text-red-500"> {{ $message }}</span> @enderror
        </div>

        <div class="px-2 py-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded-lg">Mettre à jour</button>
            <a href={{ route('gerantdashboard') }} class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded-lg">Annuler</a>
        </div>
    </form>
</div>