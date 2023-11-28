{{-- Welcome Section Component right below Header/navigation when user are already signed in --}}
<section class="w-full grid place-items-center bg-amber-50">
  <h1 class="text-3xl font-bold py-8">Welcome Back, {{auth()->user()->username}}</h1>
</section>