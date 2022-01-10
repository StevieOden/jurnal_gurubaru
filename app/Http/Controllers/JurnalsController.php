<?php

namespace App\Http\Controllers;

use Storage;
use DateTime;
use Validator;
use App\Models\User;
use App\Models\Jurnals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

class JurnalsController extends Controller
{

    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation { show as traitShow; }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
        //     'kegiatan' =>'required|string'
        //  ]);
        $fields = $request->validate([
            'image' => 'required|image:jpeg,png,jpg,gif,svg',
            'kegiatan' =>'required|string'
         ]);
        //  if ($fields->fails()) {
        //     return 'error';
        //  }
        $environment = env('APP_URL');
         $image = $request->file('image');
         $image_uploaded_path = $image->store('users');
         $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => $image_uploaded_path,
            "mime" => $image->getClientMimeType()
         );
         $dt = date('l, d M Y');
         $user_id = Auth()->user()->id;
         $jurnals = Jurnals::create([
            'user_id' => $user_id,
            'title'=> basename($image_uploaded_path),
            'path' => $environment."/storage/".$image_uploaded_path,
            'tanggal'=> $dt,
            'kegiatan' => $fields['kegiatan'],
        ]);

         return response([
            'id' => $jurnals->id,
            'user_id' => $user_id,
            'tanggal'=> $dt,
            'image'=>[
            'title'=> basename($image_uploaded_path),
            'path' => $environment."/storage/".$image_uploaded_path,
            ],
            'kegiatan' => $fields['kegiatan'],
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // custom logic before
        $content = $this->traitShow($id);
        // cutom logic after
        return $content;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
