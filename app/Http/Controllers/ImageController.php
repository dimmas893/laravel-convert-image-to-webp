<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

use Intervention\Image\ImageManagerStatic;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index(): View

    {

        return view('imageUpload');
    }



    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request): RedirectResponse

    {

        $this->validate($request, [

            'image' => [
                'required',

                'image',

                'mimes:jpg,png,jpeg,gif,svg',

                'max:2048'
            ],

        ]);



        $input = $request->all();

        $image  = ImageManagerStatic::make($request->file('image'))->encode('webp');



        $imageName = Str::random() . '.webp';



        /*

            Save Image using Storage facade

            $path = Storage::disk('public')->put('images/'. $imageName, $image);

        */



        $image->save(public_path('images/' . $imageName));

        $input['image_name'] = $imageName;



        /*

            Store Image to Database

        */



        return back()

            ->with('success', 'Image Upload successful')

            ->with('imageName', $imageName);
    }
}
