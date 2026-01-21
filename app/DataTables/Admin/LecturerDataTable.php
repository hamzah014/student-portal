<?php

namespace App\DataTables\Admin;

use App\DataTables\DataTableTrait;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LecturerDataTable extends DataTable
{
    use DataTableTrait;

    public $tableId = 'LecturerTable';

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', function ($model){
                return $model->created_at?->format('d M Y');
            })
            ->editColumn('email_verified_at', function ($model){
                return $model->email_verified_at ? '<i class="fa fa-solid fa-check-double text-success"></i>' : '<i class="fa fa-solid fa-circle-xmark text-secondary"></i>';
            })
            ->addColumn('action', function ($model) {

                $routeEdit = route('admin.lect.edit', $model);

                $show = '
                    <a class="btn btn-primary btn-sm" lect-id="'.$model->id.'" href="'.$routeEdit.'"><i class="fa fa-pencil"></i></a>
                    <button type="button" class="btn btn-danger btn-sm" lect-id="'.$model->id.'"><i class="fa fa-trash"></i></button>
                ';

                return $show;
            })
            ->rawColumns(['name','email_verified_at','created_at','action']);
    }

    public function query(User $model)
    {

        $lecturerRole = User::LECTURER_ROLE;

        return
            $model->select(
                ...$model->qualifyColumns([
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'role',
                    'refer_code',
                    'created_at',
                    'updated_at',
                ])
            )
            ->where('role', $lecturerRole);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId($this->tableId)
            ->columns([
                Column::make('email_verified_at')->title("Verified")->width(100)->className('text-center'),
                Column::make('name')->title('Name')->width(300),
                Column::make('email')->title("Email")->width(300),
                Column::make('refer_code')->title("Ref. Code")->width(200),
                Column::make('created_at')->title("Created At")->width(200),
                $this->actionColumn()->width('300'),
            ])
            ->orders([])
            ->orderBy(0);
    }
}
