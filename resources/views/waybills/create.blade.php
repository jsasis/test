@extends('crudbooster::admin_template')
@section('content')

<div>
  @if(CRUDBooster::getCurrentMethod() != 'getProfile' && $button_cancel)
  @if(g('return_url'))
  <p><a title='Return' href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
  @else
  <p><a title='Main Module' href='{{CRUDBooster::mainpath()}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
  @endif
  @endif
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong><i class='{{CRUDBooster::getCurrentModule()->icon}}'></i> {!! $page_title or "Page Title" !!}</strong>
    </div>
    <div class="panel-body" style="padding:20px 0px 0px 0px">
      <?php                               
      $action = (@$row)?CRUDBooster::mainpath("edit-save/$row->id"):CRUDBooster::mainpath("add-save");
      $return_url = ($return_url)?:g('return_url');          
      ?>
      <form  method='post' id="form" action='{{$action}}'>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">    
        <input type='hidden' name='return_url' value='{{ @$return_url }}'/>      
        <input type='hidden' name='ref_mainpath' value='{{ CRUDBooster::mainpath() }}'/>      
        <input type='hidden' name='ref_parameter' value='{{urldecode(http_build_query(@$_GET))}}'/>
        <input type="hidden" name='status' value='received'>
        <div class="box-body">
          <div id="waybill-details">
            <div class="col-lg-6">
              <div class="form-group">
                <label>Consignee</label>
                <select id="consignee" type="text" name="consignee" class="form-control" required></select>
              </div>
              <div class="form-group">
                <label>Consignor</label>
                <select id="consignor" type="text" name="consignor" class="form-control" required></select>
              </div>
              <div class="form-group">
                <label>DR Number</label>
                <input type="text" name="dr_number" class="form-control">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label>Payment Terms</label>
                <select name="payment_terms" class="form-control">
                  <option value="prepaid">Prepaid</option>
                  <option value="collect">Collect</option>
                </select>
              </div>      
              <div class="form-group">
                <label>Notes</label>
                <textarea name="notes" cols="30" rows="10" class="form-control"></textarea>
              </div>
            </div> 
          </div>
          <div id="waybill-items">
            <div class="col-lg-12">
              <table class="table-display table table-striped" id="invoice-table">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th width="100px">Price</th>
                    <th width="95px">Quantity</th>
                    <th>Description</th>
                    <th>Sub Total</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input type="text" placeholder="Product" class="product form-control notfocus">
                    <input type="hidden" name="id_products[]"></td>
                    <td><input type="number" min="1" step="any" name="price[]" placeholder="Price" class="price form-control notfocus calculate"></td>
                    <td><input type="number" min="1" name="quantity[]" value="1" placeholder="Quantity" class="quantity form-control notfocus calculate"></td>
                    <td><input type="text" name="description[]" placeholder="Description" class="description form-control notfocus"></td>
                    <td><input type="text" class="form-control notfocus calculate-sub" disabled></td>
                    <td>
                      <a href="javascript:void(0)" class="btn btn-info btn-plus add-row"><i class="fa fa-plus"></i></a>
                      <a href="javascript:void(0)" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div id="summary">
            <div class="col-lg-2 col-lg-offset-8">
              <strong>Total:</strong>
            </div>
            <div class="col-lg-2 text-left">
              <span class="total">0.00</span>
            </div>
          </div>
        </div>
        <div class="box-footer" style="background: #F5F5F5">  
          <div class="form-group">
            <label class="control-label col-sm-2"></label>
            <div class="col-sm-10">
              @if($button_cancel && CRUDBooster::getCurrentMethod() != 'getDetail')                       
              @if(g('return_url'))
              <a href='{{g("return_url")}}' class='btn btn-default'><i class='fa fa-chevron-circle-left'></i> {{trans("crudbooster.button_back")}}</a>
              @else 
              <a href='{{CRUDBooster::mainpath("?".http_build_query(@$_GET)) }}' class='btn btn-default'><i class='fa fa-chevron-circle-left'></i> {{trans("crudbooster.button_back")}}</a>
              @endif
              @endif
              @if(CRUDBooster::isCreate() || CRUDBooster::isUpdate())

              @if(CRUDBooster::isCreate() && $button_addmore==TRUE && $command == 'add')                                                                 
              <button type='submit' name='submit' class='btn btn-success'><i class='fa fa-plus-circle'></i> {{trans("crudbooster.button_save_more")}}</button>
              @endif

              @if($button_save && $command != 'detail')
              <button type='submit' name='submit' class='btn btn-success'><i class='fa fa-check-circle'></i> {{trans("crudbooster.button_save")}}</button>
              @endif

              @endif
            </div>
          </div>   
        </div>
      </form>
    </div>
  </div>
</div>

