<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Spatie\Permission\Traits\HasRoles;

class UsersDataTable extends DataTable
{
  use HasRoles;
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
   * @param \App\Models\User $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query(User $model): QueryBuilder
  {
    //return $model->newQuery();
    return User::with('roles');
  }

  /**
   * Optional method if you want to use html builder.
   *
   * @return \Yajra\DataTables\Html\Builder
   */
  public function html(): HtmlBuilder
  {
    return $this->builder()
      ->setTableId('table-users')
      ->addTableClass('responsive dt-responsive')
      ->responsive(["details" => ["type" => 'column', "target" => -1]])
      ->columns($this->getColumns())
      ->minifiedAjax()
      ->orderBy(0)
      ->selectStyleSingle()
      ->dom("<'dt-top'fB><'table-container'tr><'dt-bottom'lp>")
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
    return [
      Column::make('id')
        ->title('ID')
        ->hidden(),
      Column::make('name')
        ->title('Nama')
        ->responsivePriority(1),
      Column::make('whatsapp')
        ->title('WhatsApp')
        ->responsivePriority(2),
      Column::make('email')
        ->title('Email')
        ->responsivePriority(3),
      Column::make('roles.0.name')
        ->title('Role')
        ->addClass('capitalize')
        ->responsivePriority(4),
      Column::make('active')
        ->title('Status')
        ->content('-')
        //->addClass('none')
        ->responsivePriority(5)
        ->renderRaw("
          function ( data ) {
            return data == 0 ? 'Inactive' : 'Active';
          }
          "),
      Column::computed('control')
        ->title('')
        ->className('dtr-control')
        ->width('40px')
        ->exportable(false)
        ->orderable(false)
        ->printable(false)
    ];
  }

  public function getButtons(): array
  {
    $buttons = [];
    if (auth()->user()->can('export users')) {
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
    return 'Users_' . date('YmdHis');
  }
}
