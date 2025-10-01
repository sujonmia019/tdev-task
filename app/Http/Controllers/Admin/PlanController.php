<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Requests\PlanRequest;
use App\Http\Controllers\Controller;
use App\Traits\UploadAble;

class PlanController extends Controller
{
    use UploadAble;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['plans'] = Plan::latest()->paginate(10);
        return view('plan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plan.update-or-store');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateOrCreate(PlanRequest $request)
    {
        $collection = collect($request->validated());
        $image = $request->old_image;
        if($request->hasFile('image')){
            $image = $this->uploadFile($request->file('image'), PLAN_IMAGE_PATH);
        }
        $collection = $collection->merge(compact('image'));
        Plan::updateOrCreate(['id'=>$request->update_id], $collection->all());
        $msg        = $request->update_id ? 'Plan has been updated successfull.' : 'Plan has been saaved successfull.';
        return redirect()->route('admin.plans.index')->with('success',$msg);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['plan'] = Plan::findOrFail($id);
        return view('plan.update-or-store', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Plan::findOrFail($id);
        $this->deleteFile($data->image);
        $data->delete();

        return back()->with('success','Plan has been deleted successfull.');
    }
}
