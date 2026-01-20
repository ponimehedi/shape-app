<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{   
    // get
    public function index() 
    {
        return response()->json([
            'logo' => asset('storage/'.settings('logo')),
            'siteName' => settings('siteName'),
            'slider1' => asset('storage/'.settings('slider1')),
            'slider2' => asset('storage/'.settings('slider2')),
            'slider3' => asset('storage/'.settings('slider3')),
        ]);
    } 
    // create 
    public function store(Request $request)
    {
        try{

            $validated =  $request->validate([

                'logo'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'siteName' => 'nullable|string',
                'slider1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'slider2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'slider3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]); 

            //if logo exixts
            if($request->hasFile('logo'))
            {
                $oldIcon = settings('logo');

                if($oldIcon && Storage::disk('public')->exists($oldIcon))
                {
                    Storage::disk('public')->delete($oldIcon);
                }

                $iconPath = $request->file('logo')->store('settings', 'public');
                $validated['logo'] = $iconPath;
            }

            // slider1 img if exists
            if($request->hasFile('slider1'))
            {
                $oldSlider1 = settings('slider1'); 

                if($oldSlider1 && Storage::disk('public')->exists($oldSlider1)) 
                {
                    Storage::disk('public')->delete($oldSlider1);
                }

                $iconPath = $request->file('slider1')->store('settings', 'public');
                $validated['slider1'] = $iconPath;
            } 


            // slider2 img if exists 
            if($request->hasFile('slider2'))
            {
                $oldSlider2 = settings('slider2'); 

                if($oldSlider2 && Storage::disk('public')->exists($oldSlider2)) 
                {
                    Storage::disk('public')->delete($oldSlider2);
                }

                $iconPath = $request->file('slider2')->store('settings', 'public');
                $validated['slider2'] = $iconPath;
            } 

            // slider3 img if exists 
            if($request->hasFile('slider3'))
            {
                $oldSlider3 = settings('slider3'); 

                if($oldSlider3 && Storage::disk('public')->exists($oldSlider3)) 
                {
                    Storage::disk('public')->delete($oldSlider3);
                }

                $iconPath = $request->file('slider3')->store('settings', 'public');
                $validated['slider3'] = $iconPath;
            } 
                    
            foreach ($validated as $key => $value)
            {
                if ($value !== null)
                {
                    settings()->set($key, $value);
                }
            } 
            return response()->json([
                'success' => true,
                'message' => 'settings updated successfully',
                'data' => $validated
            ]);
        } catch(ValidationException $e){
            return response()->json([
                'errors' => $e->errors(),
                'message' => $e->getMessages()
          ]);
        }
    }
}

