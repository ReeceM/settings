@extends('settings::layouts.app') 
@section('title', __(config('app.name') . ' < Create Settings'))

@section('content')
    <section class="section">
        <div class="container is-fluid">
            <div class="columns is-centered">
                <div class="column box" style="overflow-x: scroll">
                    <nav class="level is-mobile">
                        <div class="level-left">
                            <div class="level-item">
                                <a href="{{ route('settings.index') }}" class="md-button is-info">Back</a>
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="level-item">
                                <h1 class="title">View and Edit Setting</h1>
                            </div>
                        </div>
                    </nav>
                    <hr>
                    <div class="columns is-centered">
                        <div class="column is-7">
                            <form action="{{ route('settings.update', $setting->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                {{-- Key setting value --}}
                                <div class="field">
                                    <p class="control">
                                        <label for="key" class="label">Setting Key</label>
                                        <input type="text" class="input" value="{{ $setting->key }}" id="key" name="key">
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
                                        <div id="editor" v-pre>
                                            <json-editor inline-template>
                                                <div v-if="visible">
                                                    <vue-prism-editor language="json" v-model="code" :lineNumbers="true"></vue-prism-editor>
                                                    <input v-model="cleanCode" id="value" name="value" type="text" class="input" style="display:none;">
                                                </div>
                                                <div v-else>
                                                    <textarea class="textarea" id="value" name="value">{{ $setting->value }}</textarea>
                                                </div>
                                            </json-editor>
                                        </div>                                     
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
                                            <select name="type" id="type" onchange="updateSelection()">
                                                <option {{$setting->type == 'STRING' ? 'selected' : ''}} value="STRING" >String</option>
                                                <option {{$setting->type == 'JSON' ? 'selected' : ''}} value="JSON" >JSON</option>
                                                <option {{$setting->type == 'BOOL' ? 'selected' : ''}} value="BOOL" >Boolean</option>
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
                                    <div class="level-left">
                                        <p class="level-item">
                                            <button class="md-button is-danger" ondblclick="deleteSetting({{ $setting }})">Delete</button>
                                        </p>
                                    </div>
                                    <div class="level-right">
                                        <div class="level-item">
                                            <div class="field is-grouped">
                                                <p class="control">

                                                    <a href="{{ route('settings.index') }}" class="md-button">Cancel</a>
                                                </p>
                                                <p class="control">
                                                    <button class="md-button is-primary">Save</button>
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
                    $settings.axios.delete('/settings/' + _setting.id).then(response => {
                        if(response.status == 200) {
                            swal(`Poof! Your Setting\n ${_setting.key} \n has been deleted!`, { icon: "success" })
                            .then(r => {
                                location.href = "{{ route('settings.index') }}"
                            });
                        }
                    })
                } else {
                    swal("Your setting is safe!", { icon: 'info' });
                }
            });
        }
    </script>
        <!-- use -->
    <script>
        $settings.Vue.component('vue-prism-editor', VuePrismEditor)

        let settingType = {
            init: "{{$setting->type}}",
            listener(event){},
            set type(value){
                this.init = value
                this.listener(value)
            },
            get type(){
                return this.init
            },
            registerListener(listener){
                this.listener = listener
            }
        }

        function updateSelection(e) {
            settingType.type = document.getElementById('type').value
        }

        $settings.Vue.component('json-editor', {
            data() {
                return {
                    code: @json($setting->value),
                    visible: false,
                    cleanCode: @json($setting->value)
                }
            },
            mounted() {
                this.code = JSON.stringify(JSON.parse(this.code), null, 4);
                this.visible = settingType.init == 'JSON'
                settingType.registerListener((e) => {
                    console.log(e)
                    this.visible = e == 'JSON'
                })
            },
            watch: {
                code: {
                    deep: true,
                    immediate: true,
                    handler: function (val, oldVal) {
                        this.cleanCode = JSON.stringify(JSON.parse(val))
                    }
                },
            },
        })
        
        new $settings.Vue({
            el: '#editor',
        })
    </script>


@endpush