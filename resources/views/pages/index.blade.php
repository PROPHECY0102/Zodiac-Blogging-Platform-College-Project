<x-layout>
  @auth
    <x-welcome />
    @else
    <x-hero />
    <x-features />
  @endauth
  <x-blogs :blogposts="$blogposts" :categories="$categories"/>
</x-layout>