@php
    $blogContents = json_decode($blogpost->content);
@endphp

<x-layout>
  <section class="w-full grid place-items-center my-12">
    <div class="w-3/4 grid place-items-center">
      <div class="w-2/3 grid place-items-center gap-4">
        <h1 class="text-5xl leading-[3.5rem] font-bold font-merriweather break-words">{{$blogpost->title}}</h1>
        <div class="w-full flex justify-between py-2 border-y-2 border-black">
          <div class="flex gap-4 items-center">
            <img class="w-10 aspect-auto" src="{{Vite::asset("resources/images/profile.png")}}" alt="profile">
            <div class="grid font-medium">
              <p>Author :</p>
              <a href="/profile/{{$blogpost->user->id}}" class="underline font-bold">{{$blogpost->user->username}}</a>
            </div>
            @auth
            @if (auth()->user()->id !== $blogpost->user->id)
            <div>
              <button class="px-4 py-2 text-white bg-black font-bold hover:scale-95 hover:bg-slate-300 hover:text-black">Follow</button>
            </div>
            @endif
            @endauth
          </div>
          <div class="grid font-medium border-l-2 border-black pl-4">
            <p>Publish On :</p>
            <p id="date-display" class="font-bold pr-12">{{$blogpost->created_at}}</p>
          </div>
        </div>
        <div class="w-full">
          <p class="font-bold text-xl">Categories :</p>
          <div class="flex gap-2">
            @foreach ($blogpost->categories as $category)
            @if ($loop->last)
            <p class="text-xl font-medium">{{$category->name}}</p>
            @else
            <p class="text-xl font-medium">{{$category->name}} |</p>
            @endif
            @endforeach
          </div>
        </div>
        <img src="{{asset("storage/" . $blogpost->image) ?? asset("storage/" . $blogData->categories[0]->default_image)}}" alt="Blogpost image" class="w-full aspect-auto">
        <div class="w-full grid gap-10 py-4">
          @foreach ($blogContents as $paragraph)
            @if ($loop->first)
              <p class="text-justify text-2xl font-merriweather first-letter:text-5xl first-letter:float-left first-letter:font-bold first-letter:mr-4">{{$paragraph}}</p>
            @else
              <p class="text-justify text-xl font-merriweather">{{$paragraph}}</p>
            @endif
          @endforeach
        </div>
      </div>
    </div>
  </section>
</x-layout>