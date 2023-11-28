{{-- Login Page --}}
<x-layoutAlt>
  <section class="grid place-items-center px-6 py-10 bg-slate-100 rounded-md gap-6">
    <div class="text-center font-bold">
      <h1 class="text-3xl mb-2">Login to ZODIAC</h1>
    </div>
    <form class="w-full grid place-items-center gap-4 px-12" action="/login" method="POST">
      @csrf
      <div class="grid w-full text-lg">
        <label class="" for="username">Username</label>
        <input type="text" name="username" value="{{old("username")}}" class="w-full px-4 py-2 bg-transparent border-b-2 border-slate-300 focus-visible:bg-slate-200 focus-visible:border-slate-500 focus:outline-none rounded-md">
        @error("username")
          <p class="text-sm text-red-600 font-medium">{{$message}}</p>
        @enderror
      </div>
      <div class="grid w-full text-lg">
        <label class="" for="password">Password</label>
        <input type="password" name="password" class="w-full px-4 py-2 bg-transparent border-b-2 border-slate-300 focus-visible:bg-slate-200 focus-visible:border-slate-500 focus:outline-none rounded-md">
      </div>
      <div class="grid place-items-center mt-4 w-full">
        <button type="submit" class="bg-black text-white hover:bg-green-400 hover:text-black text-lg px-6 py-4 rounded-full">
          Login
        </button>
      </div>
    </form>
  </section>
  <p class="text-lg">
    Don't have an account? Sign up <a class="underline text-blue-500" href="/register">Here</a>
  </p>
</x-layoutAlt>