{{-- Displaying Flash Message Popup to notify User --}}
@if (session()->has("message"))
    <div id="flash-message" class="fixed top-2 left-1/2 transform -translate-x-1/2 bg-green-600 text-slate-100 text-lg font-bold px-28 py-4 rounded-md shadow-md transition-all duration-300">
      <p>
        {{session("message")}}
      </p>
    </div>
@endif