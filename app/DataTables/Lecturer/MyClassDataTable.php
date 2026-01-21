<?php

namespace App\DataTables\Lecturer;


use App\DataTables\DataTableTrait;
use App\Models\ClassSubject;
use App\Models\MyClass;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MyClassDataTable extends DataTable
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
            ->addColumn('action', function ($model) {

                $routeEdit = route('lect.class.view', $model);

                $show = '
                    <a class="btn btn-primary btn-sm" lect-id="'.$model->id.'" href="'.$routeEdit.'"><i class="fa fa-eye"></i></a>
                ';

                return $show;
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
            )
            ->where('lecturer_id', $lectId);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId($this->tableId)
            ->columns([
                Column::make('code')->title("Subject Code")->width(200),
                Column::make('name')->title('Name')->width(300),
                Column::make('lecturer_id')->title("Lecturer Assigned")->width(300),
                Column::make('created_at')->title("Created At")->width(200),
                $this->actionColumn()->width('300'),
            ])
            ->orders([])
            ->orderBy(0);
    }
}
