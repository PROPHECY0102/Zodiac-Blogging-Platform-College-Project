{{-- Hero Section Component Homepage when Users are not Signed In --}}
<section class="w-full grid place-items-center bg-amber-50">
  <div class="w-4/5 grid grid-flow-col gap-4 auto-cols-fr px-6 my-16">
    <div class="grid gap-10">
      <div class="font-bold text-6xl">
        <h1>Let Your Creativity</h1>
        <h1>And Ideas</h1>
        <h1>Reign Supreme</h1>
      </div>
      <div class="w-5/6 bg-black text-white grid gap-4 py-8 px-4 rounded-lg italic">
        <div class="font-bold text-4xl">
          <h2>The Ultimate One Stop Shop For Publishing Blogs!!</h2>
        </div>
        <div>
          <button class="text-xl bg-white text-black hover:bg-green-400 hover:text-black px-6 py-3 rounded-full font-bold" data-register>Sign Up And Login</button>
          </div>
        <div class="font-merriweather font-bold underline text-base">
          <p>Sign Up Today And Start Publishing your Blogs</p>
          <p>For FREE!!!</p>
        </div>
      </div>
    </div>
    <div class="grid place-items-center">
      <img class="w-full aspect-auto" src="{{ Vite::asset('resources/images/hero-art.png') }}" alt="">
    </div>
  </div>
</section>