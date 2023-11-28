{{-- Page for revising Blogpost before submitting it publicly --}}
<x-layout>
  <script>
    window.editMode = true;
    window.blogData = @json($blogData);
    window.selectedCategories = @json($selectedCategories);

  </script>
  <section class="w-full grid place-items-center mb-12 relative" data-edit-mode>
    <div class="w-3/4 grid">
      <h1 class="text-2xl font-bold py-4">
        ZODIAC's Blog Editor Panel
      </h1>
      {{-- Handle using AXIOS javascript --}}
      <form action="/blogposts/preview" method="POST" enctype="multipart/form-data" class="w-full grid gap-8" id="blog-form">
        @csrf
        <div class="grid">
          <label for="title" class="text-2xl font-bold px-6">Title</label>
          <div class="bg-slate-100 px-6 py-2 rounded-md text-lg font-bold">
            <input id="blog-title-form" type="text" name="title" placeholder="Type Here..." class="w-full bg-transparent py-4 border-b-4 border-slate-200 focus-visible:outline-none focus-visible:border-slate-400">
          </div>
        </div>
        <div class="grid">
          <label for="image" class="text-2xl font-bold px-6">Image Banner (Please use the format of PNG or JPEG) Optional</label>
          <div class="bg-slate-100 px-6 py-2 rounded-md text-lg font-bold" id="file-input-container">
            <div class="flex items-center gap-2">
              <button class="py-2 px-4 rounded-full bg-slate-300 hover:bg-black hover:text-white" id="choose-file">Choose File</button>
              <p id="result-file">Please Re-attach the image you had used</p>
              <input type="file" name="image" accept=".png, .jpg" id="blog-file-input" class="bg-transparent p-4 rounded-md border-2 border-slate-200 invisible">
            </div>
          </div>
        </div>
        <div class="grid">
          <h1 class="text-2xl font-bold px-6">What is your Blog is About?</h1>
          <label for="categoriesList" class="text-2xl font-bold px-6">Categories Tags (Maximum up to 5).</label>
          <div class="bg-slate-100 px-6 py-4 rounded-md text-lg font-bold overflow-x-scroll">
            <div id="category-choice-container" class="flex flex-wrap gap-3">
              @foreach ($categories as $category)
                  <button class="category-choice" data-category="{{$category->id}}">{{$category->name}}</button>
              @endforeach
            </div>
            <div class="text-lg font-bold mt-4">
              <p id="categories-name-display">No Categories Selected. It will be a general blogpost by default</p>
            </div>
          </div>
        </div>
        <div class="grid" id="blog-content-container">
          <label for="content" class="text-2xl font-bold px-6">Blog Content. Total paragraphs count: <span id="paragraph-counter">1</span></label>
          <div class="bg-slate-100 px-6 py-4 rounded-md text-xl font-bold mb-6 grid" data-p-container="1">
            <label data-p-label="1">Paragraph 1</label>
            <span data-p-form="1" contenteditable="true" class="p-4 border-b-4 border-slate-300 resize-y focus-visible:outline-none focus-visible:border-slate-400 break-words">Type Here...</span>
          </div>
        </div>
      </form>
    </div>
    <div class="fixed right-[68%] top-[93%] flex gap-4 font-bold text-xl items-center bg-slate-200 rounded-md px-4 py-2">
      <p>Add New Paragraph</p>
      <button id="add" class="bg-green-500 hover:bg-green-400 w-10 h-10 border-b-8 border-green-700 hover:border-b-4">+</button>
      <button id="subtract" class="bg-red-500 hover:bg-red-400 w-10 h-10 border-b-8 border-red-700 hover:border-b-4">-</button>
    </div>
    <div class="fixed left-[76%] top-[93%] flex gap-4 font-bold text-xl items-cente">
      <button id="blog-submit-preview" class="bg-green-500 hover:bg-green-400 border-b-8 border-green-700 hover:border-b-4 py-2 px-4">Preview Blog -></button>
    </div>
  </section>
</x-layout>