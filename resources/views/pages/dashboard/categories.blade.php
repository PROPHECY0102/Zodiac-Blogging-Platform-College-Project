<x-dashboardLayout>
  <section class="w-3/4 grid bg-blue-950 rounded-lg text-white pb-8">
    <div class="border-l-8 border-yellow-500 py-4 px-6 flex justify-between items-center">
      <h1 class="font-bold text-xl">Manage Categories</h1>
      <a href="/dashboard/categories/add" class="flex gap-2 group">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="white" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10s10-4.477 10-10S17.523 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
        <span class="group-hover:underline">Add New Categories</span>
      </a>
    </div>
    <div class="grid grid-flow-col grid-cols-[0.5fr_1fr_2fr_2fr_0.5fr_0.5fr] border-y-2 border-white gap-2 mx-2 text-sm">
      <p class="px-4 py-2">ID</p>
      <p class="px-4 py-2">Categories Name</p>
      <p class="px-4 py-2">Default Image Path</p>
      <p class="px-4 py-2">Created At</p>
      <div></div>
      <div></div>
    </div>
    @foreach ($categories as $category)
      <div class="grid grid-flow-col items-center grid-cols-[0.5fr_1fr_2fr_2fr_0.5fr_0.5fr] border-b-2 border-white gap-2 mx-2 text-sm">
      <p class="px-4 py-2">{{$category->id}}</p>
      <p class="px-4 py-2">{{$category->name}}</p>
      <p class="px-4 py-2 overflow-x-scroll">{{$category->default_image}}</p>
      <p class="px-4 py-2">{{$category->created_at}}</p>
      <a href="/dashboard/categories/edit/{{$category->id}}">Edit</a>
      <a href="/dashboard/categories/delete/{{$category->id}}">Delete</a>
      </div>
    @endforeach
  </section>
  <div class="m-2 p-4 w-3/4">
    {{$categories->links("vendor.pagination.tailwind")}}
  </div>
</x-dashboardLayout>