{{-- General Layout and Boilerplate for most pages includes default header/navigation and footer --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Zodiac</title>
</head>
<body class="font-hanken text-base flex flex-col items-center">
  <x-headerNav />
  <main class="w-full">
    {{$slot}}
  </main>
  <x-footer />
  <x-flash-message />
</body>
</html>