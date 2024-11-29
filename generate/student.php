<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
</head>

<body>
    <input type="text" id="inputText" placeholder="Enter text to generate QR code">
    <button id="generateBtn">Generate QR Code</button>
    <div id="qrcode"></div>

    <script>
        $(document).ready(function () {
            $('#generateBtn').click(function () {
                var text = $('#inputText').val();
                if (text !== '') {
                    new QRCode(document.getElementById("qrcode"), text);
                } else {
                    alert('Please enter some text to generate QR code.');
                }
            });
        });
    </script>
</body>

</html>