<link rel='stylesheet' href='{{ asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css") }}'/>
<script src='{{ asset("vendor/crudbooster/assets/select2/dist/js/select2.full.min.js") }}'></script>
<script src='{{ asset("js/typeahead.bundle.min.js") }}'></script>
<style>
  .table-display tbody tr td {
    position:relative;
  }
  .sub {
    position:absolute;
    top:inherit;
    left:inherit;
    padding:0 0 0 0;
    list-style-type:none;
    height:180px;
    overflow:auto;
    z-index: 1;
  }
  .sub li {
    padding:5px;
    background:#fff;
    cursor:pointer;
    display:block;
    width:180px;
  }
  .sub li:hover {
    background:rgb(51, 122, 183);
    color:#fff;
  }
  .btn-drag {
    cursor: move;
  }
  .select2-container--default .select2-selection--single {
    border-radius: 0px !important
  }
  .select2-container .select2-selection--single {
    height: 35px
  }
  .twitter-typeahead {
    display: block !important;
  }
  .tt-query {
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  }

  .tt-hint {
    color: #999
  }

  .tt-menu {    /* used to be tt-dropdown-menu in older versions */
    width: 422px;
    margin-top: 4px;
    padding: 4px 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.2);
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    box-shadow: 0 5px 10px rgba(0,0,0,.2);
  }

  .tt-suggestion {
    padding: 3px 20px;
    line-height: 24px;
  }

  .tt-suggestion.tt-cursor,.tt-suggestion:hover {
    color: #fff;
    background-color: #0097cf;

  }

  .tt-suggestion p {
    margin: 0;
  }
</style>
<script type="text/javascript">
  var products = '{!! $products !!}';

  typeahead_init();

  function typeahead_init() {
    var data = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      local: $.parseJSON(products),
    });

    $('.product').typeahead({
      hint: true,
      highlight: true,
      minLength: 1
    },
    {
      name: 'products',
      source: data,
      display: 'name'
    }).bind('typeahead:selected', function(e, selected) {
      $(this).closest('td').children('input[name="id_products[]"]').val(selected.id)
      $(this).closest('td').next().children('input[name="price[]"]').val(selected.price).trigger('change');
    });
  }

  function typahead_destroy() {
    $('.product').typeahead('destroy');
  }

  var cloned = '<tr><td><input type="text" placeholder="Product" class="product form-control notfocus">'+
  '<input type="hidden" name="id_products[]"></td>'+
  '<td><input type="number" min="1" step="any" name="price[]" placeholder="Price" class="price form-control notfocus calculate"></td>'+
  '<td><input type="number" min="1" name="quantity[]" value="1" placeholder="Quantity" class="quantity form-control notfocus calculate"></td>'+
  '<td><input type="text" name="description[]" placeholder="Description" class="description form-control notfocus"></td>'+
  '<td><input type="text" class="form-control notfocus calculate-sub" disabled></td>'+
  '<td>'+
  '<a href="javascript:void(0)" class="btn btn-info btn-plus add-row"><i class="fa fa-plus"></i></a>'+
  '<a href="javascript:void(0)" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></a>'+
  '</td>'+
  '</tr>';

  $(document).on('click', '.add-row', function(e) {
    e.preventDefault();
    typahead_destroy();
    $('#invoice-table').append(cloned);
    typeahead_init();
  });

  $('#invoice-table').on('change keyup paste', '.calculate', function() {
    updateTotals(this);
    calculateTotal();
  });

  function updateTotals(elem) {
    var tr = $(elem).closest('tr'),
    quantity = $('[name="quantity[]"]', tr).val(),
    price = $('[name="price[]"]', tr).val(),
    percent = 0;

    if (!price) {
      price = 0;
    }

    var subtotal = parseInt(quantity) * parseFloat(price);

    if (percent && $.isNumeric(percent) && percent !== 0) {
      subtotal = subtotal - ((parseInt(percent) / 100) * subtotal);
    }

    $('.calculate-sub', tr).val(subtotal.toFixed(2));
  }

  function calculateTotal() {
    var grandTotal = 0.0;
    var totalQuantity = 0;
    $('.calculate-sub').each(function() {
      grandTotal += parseFloat($(this).val());
    });

    $('.total').text(parseFloat(grandTotal).toFixed(2));
  }

  $(function() {
    $('#consignee, #consignor').select2({                                 
      placeholder: {
        id: '-1', 
        text: '** Please select a Consignee'
      },
      allowClear: true,
      ajax: {                   
        url: 'http://crudbooster.dev/admin/waybills/find-data',                   
        delay: 250,                                     
        data: function (params) {
          var query = {
            q: params.term,
            format: "",
            table1: "customers",
            column1: "name",
          }
          return query;
        },
        processResults: function (data) {
          return {
            results: data.items
          };
        }                                       
      },
      escapeMarkup: function (markup) { return markup; },                                         
      minimumInputLength: 1,
    });
  });

  $(document).mouseup(function (e)
  {
    var container = $(".sub");
    if (!container.is(e.target) 
      && container.has(e.target).length === 0) 
    {
      container.hide();
    }
  });     

  $(document).on('click','.table-display .btn-delete',function() {
    var tr = $(this).parent().parent();
    var trPrev = tr.prev('tr');

    if(trPrev.length != 0) {
      tr.remove();   
    }
  })
</script>
@endsection