{{-- Search Form input Field Component --}}
<form action="/" class="bg-slate-300 p-2 w-full grid rounded-md">
  <div class="flex bg-slate-100">
    <input type="text" name="search" placeholder="Search Blogs..." class="w-full px-4 py-2" value="{{ request()->has('search') ? request()->input('search') : '' }}">
    <button type="submit" class="px-6">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M11 2a9 9 0 1 0 5.618 16.032l3.675 3.675a1 1 0 0 0 1.414-1.414l-3.675-3.675A9 9 0 0 0 11 2Zm-6 9a6 6 0 1 1 12 0a6 6 0 0 1-12 0Z" clip-rule="evenodd"/></svg>
    </button>
  </div>
</form>