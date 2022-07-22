
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

    <!-- CSS Reset : BEGIN -->

</head>

<body style="font-size: 16px;line-height: 24px;font-family: 'Lato', sans-serif;color: #000000;background-color: #f1f1f1;">
Dear Ayush, <strong>Your order has been placed.</strong>

<div class="invoice-box" style="max-width: 800px;margin: auto;padding: 30px;border: 1px solid #eee;box-shadow: 0 0 10px rgba(0, 0, 0, .15);font-size: 16px;line-height: 24px;font-family: 'Lato', sans-serif;color: #555;background-color: white;">
    <img src="logo.png" alt="Company logo" width="20%"/><br>
    <p style="text-align:center;">
        <strong style="color: #000000;">
            Dami Yatra<br />
            Devkota Sadak, Baneshwor<br />
            Kathmandu, Nepal
        </strong>
    </p>
    <div style="position: relative;">

        <div style="right:0;position: absolute;text-align: end;color: #000000;" >
            <strong>Invoice:#</strong> 101212<br />
            <strong>Created:</strong> 02/08/2022<br />
        </div>

        <div style="text-align: start;position: absolute;left:0;color: #000000;">
            <strong>Customer Name:</strong> Ayush KC<br />
            <strong>Contact no:</strong> 9867678787
        </div>
    </div>

    <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;margin-top:15%;color: #000000;">


        <tr class="heading">
            <td style="padding: 5px;vertical-align: top;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;color:white;background-color: #4F46E5;">
                Item
            </td>
            <td style="padding: 5px;vertical-align: top;text-align: right;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold; color:white;background-color: #4F46E5;">
                Unit Price
            </td>
            <td style="padding: 5px;vertical-align: top;text-align: right;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold; color:white;background-color: #4F46E5;">
                Quantity
            </td>

            <td style="padding: 5px;vertical-align: top;text-align: right;background: #eee;border-bottom: 1px solid #ddd;font-weight: bold; color:white;background-color: #4F46E5;">
                Sub Amount
            </td>
        </tr>
        <!-- {% for invoice_detail in invoice_details %} -->
        <tr class="item">
            <td style="padding: 5px;vertical-align: top;border-bottom: 1px solid #eee;color: #000000;">
                Pokhara Tour Package
            </td>
            <td style="padding: 5px;vertical-align: top;text-align: right;border-bottom: 1px solid #eee;color: #000000;">
                10000
            </td>
            <td style="padding: 5px;vertical-align: top;text-align: right;border-bottom: 1px solid #eee;color: #000000;">
                1
            </td>

            <td style="padding: 5px;vertical-align: top;text-align: right;border-bottom: 1px solid #eee;color: #000000;">
                10000
            </td>
        </tr>
        <!-- {% endfor %} -->


        <tr class="total">
            <td style="padding: 5px;vertical-align: top;"></td>
            <td></td>
            <td></td>
            <td style="padding: 5px;vertical-align: top;text-align: right;border-top: 2px solid #4F46E5;font-weight: bold;color: #000000;">

                Tax @13%: 1300
            </td>
        </tr>
        <!--             <tr class="total">
                <td style="padding: 5px;vertical-align: top;"></td>
                <td></td>
                <td></td>
                <td style="padding: 5px;vertical-align: top;text-align: right;border-top: 2px solid #4F46E5;font-weight: bold;color: #000000;">

                   Shipping cost: Rs. {{shipping.shipping_cost}}
        </td>
    </tr> -->

        <tr class="total">
            <td style="padding: 5px;vertical-align: top;"></td>
            <td></td>
            <td></td>
            <td style="padding: 5px;vertical-align: top;text-align: right;border-top: 2px solid #4F46E5;font-weight: bold;color: #000000;">

                Total: Rs. 11300
            </td>
        </tr>
    </table>
</div>
</body>
