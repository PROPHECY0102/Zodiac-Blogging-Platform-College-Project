@php
    $blogContents = json_decode($blogData->content);
@endphp

<x-layout>
  <section class="w-full grid place-items-center my-12">
    <div class="w-3/4 grid place-items-center">
      <div class="w-2/3 grid place-items-center gap-4">
        <h1 class="place-self-start text-2xl">Preview Mode ✦</h1>
        <h1 class="text-5xl leading-[3.5rem] font-bold font-merriweather break-words">{{$blogData->title}}</h1>
        <div class="w-full flex justify-between py-2 border-y-2 border-black">
          <div class="flex gap-4 items-center">
            <img class="w-10 aspect-auto" src="{{Vite::asset("resources/images/profile.png")}}" alt="profile">
            <div class="grid font-medium">
              <p>Author :</p>
              <a href="/profile/{{$blogData->user->id}}" class="underline font-bold">{{$blogData->user->username}}</a>
            </div>
          </div>
          <div class="grid font-medium border-l-2 border-black pl-4">
            <p>Publish On :</p>
            <p id="preview-date-display" class="font-bold pr-12">null</p>
          </div>
        </div>
        <div class="w-full">
          <p class="font-bold text-xl">Categories :</p>
          <div class="flex gap-2">
            @foreach ($blogData->categories as $category)
              @if ($loop->last)
                <p class="text-xl font-medium">{{$category->name}}</p>
              @else
                <p class="text-xl font-medium">{{$category->name}} |</p>
              @endif
            @endforeach
          </div>
        </div>
        <img src="{{asset("storage/" . $blogData->image) ?? asset("storage/" . $blogData->categories[0]->default_image)  }}" alt="Blogpost image" class="w-full aspect-auto">
        <div class="w-full grid gap-10 py-4">
          @foreach ($blogContents as $paragraph)
          @if ($loop->first)
            <p class="text-justify text-2xl font-merriweather first-letter:text-5xl first-letter:float-left first-letter:font-bold first-letter:mr-4">{{$paragraph}}</p>
          @else
            <p class="text-justify text-xl font-merriweather">{{$paragraph}}</p>
          @endif
          @endforeach
        </div>
        <div class="w-full flex justify-end items-center font-bold text-xl gap-4">
          <button id="preview-discard" class="bg-red-500 hover:bg-red-400 border-b-8 border-red-700 hover:border-b-4 py-2 px-4">
            Discard
          </button>
          <button id="preview-edit" class="bg-orange-500 hover:bg-orange-400 border-b-8 border-orange-700 hover:border-b-4 py-2 px-4">
            Edit 
          </button>
          <button id="preview-submit" class="bg-green-500 hover:bg-green-400 border-b-8 border-green-700 hover:border-b-4 py-2 px-4">
            Publish
          </button>
        </div>
      </div>
    </div>
  </section>
</x-layout>