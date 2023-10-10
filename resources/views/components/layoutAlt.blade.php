<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Zodiac</title>
</head>
<body>
  <main class="grid grid-cols-2 place-items-center">
    <div class="grid place-items-center h-full bg-green-200">
      <img src="{{Vite::asset("resources/images/globe.png")}}" alt="globe image">
    </div>
    <div class="grid place-items-center gap-4 px-40 py-6">
      <div class="flex items-center gap-1">
        <svg class="-translate-y-1" xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 48 48"><ellipse cx="29.465" cy="21.416" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" rx="15.89" ry="6.4" transform="rotate(-74.222 29.465 21.417)"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m33.786 6.125l-8.642 30.583m-.131-21.349l4.114 7.255m-1.743 6.166l6.766-1.77m1.474-3.878H42.5m-37 0h16.939m7.938 9.372H42.5m-37 0h17.914M5.5 41.875h18.419m-2.981-5.437l2.981 5.437l5.438-2.981"/></svg>
        <a href="/" class="font-bold text-4xl">ZODIAC</a>
      </div>
      {{$slot}}
      <div>
        <a class="underline text-blue-500" href="/legal">Terms and Conditions</a>
      </div>
    </div>
  </main>
</body>
</html>