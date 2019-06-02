@extends('settings::layouts.app') 

@section('title', __(config('app.name') . ' < System Settings '))

@section('content')
    <section class="flex p-24">
        <div class="container mx-auto">
            <div class="flex justify-center">
                <div class="rounded shadow w-full sm:p-4 lg:p-12 md:p-6 bg-white" style="overflow-x: scroll">
                    <nav class="level is-mobile">
                        <div class="flex justify-between">
                            <div class="level-item">
                                <a href="{{ route('settings.create') }}" class="md-button is-info is-small">New Setting</a>
                            </div>
                            <div class="level-item">
                                <a href="{{ route('settings.refresh') }}" class="md-button is-link is-small">
                                    <span class="icon is-small"><i class="fa fa-sync"></i></span>
                                </a>
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="level-item">
                                <h1 class="title">Settings </h1>
                            </div>
                        </div>
                    </nav>
                    <hr class="border-2 border-indigo-100 mb-5">
                    @if($paginator->count() > 0)
                        <table class="table w-full">
                            <thead>
                                <tr class="table-row border-b-2 border-blue-200">
                                    <th>Key</th>
                                    <th>Value</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paginator as $setting)
                                <tr class="table-row hover:bg-gray-200 border-b-2 border-gray-300 {{ $loop->odd ? 'bg-white' : 'bg-gray-100' }}">
                                    <td class="table-cell py-3 px-3 text-center">
                                        {{ $setting->key }}
                                    </td>
                                    <td class="table-cell py-3 px-3 text-center">
                                        @if ($setting->type == 'JSON')
                                            <pre><code class="language-json" id="value" name="value">{{ json_encode(json_decode($setting->value), JSON_PRETTY_PRINT) }}</code></pre>
                                        @else
                                            <pre>{{ $setting->value }}</pre>
                                        @endif
                                    </td>
                                    <td class="table-cell py-3 px-3 text-center">
                                        <span class="badge is-info">{{ $setting->type }}</span>
                                    </td>
                                    <td class="table-cell py-3 px-3 text-center">
                                        <div class="flex inline-flex justify-center">
                                            <p class="flex pr-3">
                                                <a class="md-button is-info is-small" href="{{ route('settings.show', $setting->id) }}">View</a>
                                            </p>
                                            <p class="flex">
                                                <button class="md-button is-danger is-small" onclick="deleteSetting({{$setting}})">Delete</button>
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
                            {{$paginator->links("pagination::bootstrap-4")}}
                        </nav>
                    @endif
                    @else
                    <div class="flex mx-auto w-full justify-center">
                        <div class="bg-blue-100 border-t-4 border-blue-500 rounded-b text-blue-900 px-4 py-3 shadow-md" role="alert">
                            <div class="flex">
                                <div class="py-1"><svg class="fill-current h-6 w-6 text-blue-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                                <div>
                                    <p class="font-bold">You have no settings.</p>
                                    <p class="text-sm">Use the new setting button to add one.</p>
                                    <p clas=""><a href="{{ route('settings.create') }}" class="md-button is-info is-small">New Setting</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
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
                    $settings.axios.delete('/system/settings/' + _setting.id).then(response => {
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
