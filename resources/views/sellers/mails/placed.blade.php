<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{__('messages.new_order_title')}}</title>
</head>
<body style="font-family: sans-serif; background-color: #f9fafb; padding: 20px; color: #333;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h2 style="color: #16a34a; font-size: 24px;">✅ {{ __('messages.new_order_heading') }}</h2>

        <h2 style="color: #16a34a; font-size: 24px;">{{__('messages.customer_name')}}: {{ $user['name'] }}</h2>
        <h2 style="color: #16a34a; font-size: 24px;">{{__('messages.customer_address')}}: {{ $user['city'] .'/'.$user['area'].'/'.$user['street']}} </h2>
        <h2 style="color: #16a34a; font-size: 24px;">{{__('messages.customer.phone')}}: {{ $user['phone']}} </h2>

        <p style="font-size: 16px;">{{__('messages.new_order_message', ['order_number' => $orderDetails['order_number']])}}</p>

        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td><strong>{{__('messages.payment_method')}}:</strong></td>
                <td>{{ $orderDetails['payment_method'] }}</td>
            </tr>
            <tr>
                <td><strong>{{__('messages.total_price')}}:</strong></td>
                <td>{{ number_format($orderDetails['price'], 2) }} {{__('messages.currency')}}</td>
            </tr>
            <tr>
                <td><strong>{{__('messages.order_date')}}:</strong></td>
                <td>{{ \Carbon\Carbon::parse($orderDetails['created_at'])->format('Y-m-d H:i') }}</td>
            </tr>
        </table>

        <h3 style="margin-top: 30px; font-size: 18px;">🛒 {{__('messages.product_details_heading')}}</h3>

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

        <p style="margin-top: 30px;">{{__('messages.new_order_note')}}</p>

    </div>

</body>
</html>