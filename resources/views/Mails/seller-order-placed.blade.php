<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تم تأكيد الطلب</title>
</head>
<body style="font-family: sans-serif; background-color: #f9fafb; padding: 20px; color: #333;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">

        <h2 style="color: #16a34a; font-size: 24px;">✅ شكراً يا {{ $sellerDetails['name'] }}، تم تأكيد طلبك!</h2>
        <h2 style="color: #16a34a; font-size: 24px;">✅  عنوان {{ $userDetails['city'] .'/'.$userDetails['area'].'/'.$userDetails['street']}} </h2>
        <h2 style="color: #16a34a; font-size: 24px;">✅  رقم البائع {{ $userDetails['phone']}} </h2>

        <p style="font-size: 16px;">طلبك رقم <strong>#{{ $orderDetails['order_number'] }}</strong> تم تسجيله بنجاح.</p>

        <table style="width: 100%; margin-top: 20px;">
            <tr>
                <td><strong>طريقة الدفع:</strong></td>
                <td>{{ $orderDetails['payment_method'] }}</td>
            </tr>
            <tr>
                <td><strong>السعر الكلي:</strong></td>
        <td>{{ number_format($orderDetails['price'], 2) }} جنيه</td>
            </tr>
            <tr>
                <td><strong>تاريخ الطلب:</strong></td>
                <td>{{ \Carbon\Carbon::parse($orderDetails['created_at'])->format('Y-m-d H:i') }}</td>
            </tr>

        </table>

        <h3 style="margin-top: 30px; font-size: 18px;">🛒 تفاصيل المنتجات:</h3>

        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">المنتج</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">الكمية</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">السعر</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderDetails['items'] as $item)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $item['product']['name'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $item['quantity'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ number_format($item['price'], 2) }} جنيه</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top: 30px;">لو عندك أي استفسار، لا تتردد تتواصل معنا في أي وقت 😊</p>

    </div>

</body>
</html>
