<!DOCTYPE html>
<!-- Done based on various invoices from Belgian companies found on Internet && following https://www.accountable.eu/fr-be/blog/belgique-faire-facture/ -->
<html>
    <head>
        <title> Facture - Commande #{{ $order->id }}</title>
        <style>
            body { 
                font-family: Arial, sans-serif; 
            }
            .invoice-box {
                max-width: 800px;
                margin: auto;
                padding: 20px;
                border: 1px solid #eee;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
                font-size: 16px;
                line-height: 24px;
                color: #555;
            }
            table {
                width: 100%;
                line-height: inherit;
                text-align: left;
            }
            table th {
                background:#eee;
                padding: 10px;
            }
            table td {
                padding: 10px;
                vertical-align: top;
            }
            .semi-total {
                font-weight: bold;
            }
            .total {
                font-weight: bolder;
            }
            .address {
                margin-bottom: 20px;
            }
            .footer {
                margin-top: 20px;
                font-size: 12px;
                color: #999;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="invoice-box">
            <h1>Votre facture - Commande n° #{{ $order->id }}</h1>
            <hr>
            <div class="address">
                <div style="float: left; width: 50%;">
                    <h3>Vendeur :</h3>
                    <p>
                        Rokuban SRL<br>
                        Av. Charles Deliège 86<br> <!-- Fake Address! -->
                        7130 Binche<br>
                        BELGIQUE<br>
                        TVA BE 0123 456 789<br> <!-- Fake belgium tva identifier! -->
                        IBAN : BE68 5390 0754 7034 <br> <!-- Bank account of ING Belgium for this fake example, don't use! -->
                        BIC : BBRUBEBB <br> <!-- BIC for ing bank account -->
                        admin@rokuban.com <br> <!-- True address for demo website of our Hostinger hosting -->
                    </p>
                </div>

                <div style="float: right; width: 50%; text-align: right;">
                    <h3>Client :</h3>
                    <p>
                        {{ $user->first_name}} {{$user->last_name}}<br>
                        {{ $user->address_line_1 }}<br>
                        @if ($user->address_line_2)
                            {{ $user->address_line_2 }} <br>
                        @endif
                        {{ $user->postal_code }} {{$user->city}}<br>
                        BELGIQUE <br> <!-- Belgique forced since only solding in Belgium -->
                        {{ $user->email }}
                        @if (!$user->address_line_2)
                            <br>
                        @endif
                        <br><br>
                    </p>
                </div>
            </div>

            <p style="text-align: right;">Date : {{ $order->created_at->format('d/m/Y') }} <br>
               Client : {{ $user->first_name}} {{$user->last_name}} | #{{ $user->id }} 
            </p>
            <hr>

            <h3> Détails de la  commande :</h3>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nom du produit</th>
                        <th>Prix HT</th>
                        <th>TVA</th>
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
                            <td>{{ number_format(($item->pricettc_at_date / $item->price_at_date - 1)* 100), 0}}%</td> <!-- We are calculating TVA base on HT & TTC -->
                            <td>{{ number_format($item->pricettc_at_date, 2) }}€</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->pricettc_at_date * $item->quantity, 2) }}€</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="text-align: right;"><span class="semi-total">Total TTC :</span> {{ number_format($order->pricettc, 2) }}€<br>
            <span class="semi-total"> Frais de transport :</span> {{ number_format($order->shipping_at_date, 2) }}€<br>
            <span class="total">Total final :</span> {{ number_format($order->shipping_at_date + $order->pricettc, 2) }}€</p>
            <hr>

            <div class="footer">
                <p style="text-align: center;">Cette facture a été générée le {{ now()->locale('fr')->translatedFormat('d F Y') }} - © {{now()->format('Y')}} Rokuban </p>
            </div>
        </div>
    </body>
</html>