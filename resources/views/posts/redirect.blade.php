<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- <meta http-equiv="refresh" content="{{$ad_redirect_seconds}};url={{$redirect_url}}"> -->

</head>

<body>
    <p>please wait...</p>
    <input type="hidden" id="ad_redirect_seconds" name="ad_redirect_seconds" value="{{$ad_redirect_seconds}}" />
    <script>
        var ad_redirect_seconds = document.getElementById('ad_redirect_seconds').value;
        console.log('ad_redirect_seconds',ad_redirect_seconds);
        setTimeout(function() {
            window.location.href = '{{$redirect_url}}';
        }, ad_redirect_seconds);
    </script>
</body>

</html>