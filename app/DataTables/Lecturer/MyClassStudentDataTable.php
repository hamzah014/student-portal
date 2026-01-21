<?php

namespace App\DataTables\Lecturer;

use App\DataTables\DataTableTrait;
use App\Models\ClassStudent;
use App\Models\MyClassStudent;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MyClassStudentDataTable extends DataTable
{
    use DataTableTrait;

    public $tableId = 'MyStudentClassTable';

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', function ($model){
                return $model->created_at?->format('d M Y');
            })
            ->rawColumns(['name','created_at','action']);
    }

    public function query(ClassStudent $model)
    {
        $lectId = Auth::user()->id;
        return
            $model->select(
                ...$model->qualifyColumns([
                    'id',
                    'class_id',
                    'student_id',
                    'status',
                    'created_at',
                    'updated_at',
                ])
            )
            ->whereHas('classSubject', function ($query) use ($lectId) {
                $query->where('lecturer_id', $lectId);
            });
    }

    public function html()
    {
        return $this->builder()
            ->setTableId($this->tableId)
            ->columns([
                Column::make('name')->title('Name'),
                Column::make('created_at')->title("Created At"),
            ])
            ->orders([])
            ->orderBy(0);
    }
}
