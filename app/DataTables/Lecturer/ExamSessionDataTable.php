<?php

namespace App\DataTables\Lecturer;

use App\DataTables\DataTableTrait;
use App\Models\ExamSession;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ExamSessionDataTable extends DataTable
{
    use DataTableTrait;

    public $tableId = 'MyExamTable';

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', function ($model){
                return $model->created_at?->format('d M Y');
            })
            ->editColumn('class_id', function ($model){
                return $model->classSubject?->name;
            })
            ->editColumn('duration_min', function ($model){
                
                $openat = Carbon::parse($model->start_at)->format('d M Y, h:i A');
                $closeat = Carbon::parse($model->end_at)->format('d M Y, h:i A');
                $duration = $model->duration_min;

                $show = '
                    <p><b>Opened at: </b> '.$openat.'</p>
                    <p><b>Closed at: </b> '.$closeat.'</p>
                    <p><b>Duration: </b> '.$duration.' minute</p>
                ';

                return $show;

            })
            ->addColumn('action', function ($model) {

                $routeEdit = route('lect.exam.edit', $model);
                $routeAttempt = route('lect.exam.attempt', $model);

                $show = '
                    <a class="btn btn-primary btn-sm" data-id="'.$model->id.'" href="'.$routeEdit.'"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-info btn-sm" href="'.$routeAttempt.'"><i class="fa fa-file"></i>See Attempt</a>
                ';

                return $show;
            })
            ->rawColumns(['name','class_id','duration_min','created_at','action']);
    }

    public function query(ExamSession $model)
    {
        $userid = Auth::user()->id;
        return
            $model->select(
                ...$model->qualifyColumns([
                    'id',
                    'title',
                    'class_id',
                    'duration_min',
                    'start_at',
                    'end_at',
                    'created_at',
                    'updated_at',
                ])
            )
            ->whereHas('classSubject', function ($query) use ($userid) {
                $query->where('lecturer_id', $userid);
            });
    }

    public function html()
    {
        return $this->builder()
            ->setTableId($this->tableId)
            ->columns([
                Column::make('title')->title('Title')->width(300),
                Column::make('class_id')->title("Class Name")->width(300),
                Column::make('duration_min')->title("Duration")->width(400),
                Column::make('created_at')->title("Created At")->width(200),
                $this->actionColumn()->width('300'),
            ])
            ->orders([])
            ->orderBy(0);
    }
}
