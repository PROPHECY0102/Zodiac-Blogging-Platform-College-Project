@props(["categories"])

<section class="w-full p-4 bg-slate-200 grid justify-start items-start gap-4 rounded-md">
  <h1 class="text-xl font-bold">Filtered By Categories</h1>
  <div class="flex items-center flex-wrap gap-2">
    @if (count($categories) == 0)
        <h1 class="text-2xl font-bold">
          No Categories Found.
        </h1>
    @endif
    @php
    // Filtering Multiple Categories Doesn't Work I had been debugging for two weeks straight and I had to move on
    // Filtering only a Single Category works as expected
        $categoriesParam = request()->input("category");
        $categoriesArray = explode(",", $categoriesParam);
        $selectedCategories = [];
        foreach ($categories as $singleCategory) {
          foreach ($categoriesArray as $selectedCategory) {
            if ($selectedCategory == $singleCategory->id) {
              array_push($selectedCategories, $singleCategory);
            }
          }
        }
        if (!empty($selectedCategories)) {
          $unselectedCategories = array_filter($categories->toArray(), function ($cat) use ($selectedCategories) {
          foreach ($selectedCategories as $selectedCat) {
            if ($cat["id"] !== $selectedCat->id) {
              return true;
            }
          }
          return false;
          });
        } else {
          $unselectedCategories = $categories->toArray();
        }
    @endphp
      @foreach ($selectedCategories as $category)
        <button data-seleted-categories id="{{$category->id}}" class="px-4 py-2 bg-black text-white rounded-full font-medium hover:scale-90">
          {{$category->name}}
        </button>
      @endforeach
      @foreach ($unselectedCategories as $category)
        <button data-filter-categories id="{{$category["id"]}}" class="px-4 py-2 bg-slate-300 rounded-full font-medium hover:scale-90">
          {{$category["name"]}}
        </button> 
      @endforeach
  </div>
</section>
