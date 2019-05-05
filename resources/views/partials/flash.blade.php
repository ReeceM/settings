@if(session('settings.flash'))
<section style="position: fixed; right: 1rem; top: 3.2rem; z-index: 999">
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
</section>
@endif
