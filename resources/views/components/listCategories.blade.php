@props(["categories"])

<section class="w-full p-4 bg-slate-200 grid justify-start items-start gap-4 rounded-md">
  <h1 class="text-xl font-bold">Filtered By Categories</h1>
  <div class="flex items-center flex-wrap gap-2">
    @foreach ($categories as $category)
      @if (request()->input("category") == $category->id)
        <button data-seleted-categories id="{{$category->id}}" class="px-4 py-2 bg-black text-white rounded-full font-medium hover:scale-90">
          {{$category->name}}
        </button>
        @else
        <button data-filter-categories id="{{$category->id}}" class="px-4 py-2 bg-slate-300 rounded-full font-medium hover:scale-90">
          {{$category->name}}
        </button>
      @endif
    @endforeach
  </div>
</section>
