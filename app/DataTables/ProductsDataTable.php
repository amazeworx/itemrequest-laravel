<?php

namespace App\DataTables;

use App\Models\Product;
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

class ProductsDataTable extends DataTable
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
   * @param \App\Models\Product $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query(Product $model): QueryBuilder
  {
    //return $model->newQuery();
    return Product::with(['user']);
  }

  /**
   * Optional method if you want to use html builder.
   *
   * @return \Yajra\DataTables\Html\Builder
   */
  public function html(): HtmlBuilder
  {
    return $this->builder()
      ->setTableId('table-products')
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
    $columns = [
      Column::make('id')
        ->title('ID')
        ->hidden(),
      Column::make('sku')
        ->title('SKU')
        ->responsivePriority(2),
      Column::make('name')
        ->title('Nama Barang')
        ->responsivePriority(1),
      Column::make('brand')
        ->title('Merk Mobil')
        ->content('-')
        ->responsivePriority(7),
      Column::make('year')
        ->title('Tahun')
        ->content('-')
        ->responsivePriority(8),
      Column::make('cc')
        ->title('CC')
        ->content('-')
        ->responsivePriority(8),
      Column::make('engine')
        ->title('Tipe Mesin')
        ->content('-')
        ->responsivePriority(10),
    ];
    if (auth()->user()->can('view product buy price')) {
      $price_buy = Column::make('price_buy')
        ->title('Harga Beli')
        ->content('-')
        ->addClass('none')
        ->responsivePriority(10);
      array_push($columns, $price_buy);
    }
    if (auth()->user()->can('view product resell price')) {
      $price_resell = Column::make('price_resell')
        ->title('Harga Jual Toko')
        ->content('-')
        ->addClass('none')
        ->responsivePriority(10);
      array_push($columns, $price_resell);
    }
    if (auth()->user()->can('view product retail price')) {
      $price_retail = Column::make('price_retail')
        ->title('Harga Jual User')
        ->content('-')
        ->addClass('none')
        ->responsivePriority(10);
      array_push($columns, $price_retail);
    }

    $notes = Column::make('notes')
      ->title('Catatan')
      ->content('-')
      ->addClass('none')
      ->responsivePriority(10);
    array_push($columns, $notes);

    $created_by = Column::make('user.name')
      ->title('Created By')
      ->content('-')
      ->addClass('none')
      ->responsivePriority(10);
    array_push($columns, $created_by);

    $control = Column::computed('control')
      ->title('')
      ->className('dtr-control')
      ->width('40px')
      ->exportable(false)
      ->orderable(false)
      ->printable(false);
    array_push($columns, $control);

    return $columns;
  }

  public function getButtons(): array
  {
    $buttons = [];
    if (auth()->user()->can('export products')) {
      $button_export = Button::make('excel')
        ->text('<i class="uil uil-file-upload"></i><span>Export</span>');
      array_push($buttons, $button_export);
    }
    if (auth()->user()->can('import products')) {
      $button_import = [
        "text" => '<i class="uil uil-file-download"></i><span>Import</span>',
        "action" => "function ( e, dt, node, config ) {
          //console.log(e);
          $('#import-product').prop('checked', true);
        }",
        "className" => 'btn-primary'
      ];
      array_push($buttons, $button_import);
    }
    return $buttons;
  }

  /**
   * Get filename for export.
   *
   * @return string
   */
  protected function filename(): string
  {
    return 'Products_' . date('YmdHis');
  }
}
