<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">Votre panier :</h1>

    <!-- Message container -->
    @if(session()->has('message'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if(count($cartItems) > 0)
        <div class="mt-6">
            @foreach($cartItems as $figureId => $item)
                <div class="border p-4 rounded mb-4 bg-white">
                    <h3 class="text-lg font-semibold">{{ $item['name'] }}</h3>
                    <p class="text-gray-600">Prix : {{ $item['price'] }}€</p>
                    <div class="flex items-center mb-2">
                        <span class="text-gray-600">Quantité : {{ $item['quantity'] }}</span>
                        <button wire:click="increaseQuantity({{ $figureId }})" class="bg-gray-300 text-gray-800 px-2 py-1 rounded">+</button>
                        <button wire:click="decreaseQuantity({{ $figureId }})" class="bg-gray-300 text-gray-800 px-2 py-1 rounded">-</button>
                    </div>
                    <p class="text-gray-600">Total : {{ $item['quantity'] * $item['price'] }}€</p>
                    <button wire:click="removeItem({{ $figureId }})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded mt-4">Supprimer</button>
                </div>
            @endforeach
            <div class="flex justify-end space-x-4 mt-4">
                <a href="{{ route('checkout') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Payer</a>
                <a href="{{ route('paypal.checkout') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Payer avec PayPal</a>
                <button wire:click="clearCart" class="bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-2 rounded">Vider le panier</button>
            </div>
        </div>
    @else
        <div class="border p-4 rounded mb-4 bg-white">
            <p>Votre panier est vide !</p>
        </div>
    @endif
</div>
