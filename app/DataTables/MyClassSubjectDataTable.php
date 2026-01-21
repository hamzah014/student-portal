<?php

namespace App\DataTables;

use App\DataTables\DataTableTrait;
use App\Models\ClassSubject;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MyClassSubjectDataTable extends DataTable
{
    use DataTableTrait;

    public $tableId = 'MyClassTable';

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
            ->editColumn('updated_at', function ($model){
                return $model->classStudent?->updated_at->format('d M Y');
            })
            ->rawColumns(['name','created_at','action']);
    }

    public function query(ClassSubject $model)
    {
        $lectId = Auth::user()->id;
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
            )->whereHas('classStudent', function ($query) use ($lectId) {
                $query->where('student_id', $lectId)->where('status', 'approve');
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
                Column::make('updated_at')->title("Joined at")->width(300),
            ])
            ->orders([])
            ->orderBy(0);
    }
}
