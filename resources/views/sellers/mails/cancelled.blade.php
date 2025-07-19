<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تم إلغاء الطلب</title>
</head>
<body style="font-family: sans-serif; background-color: #f9fafb; padding: 20px; color: #333;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h2 style="color: #dc2626; font-size: 24px;">❌ تم إلغاء الطلب</h2>

        <p style="font-size: 16px;">نأسف لإبلاغك أنه تم إلغاء الطلب رقم <strong>#{{ $orderDetails['order_number'] }}</strong>.</p>

        <h3 style="margin-top: 20px; font-size: 18px;">👤 بيانات العميل:</h3>
        <ul style="list-style: none; padding: 0;">
            <li>👤 الاسم: {{ $user['name'] }}</li>
            <li>📍 العنوان: {{ $user['city'] . '/' . $user['area'] . '/' . $user['street'] }}</li>
            <li>📞 رقم الهاتف: {{ $user['phone'] }}</li>
        </ul>

        <h3 style="margin-top: 20px; font-size: 18px;">📦 تفاصيل الطلب:</h3>
        <table style="width: 100%; margin-top: 10px;">
 
            <tr>
                <td><strong>السعر الكلي:</strong></td>
                <td>{{ number_format($orderDetails['price'], 2) }} جنيه</td>
            </tr>
            <tr>
                <td><strong>تاريخ الطلب:</strong></td>
                <td>{{ \Carbon\Carbon::parse($orderDetails['created_at'])->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <td><strong>تاريخ الإلغاء:</strong></td>
                <td>{{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</td>
            </tr>
        </table>

        <h3 style="margin-top: 30px; font-size: 18px;">🛒 المنتجات الملغاة:</h3>
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

        <p style="margin-top: 30px;">لو حصل الإلغاء عن طريق الخطأ أو عندك أي استفسار، تواصل معنا، وسنكون سعداء بمساعدتك 😊</p>

    </div>

</body>
</html>
