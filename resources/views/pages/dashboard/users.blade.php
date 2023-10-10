<x-dashboardLayout>
  <section class="w-3/4 grid bg-blue-950 rounded-lg text-white pb-8">
    <h1 class="border-l-8 border-blue-500 font-bold text-xl py-4 px-6">Manage Users</h1>
    <div class="grid grid-flow-col grid-cols-[0.5fr_2fr_0.5fr_2fr_2fr_0.5fr_0.5fr] border-y-2 border-white gap-2 mx-2 text-sm">
      <p class="px-4 py-2">ID</p>
      <p class="px-4 py-2">Username</p>
      <p class="px-4 py-2">Role</p>
      <p class="px-4 py-2">Email</p>
      <p class="px-4 py-2">Created At</p>
      <div></div>
      <div></div>
    </div>
    @foreach ($users as $user)
      <div class="grid grid-flow-col items-center grid-cols-[0.5fr_2fr_0.5fr_2fr_2fr_0.5fr_0.5fr] border-b-2 border-white gap-2 mx-2 text-sm">
      <p class="px-4 py-2">{{$user->id}}</p>
      <p class="px-4 py-2">{{$user->username}}</p>
      <p class="px-4 py-2">{{$user->role}}</p>
      <p class="px-4 py-2">{{$user->email}}</p>
      <p class="px-4 py-2">{{$user->created_at}}</p>
      @if (auth()->user()->id !== $user->id)
      <a href="/dashboard/users/edit/{{$user->id}}">Edit</a>
      <a href="/dashboard/users/delete/{{$user->id}}">Delete</a>
      @endif
      </div>
    @endforeach
  </section>
  <div class="m-2 p-4 w-3/4">
    {{$users->links("vendor.pagination.tailwind")}}
  </div>
</x-dashboardLayout>