<?php

namespace App\DataTables;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomersDataTable extends DataTable
{
  /**
   * Build DataTable class.
   *
   * @param QueryBuilder $query Results from query() method.
   * @return \Yajra\DataTables\EloquentDataTable
   */
  public function dataTable(QueryBuilder $query): EloquentDataTable
  {
    return (new EloquentDataTable($query))
      ->addColumn('control', function () {
      })
      ->setRowId('id');
  }

  /**
   * Get query source of dataTable.
   *
   * @param \App\Models\Customer $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query(Customer $model): QueryBuilder
  {
    //return $model->newQuery();
    return Customer::with(['customertype', 'currentsalesman', 'user']);
  }

  /**
   * Optional method if you want to use html builder.
   *
   * @return \Yajra\DataTables\Html\Builder
   */
  public function html(): HtmlBuilder
  {
    return $this->builder()
      ->setTableId('table-customers')
      ->addTableClass('responsive dt-responsive')
      ->responsive(["details" => ["type" => 'column', "target" => -1]])
      ->columns($this->getColumns())
      ->minifiedAjax()
      ->orderBy(0)
      ->selectStyleSingle()
      ->dom("<'flex justify-end'fB><tr><'flex justify-between'lp>")
      ->buttons($this->getButtons())
      ->lengthMenu([[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]])
      ->pageLength(50)
      ->language(["search" => '<span>Search</span>', "searchPlaceholder" => 'Search records']);
  }

  /**
   * Get the dataTable columns definition.
   *
   * @return array
   */
  public function getColumns(): array
  {
    $columns = [
      Column::make('id')
        ->title('ID')
        ->hidden(),
      Column::make('name')
        ->title('Nama')
        ->responsivePriority(1),
      Column::make('phone')
        ->title('Phone')
        ->content('-')
        ->responsivePriority(2),
      Column::make('customertype.name')
        ->title('Tipe')
        ->content('-')
        //->addClass('none')
        ->responsivePriority(3),
      Column::make('currentsalesman.name')
        ->title('Sales Sekarang')
        ->content('-')
        //->addClass('none')
        ->responsivePriority(4),
      Column::make('previous_salesman')
        ->title('Sales Sebelumnya')
        ->content('-')
        //->addClass('none')
        ->responsivePriority(5),
      Column::make('existing')
        ->title('Langganan')
        ->content('-')
        ->addClass('none')
        ->responsivePriority(6)
        ->renderRaw("
        function ( data ) {
          return data == 0 ? 'Tidak' : 'Ya';
        }
        "),
      Column::make('notes')
        ->title('Catatan')
        ->content('-')
        ->addClass('none')
        ->responsivePriority(7),
      Column::make('user.name')
        ->title('Created By')
        ->content('-')
        ->addClass('none')
        ->responsivePriority(8),
      Column::computed('control')
        ->title('')
        ->className('dtr-control')
        ->width('40px')
        ->exportable(false)
        ->orderable(false)
        ->printable(false)
    ];

    return $columns;
  }

  public function getButtons(): array
  {
    $buttons = [];
    if (auth()->user()->can('export customers')) {
      $button_export = Button::make('excel')
        ->text('<i class="uil uil-file-upload"></i><span>Export</span>');
      array_push($buttons, $button_export);
    }
    // if (auth()->user()->can('import customers')) {
    //   $button_import = [
    //     "text" => '<i class="uil uil-file-download"></i><span>Import</span>',
    //     "action" => "function ( e, dt, node, config ) {
    //         $('#import-customer').prop('checked', true);
    //       }",
    //     "className" => 'btn-primary'
    //   ];
    //   array_push($buttons, $button_import);
    // }
    return $buttons;
  }

  /**
   * Get filename for export.
   *
   * @return string
   */
  protected function filename(): string
  {
    return 'Customers_' . date('YmdHis');
  }
}
