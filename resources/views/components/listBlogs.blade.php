@props(['blogposts'])

<section class="w-full grid">
  @if (count($blogposts) == 0)
      <h1 class="text-2xl font-bold">
        No Blogpost Found.
      </h1> 
  @endif
  @foreach ($blogposts as $blogpost)
    <section class="w-full grid grid-cols-[1fr_3fr] py-4 border-b-2 border-gray-400">
      <div class="grid justify-center">
        <a href="/blogposts/{{$blogpost->id}}">
          <img src="{{ asset('storage/' . $blogpost->image) }}" alt="{{$blogpost->title}}">
        </a>
      </div>
      <div class="grid px-4">
        <a href="/blogposts/{{$blogpost->id}}" class="font-bold font-merriweather text-2xl hover:underline">{{$blogpost->title}}</a>
        <div class="flex items-center gap-1 font-bold text-xl">
          <p>Published by: </p>
          <a href="/profile/{{$blogpost->user->id}}" class="hover:underline">{{$blogpost->user->username}}</a>
        </div>
        <div class="w-full flex gap-1">
          <p class="text-md font-bold">Categories :</p>
          <div class="flex gap-2">
            @foreach ($blogpost->categories as $category)
            @if ($loop->last)
            <p class="text-md font-bold">{{$category->name}}</p>
            @else
            <p class="text-md font-bold">{{$category->name}} |</p>
            @endif
            @endforeach
          </div>
        </div>
        <div>
          @php
            $blogpostSnippet = json_decode($blogpost->toArray()["content"], true);
            if (Auth::check()) {
              $blogpostSnippet = json_decode($blogpost->toArray()["content"], true)[0];
            }
          @endphp
          @auth
          <p class="text-sm text-slate-500 overflow-hidden text-ellipsis h-16">
            {{$blogpostSnippet}}
          </p>
            @else
            <p class="text-sm text-slate-500 overflow-hidden text-ellipsis h-32">
            @foreach ($blogpostSnippet as $paragraph)
              {{$paragraph}}
            @endforeach
            </p>
          @endauth
        </div>
      </div>
    </section>
  @endforeach
  <div class="w-full mt-4">
    {{$blogposts->links("vendor.pagination.tailwind")}}
  </div>
</section>