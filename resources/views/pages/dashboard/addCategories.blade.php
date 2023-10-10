<x-dashboardLayout>
  <section class="grid bg-blue-950 rounded-lg text-white pb-8">
    <div class="border-l-8 border-yellow-500 py-4 px-6 flex justify-between items-center">
      <h1 class="font-bold text-xl">New Category</h1>
    </div>
    <form action="/dashboard/categories/create" method="POST" enctype="multipart/form-data" class="grid gap-4 px-6 py-4">
      @csrf
      <div class="grid w-full text-lg">
        <label for="name">Category Name</label>
        <input type="text" name="name" value="{{old("name")}}" placeholder="Be Expressive" class="font-medium w-full px-4 py-2 bg-transparent border-b-2 border-slate-500 focus-visible:border-slate-300 focus:outline-none">
        @error("name")
          <p class="text-sm text-red-600 font-medium">{{$message}}</p>
        @enderror
      </div>
      <div class="grid w-full text-lg">
        <label for="default_image">Category Default Image</label>
        <input type="file" name="default_image" class="font-medium w-full px-4 py-2 bg-transparent border-b-2 border-slate-500 focus-visible:border-slate-300 focus:outline-none">
        @error("default_image")
          <p class="text-sm text-red-600 font-medium">{{$message}}</p>
        @enderror
      </div>
      <div class="grid place-items-center mt-4 w-full">
        <button type="submit" class="bg-gray-300 text-black hover:bg-green-400 hover:text-black text-lg px-6 py-4 rounded-full">
          Create Category
        </button>
      </div>
    </form>
  </section>
</x-dashboardLayout>