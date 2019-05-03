@extends('system.layouts.app') 

@section('title', __(config('app.name') . ' < Create Settings '))

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
                                <a href="{{ route('system.settings.index') }}" class="md-button is-info">Back</a>
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="level-item">
                                <h1 class="title">Create Settings</h1>
                            </div>
                        </div>
                    </nav>
                    <hr>
                    <div class="columns is-centered">
                        <div class="column is-7">
                            <form action="{{ route('system.settings.store') }}" method="post">
                                @csrf
                                {{-- Key setting value --}}
                                <div class="field">
                                    <p class="control">
                                        <label for="key" class="label">Setting Key</label>
                                        <input type="text" class="input" id="key" name="key">
                                        @if ($errors->has('key'))
                                        <p class="help is-danger">
                                            {{ $errors->first('key') }}
                                        </p>
                                        @endif
                                        <small>This is the Key of the setting</small>
                                        
                                    </p>
                                </div>
                                {{-- Setting Value --}}
                                <div class="field">
                                    <p class="control">
                                        <label for="value" class="label">Setting Value</label>
                                        <textarea class="textarea" id="value" name="value">
                                        </textarea>
                                        @if ($errors->has('value'))
                                        <p class="help is-danger">
                                            {{ $errors->first('value') }}
                                        </p>
                                        @endif
                                        <small>This is the Value for the setting</small>
                                        
                                    </p>
                                </div>
                                {{-- Setting Type --}}
                                <div class="field">
                                    <p class="control">
                                        <label for="type" class="label">Setting Type</label>
                                        <div class="select">
                                            <select name="type" id="type">
                                                <option  value="STRING" selected >String</option>
                                                <option value="JSON" >JSON</option>
                                                <option value="BOOL" >Boolean</option>
                                            </select>
                                        </div>
                                        <br>
                                        <small>This is the type of the setting</small>
                                        @if ($errors->has('type'))
                                        <p class="help is-danger">
                                            {{ $errors->first('type') }}
                                        </p>
                                        @endif
                                        
                                    </p>
                                </div>
                                <hr>
                                <nav class="level is-mobile">
                                    <div class="level-left"></div>
                                    <div class="level-right">
                                        <div class="level-item">
                                            <div class="field is-grouped">
                                                <p class="control">

                                                    <a href="{{ route('system.settings.index') }}" class="md-button">Cancel</a>
                                                </p>
                                                <p class="control">
                                                    <button class="md-button is-danger">Save</button>

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </nav>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

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
                            swal(`Poof! Your Setting\n ${_setting.key} \n has been deleted!`, { icon: "success" });
                        }
                    })
                } else {
                    swal("Your setting is safe!", { icon: 'info' });
                }
            });
        }
    </script>
@endpush