<x-app-layout>
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-4 bg-blue-100 border border-gray-300 rounded-lg p-4 pl-6 shadow">Payement réussi et commande validée</h2>
        <p class="block text-gray-700">Merci pour  votre achat! Votre numéro de commande est le suivant : #{{ $orderId }}. Vous pouvez retourner dans vos commande pour télécharger la facture.</p>
        <a href="{{ route('figures.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Continuer de parcourir le site</a>
    </div>
</x-app-layout>