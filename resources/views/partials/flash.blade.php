@if(session('settings.flash'))
{{-- <section style="position: fixed; right: 1rem; top: 3.2rem; z-index: 999">
    <div class="tile is-ancestor" >
        <div class="tile is-parent is-vertical">
            @foreach(session('settings.flash') as $key => $notice)
            <div class="tile is-child">
                <div class="notification is-subtle-{{$key}} animated fadeInDown"  onclick="this.remove()">
                    <span class="delete"></span>
                    {{ $notice }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section> --}}
@php
$colors = [
    'warning' => 'bg-orange-100 text-orange-700 border-orange-500',
    'success' => 'bg-green-100 text-green-700 border-green-500',
    'info' => 'bg-blue-100 text-blue-700 border-blue-500',
    'danger' => 'bg-red-100 text-red-700 border-red-500',
    'primary' => 'bg-teal-100 text-teal-700 border-teal-500',
    'link' => 'bg-blue-100 text-blue-700 border-blue-500',
];
@endphp
<section class="z-50 fixed right-0 mt-10 mr-10">
    <div class="flex flex-col" >
        @foreach(session('settings.flash') as $key => $notice)
        <div class="flex pb-4 w-40">
            <div class="flash {{ Arr::get($colors, $key) }} border-l-4 p-4 shadow-lg break-words animated fadeInDown" role="alert">
                <svg onclick="this.parentElement.remove()" class="float-right  cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <p class="font-bold">{{ ucwords($key) }}</p>
                <p>{{ $notice }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif
