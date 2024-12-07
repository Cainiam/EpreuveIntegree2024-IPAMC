<!DOCTYPE html>
<html>
    <head>
        <tile>Détails de votre commande du {{$order->created_at->format('d/m/Y')}}</tile>
    </head>

    <body>
        <h1>Bonjour,</h1>

        <p>Merci de votre commande! En voici les détails :</p>

        <h2>Commande #{{ $order->id }}</h2>
        <p>Date : {{ $order->created_at->format('d/m/Y') }}</p>
        <p>Prix TTC : {{ number_format($order->pricettc, 2) }}€</p>
        <p>Frais de transport : {{ number_format($order->shipping_at_date, 2) }}€</p>
        <p>Total : {{ number_format($order->pricettc + $order->shipping_at_date, 2) }}€</p>

        <h3>Vos articles :</h3>
        <table border="1" cellpading="5">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prix HT</th>
                    <th>Prix TTC</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderDetails as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ number_format($item->price_at_date, 2) }}€</td>
                        <td>{{ number_format($item->pricettc_at_date, 2) }}€</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->pricettc_at_date * $item->quantity, 2) }}€</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p>Vous pouvez également télécharger la facture sur le site en vous rendant dans vos commandes.</p>
        
        <p>Merci de votre confiance !</p>

        <p>Ne pas répondre, mail automatique.</p>
    </body>
</html>