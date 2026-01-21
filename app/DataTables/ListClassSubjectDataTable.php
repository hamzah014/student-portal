<?php

namespace App\DataTables;

use App\DataTables\DataTableTrait;
use App\Models\ClassSubject;
use App\Models\ListClassSubject;
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

class ListClassSubjectDataTable extends DataTable
{
    use DataTableTrait;

    public $tableId = 'listClassTable';

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', function ($model){
                return $model->created_at?->format('d M Y');
            })
            ->editColumn('lecturer_id', function ($model){
                return $model->lecturer?->name;
            })
            ->addColumn('action', function ($model) {

                $show = '
                    <button type="button" class="btn btn-primary btn-sm btn-join" data-id="'.$model->id.'" data-title="'.$model->name.'"><i class="fa fa-solid fa-hand-pointer"></i> Request to Join</button>
                ';

                if($model->classStudent)
                {
                    $status = $model->classStudent->status;
                    $show = '
                        <button type="button" class="btn btn-danger btn-sm btn-withdraw" data-id="'.$model->id.'" data-title="'.$model->name.'"><i class="fa fa-solid fa-arrow-up-from-bracket"></i> Withdraw</button>
                    ';
                    if($status == 'approve')
                        $show .= '<br><small class="badge text-bg-success">Joined at: '. Carbon::parse($model->classStudent->updated_at)->format('d M Y') .' </small>';
                    if($status == 'request')
                        $show .= '<br><small class="badge text-bg-secondary">Request at: '. Carbon::parse($model->classStudent->created_at)->format('d M Y') .' </small>';
                }

                return $show;
            })
            ->rawColumns(['name','created_at','action']);
    }

    public function query(ClassSubject $model)
    {
        $userid = Auth::user()->id;
        return
            $model->select(
                ...$model->qualifyColumns([
                    'id',
                    'code',
                    'name',
                    'lecturer_id',
                    'created_at',
                    'updated_at',
                ])
            )
            ->where(function ($query) use ($userid) {
                $query->whereHas('classStudent', function ($q) use ($userid) {
                    $q->where('student_id', $userid);
                })
                ->orWhereDoesntHave('classStudent');
            });
    }

    public function html()
    {
        return $this->builder()
            ->setTableId($this->tableId)
            ->columns([
                Column::make('code')->title("Subject Code")->width(200),
                Column::make('name')->title('Subject Name')->width(300),
                Column::make('lecturer_id')->title("Lecturer Assigned")->width(300),
                $this->actionColumn()->width('300'),
            ])
            ->orders([])
            ->orderBy(0);
    }

}
