<p>Bonjour {{ $user->first_name }}, </p>

<p>Le status de votre commande #{{ $order->id }} a été mis à jour. Elle est maintenant : {{ $order->status }}.</p>

@if($order->tracker)
    <p>Vous pouvez désormais suivre votre commande livrée via notre partenaire grace au lien suivant : <a href="{{ $order->tracker }}">{{ $order->tracker }}</a></p>
@endif

<p>Merci de votre confiance en vers Rokuban.</p>
<p>Ne pas répondre, mail automatique.</p>