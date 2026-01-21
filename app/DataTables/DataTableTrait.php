<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

trait DataTableTrait
{
    /**
     * Get DataTables Html Builder instance.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function builder(): Builder
    {
        return parent::builder()
            ->minifiedAjax()
            ->searchDelay(700)
            ->responsive()
            ->autoWidth(false)
            ->parameters([
                'language' => [
                    'searchPlaceholder' => 'Search...',
                    'search' => "",
                ],
                'drawCallback' => $this->initCompleteJs(),
                'deferRender' => true,
            ]);
    }

    /**
     * Note: Change protected function to public.
     * 
     * Apply query scopes.
     *
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    // public function applyScopes($query)
    // {
    //     return parent::applyScopes($query);
    // }

    public function initCompleteJs(){
        return 'function(settings, json) { 
            var tooltip = $("[data-toggle=tooltip]");
            if(tooltip.length > 0){
                tooltip.each((key,element)=>{
                    new bootstrap.Tooltip(element)
                })
            }
        }';
    }

    private function expandableColumn(?string $title = null, int $width = 10): Column
    {
        return Column::computed(null, $title)
            ->exportable(false)
            ->printable(false)
            ->width($width)
            ->content('')
            ->addClass('details-control');
    }

    private function rowNumberColumn(string $columnName = 'row_number', string $title = 'No.', int $width = 10): Column
    {
        return Column::computed($columnName, $title)
            ->exportable(false)
            ->printable(false)
            ->width($width);
    }

    private function actionColumn(string $columnName = 'action', string $title = 'Action', int $width = 60): Column
    {
        return Column::computed($columnName, $title)
            ->exportable(false)
            ->printable(false)
            ->width($width)
            ->addClass('text-center');
    }

    private function childbarColumn(string $title = '', int $width = 20, string $class = 'details-control'): Column
    {
        return Column::computed('')
            ->content('')
            ->title($title)
            ->orderable(false)
            ->exportable(false)
            ->searchable(false)
            ->width($width)
            ->addClass($class);
    }

    private function childbar(string $class = 'details-control')
    {
        //To use add ->parameters(['initComplete' => $this->childbar(),]) in html builder()

        return "function () {
            function format ( d ) {
                return d.childBar;
            }
            let table = $('#".$this->tableId."').DataTable();
            $('#".$this->tableId." tbody').on('click', 'td.".$class."', function () {
                let tr = $(this).closest('tr');
                let row = table.row( tr );
                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    row.child(format(row.data())).show();
                    var childRow = row.child();
                    var childTds = $(childRow).find('td');
                    childTds.each(function(index) {
                        var td = $(this);
                        td.css({
                            'border-top' : 'none'
                        });
                    });
                    tr.addClass('shown');
                }
            });
        }";
    }
}
