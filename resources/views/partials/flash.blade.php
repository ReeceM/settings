@if(session('submit_okay'))
   <div class="notification is-subtle-success animated fadeInDown" style="position: fixed; right: 1rem; top: 5rem; z-index: 999" onclick="this.remove()">
    <span class="delete"></span>
        {{ session('submit_okay')}}
    </div>
@endif
@if(session('submit_error'))
<div class="notification is-subtle-danger animated fadeInDown" style="position: fixed; right: 1rem; top: 5rem; z-index: 999" onclick="this.remove()">
    <span class="delete"></span>
        {{ session('submit_error')}}
    </div>
@endif

@if(null !== session('account'))
<div class="notification is-subtle-danger animated fadeInDown" style="position: fixed; right: 1rem; top: 5rem; z-index: 999" onclick="this.remove()">
        <span class="delete"></span>
    {{ session('account')}}
</div>
@endif 
@if(session('contact_us_ok'))
   <div class="notification is-subtle-success animated fadeInDown" style="position: fixed; right: 1rem; top: 5rem; z-index: 999" onclick="this.remove()">
       <span class="delete"></span>
        {{ session('contact_us_ok')}}
    </div>
@endif
@if(session('contact_us_error'))
   <div class="notification is-subtle-danger animated fadeInDown" style="position: fixed; right: 1rem; top: 5rem; z-index: 999" onclick="this.remove()">
       <span class="delete"></span>
        {{ session('contact_us_error')}}
    </div>
@endif

@if(setting('global.flash'))
<section style="position: fixed; right: 1rem; top: 3.2rem; z-index: 999">
    <div class="tile is-ancestor" >
        <div class="tile is-parent is-vertical">
            @foreach (setting('global.notice') as $key => $notice)
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
@if(session('global.notice'))
    @foreach (session('global.notice') as $key => $notice)
    <div class="notification is-{{$key}} animated fadeInDown"  onclick="this.remove()">
        <span class="delete"></span>
        {{ $notice }}
    </div>
    @endforeach
@endif

@if (cache('delete.restore.user'))
    <div class="notification is-subtle-info animated fadeInDown" id="restore_user" style="position: fixed; left: 1rem; top: 5rem; z-index: 999">
        <form action="{{ route('admin.users.restore', cache('delete.restore.user')->get('user')->id) }}" method="post">
            @csrf
            @method('PATCH')
            You have <span class="countdown">30</span>s to restore the user <b>{{ cache('delete.restore.user')->get('user')->username }}</b> - <button class="md-button is-small">{{ __('Restore') }}</button>
        </form>
    </div>
    @push('scripts')
        <script>
            var eventTime= {{ strtotime(cache('delete.restore.user')->get('time')->addSeconds(30)) * 1000 }}; // Timestamp - Sun, 21 Apr 2013 13:00:00 GMT
            var currentTime = {{ strtotime(now()) * 1000 }}; // Timestamp - Sun, 21 Apr 2013 12:30:00 GMT
            var diffTime = eventTime - currentTime;
            var duration = moment.duration(diffTime, 'milliseconds');
            var interval = 1000;

            let intervalId = setInterval(function(){
                                duration = moment.duration(duration - interval, 'milliseconds');
                                if(duration.seconds() < 0) {
                                    $("#restore_user").remove();
                                    clearInterval(intervalId);
                                } 
                                $('.countdown').text(duration.seconds());
                            }, interval);
        </script>
    @endpush
@endif
