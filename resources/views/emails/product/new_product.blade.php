<!DOCTYPE html>
<html>

<head>
    <title>New Product Added</title>
</head>

<body>
    <h1>{{ $mailData['title'] }}</h1>

    <p>Product Name: {{ $mailData['product_name'] }}</p>
    <p>Added By: {{ $mailData['product_added_by'] }}</p>

    <p>Thank you</p>
</body>

</html>