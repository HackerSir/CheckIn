<?php

namespace App\Http\Controllers;

use App\DataTables\ActivityLogDataTable;
use App\DataTables\Scopes\ActivityLogNameScope;
use DB;
use Illuminate\Http\Response;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    /**
     * @param ActivityLogDataTable $dataTable
     * @return Response
     */
    public function index(ActivityLogDataTable $dataTable)
    {
        //過濾器
        if (!request()->ajax()) {
            $activityLogNames = DB::table(config('activitylog.table_name'))
                ->select('log_name', DB::raw('count(*) as total'))
                ->groupBy('log_name')->get();
            $activityLogNameOptions = [null => ''];
            foreach ($activityLogNames as $activityLogName) {
                $activityLogNameOptions[$activityLogName->log_name]
                    = $activityLogName->log_name . ' (' . $activityLogName->total . ')';
            }
            view()->share(compact('activityLogNameOptions'));
        }
        //過濾
        $selectedLogName = request('log_name');
        if ($selectedLogName) {
            $dataTable->addScope(new ActivityLogNameScope($selectedLogName));
        }

        return $dataTable->render('activity-log.index');
    }

    public function show(Activity $activity)
    {
        return view('activity-log.show', compact('activity'));
    }
}
