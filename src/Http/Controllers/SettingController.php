<?php

namespace ReeceM\Settings\Http\Controllers;

use ReeceM\Settings\Setting;
use ReeceM\Settings\Http\Requests\SettingsRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort_unless(Gate::check('settings.admin', request()->user()), 403);
        $paginator = Setting::paginate(15);
        return view('settings::index', compact('paginator'));
    }
    
    /**
     * Refresh the index
     */
    public function refresh()
    {
        if(Cache::get('refresh:settings:cache', false)) {
            session()->flash('settings.flash.warning', __('Refresh Later Please'));
            return redirect()->route('settings.index');
        }
        try{
            // refresh 
            Cache::put('refresh:settings:cache', true , now()->addSeconds(600));
            setting()->cache();
            
            session()->flash('settings.flash.success', __('Cache Refreshed okay'));
        } catch(\Exception $e) {
            session()->flash('settings.flash.danger', __('Unable to Refresh The Cache'));
        }

        return redirect()->route('settings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        abort_unless(Gate::check('settings.admin', request()->user()), 403);
        return view('settings::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SettingsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingsRequest $request)
    {
        //
        $result = setting()->create($request->toArray());
        
        if($result) {
            session()->flash('settings.flash.success', __('Setting :key Created Successfully', $request->all()));

            return redirect()->route('settings.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \ReeceM\Settings\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
        abort_unless(Gate::check('settings.admin', request()->user()), 403);
        return view('settings::edit', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \ReeceM\Settings\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
        abort_unless(Gate::check('settings.admin', request()->user()), 403);
        return view('settings::edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SettingsRequest  $request
     * @param  \ReeceM\Settings\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(SettingsRequest $request, Setting $setting)
    {
        //
        if($setting->update($request->toArray()))
        {
            setting()->cache();
            return view('settings::edit', compact('setting'));
        }
        session()->flash('settings.flash.danger', 'Unable To Ubdate Setting');
        return view('settings::edit', compact('setting'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \ReeceM\Settings\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
        abort_unless(Gate::check('settings.admin', request()->user()), 403);
        if($setting->delete())
        {
            setting()->cache();
            return response('Setting Deleted', 200);
        }
        return response(['message' => 'Unable to Delete the setting'], 500);
    }
}
