<?php

namespace App\DataTables\Admin;

use App\DataTables\DataTableTrait;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StudentDataTable extends DataTable
{
    use DataTableTrait;

    public $tableId = 'StudentTable';

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
            ->rawColumns(['name','email_verified_at','created_at']);
    }

    public function query(User $model)
    {

        $userrole = User::STUDENT_ROLE;

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
            ->where('role', $userrole);
    }

    public function html()
    {
        return $this->builder()
            ->setTableId($this->tableId)
            ->columns([
                Column::make('email_verified_at')->title("Verified")->width(100)->className('text-center'),
                Column::make('name')->title('Name')->width(300),
                Column::make('email')->title("Email")->width(300),
                Column::make('created_at')->title("Created At")->width(200),
            ])
            ->orders([])
            ->orderBy(0);
    }
}
