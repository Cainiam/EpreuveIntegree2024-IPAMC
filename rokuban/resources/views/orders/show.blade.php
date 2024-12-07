<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">Détails de la commande #{{ $order->id }} du {{ $order->created_at->format('d/m/Y') }}</h1>

        <table class="table-auto w-full border-collapse border border-gray-300 bg-white shadow">
            <thead>
                <tr class="bg-blue-200">
                    <th colspan="5" class="text-lg font-semibold mb-2 text-center">Articles :</th>
                </tr>
                <tr class="bg-blue-100">
                    <th class="border border-gray-300 px-4 py-2">Nom</th>
                    <th class="border border-gray-300 px-4 py-2">Prix HT</th>
                    <th class="border border-gray-300 px-4 py-2">Prix TTC</th>
                    <th class="border border-gray-300 px-4 py-2">Quantité</th>
                    <th class="border border-gray-300 px-4 py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderDetails as $figure)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $figure->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($figure->price_at_date, 2) }}€</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($figure->pricettc_at_date, 2) }}€</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $figure->quantity }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($figure->pricettc_at_date * $figure->quantity, 2) }}€</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 flex justify-end">
            <table class="table-auto w-1/2 border-collapse border border-gray-300 bg-white shadow">
                <tr>
                    <td colspan="2" class="text-lg font-semibold mb-2 bg-blue-200 px-4 py-2 text-center">Récapitulatif :</td>
                </tr>
                <tr>
                    <td class="border font-semibold border-gray-300 bg-blue-100 px-4 py-2 text-right">Prix total HT :</td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($order->price, 2) }}€</td>
                </tr>
                <tr>
                    <td class="border font-semibold border-gray-300 bg-blue-100 px-4 py-2 text-right">Prix total TTC :</td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($order->pricettc, 2) }}€</td>
                </tr>
                <tr>
                    <td class="border font-semibold border-gray-300 bg-blue-100 px-4 py-2 text-right">Frais de transport :</td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($order->shipping_at_date, 2) }}€</td>
                </tr>
                <tr>
                    <td class="border font-semibold border-gray-300 bg-blue-100 px-4 py-2 text-right">Total de la commande :</td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($order->pricettc + $order->shipping_at_date, 2) }}€</td>
                </tr>
            </table>
        </div>
    </div>
</x-app-layout>>