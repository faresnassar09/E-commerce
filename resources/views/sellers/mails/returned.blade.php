<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{__('messages.order_returned_title')}}</title>
</head>
<body style="font-family: sans-serif; background-color: #f9fafb; padding: 20px; color: #333;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h2 style="color: #f59e0b; font-size: 24px;">↩️ {{__('messages.order_returned_heading')}}</h2>

        <p style="font-size: 16px;">{{__('messages.order_returned_message', ['order_number' => $orderDetails['order_number']])}}</p>

        <h3 style="margin-top: 20px; font-size: 18px;">👤 {{__('messages.customer_details_heading')}}</h3>
        <ul style="list-style: none; padding: 0;">
            <li>👤 {{__('messages.customer_name')}}: {{ $user['name'] }}</li>
            <li>📍 {{__('messages.customer_address')}}: {{ $user['city'] . '/' . $user['area'] . '/' . $user['street'] }}</li>
            <li>📞 {{__('messages.customer_phone')}}: {{ $user['phone'] }}</li>
        </ul>

        <h3 style="margin-top: 20px; font-size: 18px;">📦 {{__('messages.order_details_heading')}}</h3>
        <table style="width: 100%; margin-top: 10px;">
            <tr>
                <td><strong>{{__('messages.total_price')}}:</strong></td>
                <td>{{ number_format($orderDetails['price'], 2) }} {{__('messages.currency')}}</td>
            </tr>
            <tr>
                <td><strong>{{__('messages.order_date')}}:</strong></td>
                <td>{{ \Carbon\Carbon::parse($orderDetails['created_at'])->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <td><strong>{{__('messages.return_date')}}:</strong></td>
                <td>{{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</td>
            </tr>
        </table>

        <h3 style="margin-top: 30px; font-size: 18px;">🔄 {{__('messages.returned_products_heading')}}</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};">{{__('messages.product_name')}}</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};">{{__('messages.quantity')}}</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};">{{__('messages.price')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderDetails['items'] as $item)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $item['product']['name'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $item['quantity'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ number_format($item['price'], 2) }} {{__('messages.currency')}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top: 30px;">{{__('messages.return_note')}}</p>
    </div>

</body>
</html>