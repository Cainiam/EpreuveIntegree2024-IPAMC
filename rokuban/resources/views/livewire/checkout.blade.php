<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">Résumé de votre commande et payement :</h1>

    @if(count($cartItems) <= 0) <!-- No item in cart = redirected with message (if user try to use url to go in the page) -->
        <?php
            return redirect('/cart')->with('message', 'Vous ne pouvez accéder au payement de la commande avec un panier vide.');
        ?>
    @endif

    <!-- Message container -->
    @if(session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Shipping method selection -->
    <div class="bg-blue-50 shadow-md rounded-lg p-4 mb-6">
        <label for="shipping" class="block text-sm font-medium mb-2">Sélectionner une méthode de transport ici :</label>
        <select id="shipping" wire:model.live="selectedShipping" class="w-full border rounded-lg p-2">
            <option value="" selected>-- Choissisez ici --</option>
            @foreach($shippings as $shipping)
                @if($shipping->isVisible)
                    <option value="{{ $shipping->id }}">{{ $shipping->name }} - {{ number_format($shipping->price, 2) }}€</option>
                @endif
            @endforeach
        </select>
        @error('selectedShipping') <p class="text-red-500 text-sm mt-1">{{ $message }} @enderror
    </div>

    <!-- Order details -->
    <div class="bg-blue-50 shadow-md rounded-lg p-4 mb-6">
        <h2 class="text-lg font-semibold mb-2">Détails des articles :</h2>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Nom de l'article</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Quantité</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">Prix unitaire</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">Prix total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                    <tr class="bg-white">
                        <td class="border border-gray-300 px-4 py-2">{{ $item['name'] }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $item['quantity'] }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">{{ number_format($item['price'], 2) }}€</td>
                        <td class="border border-gray-300 px-4 py-2 text-right">{{ number_format($item['price'] * $item['quantity'], 2) }}€</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Price details -->
    <div class="bg-blue-50 shadow-md rounded-lg p-4 mb-6">
        <h2 class="text-lg font-semibold mb-2">Résumé prix :</h2>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <tbody>
                <tr>
                    <td class="border border-gray-300 bg-white px-4 py-2 font-medium">Total des articles :</td>
                    <td class="border border-gray-300 bg-white px-4 py-2 text-right">{{ number_format($totalPrice, 2) }}€</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 bg-white px-4 py-2 font-medium">Frais de transport :</td>
                    <td class="border border-gray-300 bg-white px-4 py-2 text-right">
                        @if ($selectedShipping)
                            {{ number_format($shippingCost, 2) }}€
                        @else
                            Non sélectionné
                        @endif
                    </td>
                </tr>
                <tr class="bg-gray-100 font-bold">
                    <td class="border border-gray-300 px-4 py-2">Total de votre commande :</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">
                        @if ($selectedShipping)
                            {{ number_format($totalPriceWithShipping, 2) }}€
                        @else
                            ---- €
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Order payment -->
    <div class="bg-blue-50 shadow-md rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-2">Vos informations de paiement :</h2>
        <form wire:submit.prevent="submitPayment">
            <div class="mb-4">
                <label for="cardNumber" class="block text-sm font-medium mb-2">Numéro de votre carte de paiement :</label>
                <input type="text" id="cardNumber" wire:model="cardNumber" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                @error('cardNumber') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg">Payer la commande</button>
        </form>
    </div>
</div>