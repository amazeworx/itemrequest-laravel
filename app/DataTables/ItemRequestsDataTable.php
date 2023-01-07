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
      ->addColumn('comments', function (ItemRequest $itemRequest) {
        $comments = $itemRequest->comments;
        $output = "";
        foreach ($comments as $comment) {
          $output .= "[" . $comment->user->name . "] ";
          $output .= $comment->comment . "; \n";
        }
        return nl2br($output);
      })
      ->rawColumns(['comments'])
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
    $get_user = User::where('id', $user_id)->first();

    if ($get_user->hasRole('sales')) {
      return ItemRequest::where('salesman_id', $user_id)->with(['product', 'customer', 'salesman', 'status', 'user', 'comments']);
    } else {
      return ItemRequest::with(['product', 'customer', 'salesman', 'status', 'user', 'comments']);
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
      //->addTableClass('responsive dt-responsive')
      ->responsive(["details" => ["type" => 'column', "target" => -1]])
      ->columns($this->getColumns())
      ->minifiedAjax()
      ->orderBy(0)
      ->selectStyleSingle()
      ->dom("<'dt-top'fB><'table-container'tr><'dt-bottom'lp>")
      ->buttons($this->getButtons())
      ->lengthMenu([[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]])
      ->pageLength(10)
      ->language(["search" => '<span class="hidden md:block">Search</span>', "searchPlaceholder" => 'Search records']);
    // ->parameters(
    //   [
    //     "responsive" => ["details" => ["type" => 'column', "target" => -1]]
    //   ]
    // );
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
    return $buttons;
  }

  /**
   * Get the dataTable columns definition.
   *
   * @return array
   */
  public function getColumns(): array
  {
    $columns = [
      Column::make('request_code')
        ->title('Request #')
        ->responsivePriority(5),
      Column::computed('request_date')
        ->title('Date')
        ->responsivePriority(4)
        ->orderable(true),
      Column::make('product.name')
        ->responsivePriority(1)
        ->title('Product')
    ];
    if (auth()->user()->can('view customers')) {
      $customer = Column::make('customer.name')
        ->responsivePriority(3)
        ->title('Customer');
      array_push($columns, $customer);
    }
    if (auth()->user()->can('view product resell price')) {
      $price_resell = Column::make('product.price_resell')
        ->responsivePriority(5)
        ->content('-')
        ->renderRaw("
          function ( data ) {
            if (data == '0.00' | !data) {
              return '-';
            } else {
              return new Intl.NumberFormat('id-ID').format(data);
            }
          }
          ")
        ->title('Harga Toko');
      array_push($columns, $price_resell);
    }
    if (auth()->user()->can('view product retail price')) {
      $price_retail = Column::make('product.price_retail')
        ->responsivePriority(5)
        ->content('-')
        ->renderRaw("
          function ( data ) {
            if (data == '0.00' | !data) {
              return '-';
            } else {
              return new Intl.NumberFormat('id-ID').format(data);
            }
          }
          ")
        ->title('Harga User');
      array_push($columns, $price_retail);
    }
    if (auth()->user()->can('view product buy price')) {
      $price_buy = Column::make('product.price_buy')
        ->responsivePriority(6)
        ->renderRaw("
          function ( data ) {
            if (data == '0.00' | !data) {
              return '-';
            } else {
              return new Intl.NumberFormat('id-ID').format(data);
            }
          }
          ")
        ->title('Harga Beli');
      array_push($columns, $price_buy);
    }
    if (auth()->user()->hasAnyRole(['super-admin', 'purchasing'])) {
      $salesman = Column::make('salesman.name')
        ->responsivePriority(5)
        ->title('Sales');
      array_push($columns, $salesman);
    }
    // $comments = Column::make('comments')
    //   ->responsivePriority(2)
    //   ->title('Comments');
    // array_push($columns, $comments);

    $comments = Column::computed('comments')
      ->title('Comments')
      ->exportable(true)
      ->orderable(false)
      ->printable(false)
      ->hidden()
      ->responsivePriority(10);
    array_push($columns, $comments);

    $status = Column::make('status.name')
      ->responsivePriority(2)
      ->title('Status');
    array_push($columns, $status);

    $product_brand = Column::make('product.brand')
      ->title('Merk Mobil')
      ->content('-')
      ->responsivePriority(6)
      ->addClass('none');
    array_push($columns, $product_brand);

    $product_year = Column::make('product.year')
      ->title('Tahun')
      ->content('-')
      ->responsivePriority(7)
      ->addClass('none');
    array_push($columns, $product_year);

    $product_cc = Column::make('product.cc')
      ->title('CC')
      ->content('-')
      ->responsivePriority(8)
      ->addClass('none');
    array_push($columns, $product_cc);

    $product_engine = Column::make('product.engine')
      ->title('Tipe Mesin')
      ->content('-')
      ->responsivePriority(9)
      ->addClass('none');
    array_push($columns, $product_engine);



    // $created_by = Column::make('user.name')
    //   ->title('Created By')
    //   ->content('-')
    //   ->addClass('none')
    //   ->responsivePriority(10);
    // array_push($columns, $created_by);

    $control = Column::computed('control')
      ->title('')
      ->className('dtr-control')
      ->width('40px')
      ->exportable(false)
      ->orderable(false)
      ->printable(false)
      ->responsivePriority(1);
    array_push($columns, $control);

    return $columns;
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
