@props(["blogposts", "categories"])

@auth
<section class="w-full mt-4 grid place-items-center">
  <div class="w-3/4 grid items-start grid-cols-[3fr_1fr] gap-4">
    <div class="grid place-items-center w-full gap-4">
      <x-searchBar />
        <div class="w-full flex gap-4 justify-start items-center font-bold">
          <button class="bg-slate-100 rounded-full py-2 px-4 hover:bg-black hover:text-white" data-category-selected data-filterBy>All</button>
          <button class="bg-slate-100 rounded-full py-2 px-4 hover:bg-black hover:text-white" data-filterBy>Followed Categories</button>
          <button class="bg-slate-100 rounded-full py-2 px-4 hover:bg-black hover:text-white" data-filterBy>Followed Bloggers</button>
        </div>
        <h1 class="place-self-start text-2xl font-bold mt-4">
          Latest Blogs ✦
        </h1>
      <x-listBlogs :blogposts="$blogposts"/>
    </div>
    <x-listCategories :categories="$categories"/>
  </div>
</section>
@else
<section class="w-full mt-20 grid place-items-center">
  <h1 class="py-4 font-bold text-4xl" id="blog-list">
    Blogs On ZODIAC
  </h1>
  <div class="w-3/4 grid place-items-center">
    <x-searchBar />
    <h1 class="place-self-start text-2xl font-bold mt-4">
      Latest Blogs ✦
    </h1>
    <x-listBlogs :blogposts="$blogposts"/>
  </div>
</section>
@endauth