<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManageTime;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ManageTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.manage_time.index');
    }

    /**
     * get schedule list.
     */
    public function scheduleList(Request $request)
    {
        $schedules = ManageTime::query()
            ->when(!empty($request->search['value']), function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search['value'] . '%')
                    ->orWhere('time',$request->search['value']);
            });

        return DataTables::of($schedules)
            ->addColumn('sl', function () {
                static  $count = 0;
                return ++$count;
            })
            ->addColumn('name', function ($schedule) {
                return $schedule->name;
            })
            ->addColumn('duration', function ($schedule) {
                return   trans('Time').': '. trans($schedule->time).' '. trans('Hours');
            })
            ->addColumn('action', function ($schedule) {
                if (adminAccessRoute(config('role.schedule.access.edit'))){
                    $html = '<a class="btn btn-white btn-sm edit_btn" href="javascript:void(0)"
                            data-bs-toggle="modal" data-bs-target="#editModal"
                            data-name="'.$schedule->name.'"
                            data-time="'.$schedule->time.'"
                            data-route="'.route('admin.schedule.update',$schedule->id).'"
                        >
                    <i class="fa-thin fa-pen-to-square"></i> Edit
                  </a>';

                    return $html;
                }
                return '';

            })
            ->rawColumns(['sl','name','duration','action'])
            ->make(true);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reqData = $request->all();
        $request->validate([
            'name' => 'required|string',
            'time' => 'required|integer',
        ], [
            'name.required' => 'Name is required',
            'time.required' => 'Time is required'
        ]);
        $data = ManageTime::firstOrNew(['time' => $reqData['time']]);
        $data->name = $reqData['name'];
        $data->save();
        return back()->with('success', 'Added Successfully.');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reqData = $request->all();
        $request->validate([
            'name' => 'required|string',
            'time' => 'required|integer',
        ], [
            'name.required' => 'Name is required',
            'time.required' => 'Time is required'
        ]);

        $data = ManageTime::findOrFail($id);
        $data->time = $reqData['time'];
        $data->name = $reqData['name'];
        $data->save();
        return back()->with('success', 'Update Successfully.');
    }

}
