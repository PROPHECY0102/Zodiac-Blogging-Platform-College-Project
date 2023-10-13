<x-dashboardLayout>
  <section class="w-3/4 grid bg-blue-950 rounded-lg text-white pb-8">
    <div class="border-l-8 border-yellow-500 py-4 px-6 flex justify-between items-center">
      <h1 class="font-bold text-xl">Manage Blogposts</h1>
    </div>
    <div class="grid grid-flow-col grid-cols-[0.25fr_0.25fr_1fr_1fr_2fr_2fr_2fr_2fr_0.5_0.5] border-y-2 border-white gap-2 mx-2 text-sm">
      <p class="px-4 py-2">ID</p>
      <p class="px-4 py-2">User_ID</p>
      <p class="px-4 py-2">Blogpost Title</p>
      <p class="px-4 py-2">Categories</p>
      <p class="px-4 py-2">Image Path</p>
      <p class="px-4 py-2">Content</p>
      <p class="px-4 py-2">Created_at</p>
      <div></div>
      <div></div>
    </div>
    @foreach ($blogposts as $blogpost)
      <div class="grid grid-flow-col items-center grid-cols-[0.25fr_0.25fr_1fr_1fr_2fr_2fr_2fr_2fr_0.5_0.5] border-b-2 border-white gap-2 mx-2 text-sm">
      <p class="px-4 py-2">{{$blogpost->id}}</p>
      <p class="px-4 py-2">{{$blogpost->user_id}}</p>
      <p class="px-4 py-2 overflow-x-scroll">{{$blogpost->title}}</p>
      <p class="px-4 py-2 overflow-x-scroll">
        @foreach ($blogpost->categories as $cat)
            <span>{{$cat->name}}</span>
        @endforeach
      </p>
      <p class="px-4 py-2 overflow-x-scroll">{{$blogpost->image}}</p>
      <p class="px-4 py-2 overflow-x-scroll overflow-y-scroll">{{$blogpost->content}}</p>
      <p class="px-4 py-2 overflow-x-scroll">{{$blogpost->created_at}}</p>
      <a href="/dashboard/blogposts/edit/{{$blogpost->id}}">Edit</a>
      <a href="/dashboard/blogposts/delete/{{$blogpost->id}}">Delete</a>
      </div>
    @endforeach
  </section>
  <div class="m-2 p-4 w-3/4">
    {{$blogposts->links("vendor.pagination.tailwind")}}
  </div>
</x-dashboardLayout>