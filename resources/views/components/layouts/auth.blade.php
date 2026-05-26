<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1">

<title>{{ $title }}</title>

@vite([
'resources/css/app.css',
'resources/js/app.js'
])

</head>

<body class="bg-[#071320] min-h-screen text-white">

<div class="grid min-h-screen lg:grid-cols-2">

{{ $slot }}

</div>

</body>

</html>