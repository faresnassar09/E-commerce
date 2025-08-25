<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طلب الإرجاع مرفوض</title>
</head>
<body style="font-family: sans-serif; background-color: #f9fafb; padding: 20px; color: #333;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h2 style="color: #dc2626; font-size: 24px;">❌ تم رفض طلب الإرجاع</h2>

        <p style="font-size: 16px;">عزيزي {{ $userInfo['name'] }}, نود إبلاغك أن طلب الإرجاع الخاص بك للطلب رقم <strong>#{{ $orderDetails['order_number'] }}</strong> لم يتم قبوله.</p>

        <h3 style="margin-top: 20px; font-size: 18px;">📄 تفاصيل الطلب:</h3>
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
                <td><strong>تاريخ الرفض:</strong></td>
                <td>{{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</td>
            </tr>
        </table>

        <h3 style="margin-top: 30px; font-size: 18px;">📞 للتواصل مع البائع:</h3>
        <p style="font-size: 16px;">
            في حال كان لديك أي استفسار بخصوص سبب الرفض، يمكنك التواصل مع البائع مباشرة على الرقم:
            <strong>{{ $sellerPhoneNumber }}</strong>
        </p>

        <p style="margin-top: 20px;">نعتذر عن أي إزعاج، ونتمنى لك تجربة تسوق أفضل في المرات القادمة 🙏</p>
    </div>

</body>
</html>
