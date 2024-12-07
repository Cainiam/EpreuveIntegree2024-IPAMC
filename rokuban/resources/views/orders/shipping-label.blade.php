<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial scale=1.0">
        <title>Etiquette Commande #{{ $order->id }}</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding : 0;
                box-sizing: border-box;
            }
            .container {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
                border: 1px solid #000;
                padding: 20px;
            }
            .section {
                margin-bottom: 40px;
            }
            .header {
                text-align: left;
            }
            .footer {
                text-align: right;
            }
            .address {
                font-size: 14px;
                line-height: 1.6;
            }
            h1 {
                font-size: 18px;
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="section header">
                <h1>Expéditeur :</h1>
                <div class="address">
                    <p>Rokuban SRL<br>
                    Av. Charles Deliège 86<br>
                    7130 Binche<br>
                    BELGIQUE</p>
                </div>
            </div>

            <div class="section footer">
                <h1>Destinataire :</h1>
                <div class="address">
                    <p>{{ $user->first_name }} {{ $user->last_name }}<br>
                    {{ $user->address_line_1 }}</br>
                    @if($user->address_line_2)
                    {{ $user->address_line_2 }}</br>
                    @endif
                    {{ $user->postal_code }} {{ $user->city }}</br>
                    BELGIQUE</p>
                </div>
            </div>
        </div>
    </body>
</html>