<?php

namespace App\DataTables;

use App\Models\ItemRequest;
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

class ItemRequestsDataTable extends DataTable
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
      ->addColumn('request_date', function (ItemRequest $itemRequest) {
        return date('d-m-Y', strtotime($itemRequest->request_date));
      })
      ->addColumn('control', function () {
      })
      ->addColumn('action', function (ItemRequest $itemRequest) {
        $actionBtn = '<div class="inline-flex gap-x-2"><a href="#!" data-id="' . $itemRequest->id . '"
                    class="view_item_request link link-primary link-hover">View</a>
                  <a href="#!" data-id="' . $itemRequest->id . '"
                    class="edit_item_request link link-primary link-hover">Edit</a>
                  <a href="#!" data-id="' . $itemRequest->id . '"
                    class="delete_item_request link link-primary link-hover">Delete</a></div>';
        return $actionBtn;
      })
      ->setRowId('id');
  }

  /**
   * Get query source of dataTable.
   *
   * @param \App\Models\ItemRequest $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query(ItemRequest $model): QueryBuilder
  {
    //return $model->newQuery();
    $user_id = $this->user_id;
    $get_user_role = User::where('id', $user_id)->first();
    if ($get_user_role->role == 'Sales') {
      return ItemRequest::where('salesman_id', $user_id)->with(['product', 'customer', 'salesman', 'status']);
    } else {
      return ItemRequest::with(['product', 'customer', 'salesman', 'status']);
    }
  }

  /**
   * Optional method if you want to use html builder.
   *
   * @return \Yajra\DataTables\Html\Builder
   */
  public function html(): HtmlBuilder
  {
    return $this->builder()
      ->setTableId('table-item-request')
      ->addTableClass('responsive dt-responsive')
      ->responsive(["details" => ["type" => 'column', "target" => -1]])
      ->columns($this->getColumns())
      ->minifiedAjax()
      ->orderBy(0)
      ->selectStyleSingle()
      //->dom('Bfrtip')
      //->dom("<'row'<'col-sm-12'B>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>")
      ->dom("<'flex justify-end gap-x-3'fB><tr><'flex justify-between'lp>")
      ->buttons($this->getButtons())
      ->lengthMenu([[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]])
      ->pageLength(50)
      ->language(["search" => '<span>Search</span>', "searchPlaceholder" => 'Search records'])
      ->parameters([
        //"lengthMenu" => [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]],
        //"order" => [[0, 'desc']],
        // "responsive" => [
        //   "details" => [
        //     "type" => 'column',
        //     "target" => -1
        //   ]
        // ]
      ]);
  }

  public function getButtons(): array
  {
    //$user_id = $this->user_id;
    //$user_id->hasPermissionTo('edit articles');
    $buttons = [];
    if (auth()->user()->can('export requests')) {
      $button_export = Button::make('excel')
        ->text('<i class="uil uil-file-upload"></i><span>Export</span>');
      array_push($buttons, $button_export);
    }
    if (auth()->user()->can('import requests')) {
      $button_import = [
        "text" => '<i class="uil uil-file-download"></i><span>Import</span>',
        "action" => "function ( e, dt, node, config ) {
          //console.log('e:', e);
          //console.log('dt:', dt);
          //console.log('node:', node);
          //console.log('config:', config);
          $('#import-item-request').prop('checked', true);
        }",
        "className" => 'btn-primary'
      ];
      array_push($buttons, $button_import);
    }
    return $buttons;
    // return [
    //   Button::make('excel')
    //     ->text('<i class="uil uil-file-upload"></i><span>Export</span>'),
    //   [
    //     "text" => '<i class="uil uil-file-download"></i><span>Import</span>',
    //     "action" => "function ( e, dt, node, config ) {
    //       //console.log('e:', e);
    //       //console.log('dt:', dt);
    //       //console.log('node:', node);
    //       //console.log('config:', config);
    //       $('#import-item-request').prop('checked', true);
    //     }",
    //     "className" => 'btn-primary'
    //   ],
    //   Button::make('csv'),
    //   Button::make('pdf'),
    //   Button::make('print'),
    //   Button::make('reset'),
    //   Button::make('reload')
    // ];
  }

  /**
   * Get the dataTable columns definition.
   *
   * @return array
   */
  public function getColumns(): array
  {
    return [
      Column::make('request_code')
        ->title('Request #')
        ->responsivePriority(1),
      Column::computed('request_date')
        ->title('Date')
        ->responsivePriority(2)
        ->orderable(true),
      Column::make('product.name')
        ->responsivePriority(3)
        ->title('Product'),
      Column::make('customer.name')
        ->responsivePriority(4)
        ->title('Customer'),
      Column::make('salesman.name')
        ->responsivePriority(5)
        ->title('Sales'),
      Column::make('status.name')
        ->responsivePriority(3)
        ->title('Status'),
      Column::make('product.brand')
        ->title('Merk Mobil')
        ->content('-')
        ->responsivePriority(7)
        ->addClass('none'),
      Column::make('product.year')
        ->title('Tahun')
        ->content('-')
        ->responsivePriority(8)
        ->addClass('none'),
      Column::make('product.cc')
        ->title('CC')
        ->content('-')
        ->responsivePriority(8)
        ->addClass('none'),
      Column::computed('control')
        ->title('')
        ->className('dtr-control')
        ->width('40px')
        ->exportable(false)
        ->orderable(false)
        ->printable(false)
      // Column::computed('action')->title('')
      //   ->exportable(false)
      //   ->printable(false)
      //   ->sortable(false)
      //   ->responsivePriority(2)
    ];
  }

  /**
   * Get filename for export.
   *
   * @return string
   */
  protected function filename(): string
  {
    return 'ItemRequests_' . date('YmdHis');
  }
}