@extends('system.layouts.app') 

@section('title', __(config('app.name') . ' < System Settings '))

@section('content')
    <section class="section">
        <div class="container is-fluid">
            <div class="columns is-centered">
                <div class="column box" style="overflow-x: scroll">
                    {{-- Notification flash area for settigns --}}
                    @include('settings::partials.flash')
                    {{-- end notification falsh area for settings --}}
                    <nav class="level is-mobile">
                        <div class="level-left">
                            <div class="level-item">
                                <a href="{{ route('system.settings.create') }}" class="md-button is-info is-small">New Setting</a>
                            </div>
                            <div class="level-item">
                                <a href="{{ route('system.settings.refresh') }}" class="md-button is-link is-small">
                                    <b-icon size="is-small" icon="refresh"></b-icon>
                                </a>
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="level-item">
                                <h1 class="title">Settings </h1>
                            </div>
                        </div>
                    </nav>
                    <hr>
                    @if($paginator)
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                            <thead>
                                <tr>
                                    <th>Key</th>
                                    <th>Value</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paginator as $setting)
                                <tr>
                                    <td>
                                        {{ $setting->key }}
                                    </td>
                                    <td >
                                        @if ($setting->type == 'JSON')
                                            <pre><code class="language-json" id="value" name="value">{{ json_encode(json_decode($setting->value), JSON_PRETTY_PRINT) }}</code></pre>
                                        @else
                                            <pre>{{ $setting->value }}</pre>
                                        @endif
                                    </td>
                                    <td class="has-text-centered">
                                        <span class="tag {{ setting('setting.color.' . $setting->type, 'is-link') }}">{{ $setting->type }}</span>
                                    </td>
                                    <td>
                                        <div class="field is-grouped is-grouped-centered">
                                            <p class="control">
                                                <a class="md-button is-info is-small" href="{{ route('system.settings.show', $setting->id) }}">View</a>
                                            </p>
                                            <p class="control">
                                                <button class="md-button is-danger is-small" ondblclick="deleteSetting({{$setting}})">Delete</button>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @if ($paginator->hasPages())
                        <nav class="pagination is-centered" role="navigation" aria-label="pagination">
                            {{-- Previous Page Link --}}
                            {{$paginator->links("settings::partials.pagin")}}
                        </nav>
                    @endif
                    @else
                    <div class="column">
                        <div class="message is-info">
                            <p class="message-body">No Settings ....</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
@push('pre-vue')
<link rel="stylesheet" href="{{ asset('css/prisim.css') }}">
<script src="{{ asset('/js/prisim.js') }}"></script>

@endpush
@push('scripts')
    <script>
        function deleteSetting(_setting) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover - " + _setting.key,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    // delete the setting that is now been confirmed
                    axios.delete('/system/settings/' + _setting.id).then(response => {
                        if(response.status == 200) {
                            swal(`Poof! Your Setting\n ${_setting.key} \n has been deleted!`, { icon: "success" }).then(r => {location.reload()});
                        }
                    }).catch(error => {
                        swal(error.response.message, { icon: 'error' });
                    })
                } else {
                    swal("Your setting is safe!", { icon: 'info' });
                }
            });
        }
    </script>
@endpush
