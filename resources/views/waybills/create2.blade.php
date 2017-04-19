@extends('crudbooster::admin_template')
@section('content')
        
        <div >

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
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>Consignee</label>
                              <select id="consignee" type="text" name="consignee" class="form-control"></select>
                            </div>
                            <div class="form-group">
                              <label>Consignor</label>
                              <select id="consignor" type="text" name="consignor" class="form-control"></select>
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
              


                          {{-- @if($command == 'detail')
                             @include("crudbooster::default.form_detail")  
                          @else
                             @include("crudbooster::default.form_body")         
                          @endif --}}

                          <table class="table-display table table-striped">
                              <thead>
                                <tr>
                                  <th>Product</th>
                                  <th width="100px">Price</th>
                                  <th width="95px">Quantity</th>
                                  <th>Description</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <input type="hidden" name="id_products[]">
                                    <input type="text" onClick="showProductSuggest(this)" placeholder="Product" class="product form-control notfocus">
                                  </td>
                                  <td><input type="text" name="price[]" placeholder="Price" class="price form-control notfocus"></td>
                                  <td><input type="text" name="quantity[]" placeholder="Quantity" class="quantity form-control notfocus"></td>
                                  <td><input type="text" name="description[]" placeholder="Description" class="description form-control notfocus"></td>
                                  <td>
                                    <a href="javascript:void(0)" class="btn btn-info btn-plus"><i class="fa fa-plus"></i></a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></a>
                                  </td>
                                </tr>  

                                <tr id="tr-sample" style="display:none">
                                  <td>
                                    <input type="hidden" name="id_products[]">
                                    <input type="text" onClick="showProductSuggest(this)" placeholder="Product" class="product form-control notfocus">
                                  </td>
                                  <td><input type="text" name="price[]" placeholder="Price" class="price form-control notfocus"></td>
                                  <td><input type="text" name="quantity[]" placeholder="Quantity" class="quantity form-control notfocus"></td>
                                  <td><input type="text" name="description[]" placeholder="Description" class="description form-control notfocus"></td>
                                  <td>
                                    <a href="javascript:void(0)" class="btn btn-info btn-plus"><i class="fa fa-plus"></i></a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></a>
                                  </td>
                                </tr>
                            </tbody>
                          </table>

                        </div><!-- /.box-body -->
                
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
                              
                          

                        </div><!-- /.box-footer-->

                        </form>
        
            </div>
        </div>
        </div><!--END AUTO MARGIN-->
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
                background:#eae9e8;
                cursor:pointer;
                display:block;
                width:180px;
            }
            .sub li:hover {
                background:#ECF0F5;
            }

            .btn-drag {
                cursor: move;
            }
        </style>
        <script type="text/javascript">
          $('#consignee').select2();
          
          var products = '{!! $products !!}';

          function showProductSuggest(t) {
            t = $(t);

            t.next("ul").remove();                 
            var list = '';
            $.each(JSON.parse(products),function(i,obj) { 
                list += "<li data-id="+obj.id+" data-price="+obj.price+">"+obj.name+"</li>";        
            });

            t.after("<ul class='sub'>"+list+"</ul>"); 
          }

          $(document).on('click','.btn-plus',function() {            
            var tr_parent = $(this).parent().parent('tr');
            var clone = $('#tr-sample').clone();
            clone.removeAttr('id');
            tr_parent.after(clone);
            $('.table-display tr').not('#tr-sample').show();
          })

          $(document).mouseup(function (e)
          {
              var container = $(".sub");
              if (!container.is(e.target) 
                  && container.has(e.target).length === 0) 
              {
                  container.hide();
              }
          });

          $(document).on('click','.sub li',function() {
              var v = $(this).text();
              var id = $(this).data('id');
              $(this).parent('ul').prev('input[type=text]').val(v);
              $(this).parents('tr').find('input[type=hidden]').val(id);
              $(this).parent('ul').remove();
          })         

          $(document).on('click','.table-display .btn-delete',function() {
              var tr = $(this).parent().parent();
              var trPrev = tr.prev('tr');

              if(trPrev.length != 0) {
                  tr.remove();   
              }
          })
        </script>
        
@endsection