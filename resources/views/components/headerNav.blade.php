<header class="w-full grid place-items-center bg-amber-50">
  <div class="w-4/5 border-b-2 border-solid border-black grid grid-flow-col auto-cols-fr px-4">
    <div class="grid justify-start items-center py-4">
      <div class="flex items-center gap-1">
        <svg class="-translate-y-1" xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 48 48"><ellipse cx="29.465" cy="21.416" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" rx="15.89" ry="6.4" transform="rotate(-74.222 29.465 21.417)"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m33.786 6.125l-8.642 30.583m-.131-21.349l4.114 7.255m-1.743 6.166l6.766-1.77m1.474-3.878H42.5m-37 0h16.939m7.938 9.372H42.5m-37 0h17.914M5.5 41.875h18.419m-2.981-5.437l2.981 5.437l5.438-2.981"/></svg>
        <a href="/" class="font-bold text-4xl">ZODIAC</a>
      </div>
    </div>
    <div class="grid place-items-stretch">
      <nav>
        <ul class="w-full h-full grid grid-flow-col auto-cols-fr font-bold text-lg">
          <li>
            <a class="w-full h-full grid place-items-center hover:text-white hover:bg-black" href="#blog-list" id="tab-link-blogs">
              <span>Blogs</span>
            </a>
          </li>
          <li>
            <a class="w-full h-full grid place-items-center hover:text-white hover:bg-black" href="/categories">
              <span>Categories</span>
            </a>
          </li>
          <li>
            <a class="w-full h-full grid place-items-center hover:text-white hover:bg-black" href="/blogposts/write"
            ><span>Write</span>
            </a>
          </li>
          <li>
            <a class="w-full h-full grid place-items-center hover:text-white hover:bg-black" href="/">
              <span>About Us</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    @auth
      <div class="grid grid-flow-col justify-end items-center relative">
        <button class="grid grid-flow-col place-items-center gap-4" data-profile>
          <div class="w-8">
            <img class="w-full aspect-auto" src="{{Vite::asset("resources/images/profile.png")}}" alt="profile">
          </div>
          <p class="text-xl font-bold">{{auth()->user()->username}}</p>
        </button>
        <button id="btn-profile-dropdown" class="p-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><g transform="translate(0 24) scale(1 -1)"><path fill="currentColor" d="m17 13.41l-4.29-4.24a1 1 0 0 0-1.42 0l-4.24 4.24a1 1 0 0 0 0 1.42a1 1 0 0 0 1.41 0L12 11.29l3.54 3.54a1 1 0 0 0 .7.29a1 1 0 0 0 .71-.29a1 1 0 0 0 .05-1.42Z"/></g></svg>
        </button>
        <div id="profile-dropdown" class="z-10 hidden absolute left-2/3 top-3/4 bg-slate-50 text-slate-400 text-lg font-bold py-4 rounded-md">
          <span class="absolute left-3/4 -top-2 w-0 h-0 border-l-8 border-r-8 border-b-8 border-slate-50 border-x-transparent border-solid"></span>
          <button data-profile class="w-full grid grid-flow-col items-center justify-start hover:bg-slate-200 hover:text-black active:border-l-4 active:border-black py-2">
            <div class="px-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M8 7a4 4 0 1 1 8 0a4 4 0 0 1-8 0Zm0 6a5 5 0 0 0-5 5a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3a5 5 0 0 0-5-5H8Z" clip-rule="evenodd"/></svg>
            </div>
            <p class="pr-8">Profile</p>
          </button>
          @if (auth()->user()->role === "Admin")
              <button data-dashboard class="w-full grid grid-flow-col items-center justify-start hover:bg-slate-200 hover:text-black active:border-l-4 active:border-black py-2">
                <div class="px-4">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill="currentColor" d="M16.95 2.58a4.985 4.985 0 0 1 0 7.07c-1.51 1.51-3.75 1.84-5.59 1.01l-1.87 3.31l-2.99.31L5 18H2l-1-2l7.95-7.69c-.92-1.87-.62-4.18.93-5.73a4.985 4.985 0 0 1 7.07 0zm-2.51 3.79c.74 0 1.33-.6 1.33-1.34a1.33 1.33 0 1 0-2.66 0c0 .74.6 1.34 1.33 1.34z"/></svg>
                </div>
                <p class="pr-8">Dashboard</p>
              </button>
          @endif
          <button data-settings class="w-full grid grid-flow-col items-center justify-start hover:bg-slate-200 hover:text-black active:border-l-4 active:border-black py-2">
            <div class="px-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19.9 12.66a1 1 0 0 1 0-1.32l1.28-1.44a1 1 0 0 0 .12-1.17l-2-3.46a1 1 0 0 0-1.07-.48l-1.88.38a1 1 0 0 1-1.15-.66l-.61-1.83a1 1 0 0 0-.95-.68h-4a1 1 0 0 0-1 .68l-.56 1.83a1 1 0 0 1-1.15.66L5 4.79a1 1 0 0 0-1 .48L2 8.73a1 1 0 0 0 .1 1.17l1.27 1.44a1 1 0 0 1 0 1.32L2.1 14.1a1 1 0 0 0-.1 1.17l2 3.46a1 1 0 0 0 1.07.48l1.88-.38a1 1 0 0 1 1.15.66l.61 1.83a1 1 0 0 0 1 .68h4a1 1 0 0 0 .95-.68l.61-1.83a1 1 0 0 1 1.15-.66l1.88.38a1 1 0 0 0 1.07-.48l2-3.46a1 1 0 0 0-.12-1.17ZM18.41 14l.8.9l-1.28 2.22l-1.18-.24a3 3 0 0 0-3.45 2L12.92 20h-2.56L10 18.86a3 3 0 0 0-3.45-2l-1.18.24l-1.3-2.21l.8-.9a3 3 0 0 0 0-4l-.8-.9l1.28-2.2l1.18.24a3 3 0 0 0 3.45-2L10.36 4h2.56l.38 1.14a3 3 0 0 0 3.45 2l1.18-.24l1.28 2.22l-.8.9a3 3 0 0 0 0 3.98Zm-6.77-6a4 4 0 1 0 4 4a4 4 0 0 0-4-4Zm0 6a2 2 0 1 1 2-2a2 2 0 0 1-2 2Z"/></svg>
            </div>
            <p class="pr-8">Settings</p>
          </button>
          <button data-logout class="w-full grid grid-flow-col items-center justify-start hover:bg-slate-200 hover:text-black active:border-l-4 active:border-black py-2">
            <div class="px-4">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.413-.588T3 19V5q0-.825.588-1.413T5 3h7v2H5v14h7v2H5Zm11-4l-1.375-1.45l2.55-2.55H9v-2h8.175l-2.55-2.55L16 7l5 5l-5 5Z"/></svg>
            </div>
            <p class="pr-8">Logout</p>
          </button>
        </div>
      </div>
      @else
      <div class="grid justify-end items-center">
        <button class="text-base bg-black text-white hover:bg-green-400 hover:text-black px-6 py-4 rounded-full font-bold" data-register>Explore More!!!</button>
      </div>
    @endauth
  </div>
</header>