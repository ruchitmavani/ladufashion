@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="h4">Edit Bill</h4>
                </div>
                <div class="card-body">
                    <form method="post" id="form-add-bill">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">                        
                                    <select name="firm" id="firm-id"  required>
                                        <option></option>
                                        @foreach ($firms as $item)
                                            @if ($item->id == $bill->party_id)
                                                <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                            @else
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endif   
                                        @endforeach
                                    </select>
                                    <label for="firm-id" class="label-name">
                                        <span class="content-name" style="transform: translateY(-70%);font-size: 14px;">Firm</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="address" autocomplete="off" id="address" required />
                                    <label for="address" class="label-name">
                                        <span class="content-name">Address</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="state" autocomplete="off" id="state" required />
                                    <label for="state" class="label-name">
                                        <span class="content-name">State Code</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="gst" autocomplete="off" id="gst" required />
                                    <label for="gst" class="label-name">
                                        <span class="content-name">GST No.</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="date" name="bill_date" autocomplete="off" id="bill_date" required value="{{ date('Y-m-d', strtotime($bill->bill_date))}}"/>
                                    <label for="bill_date" class="label-name">
                                        <span class="content-name">Date</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="date" name="due_date" autocomplete="off" id="due_date" required value="{{ date('Y-m-d', strtotime($bill->due_date))}}"/>
                                    <label for="due_date" class="label-name">
                                        <span class="content-name">Due Date</span>
                                    </label>
                                </div>
                            </div>
                        </div>  
                        <hr>
                        <h5>Shipping Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="shipping_name" autocomplete="off" id="shipping_name" value="{{ $bill->shipping }}">
                                    <label for="shipping_name" class="label-name">
                                        <span class="content-name">Shippinng Name</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="shipping_address" autocomplete="off" id="shipping_address" value="{{ $bill->shipping_address }}">
                                    <label for="shipping_address" class="label-name">
                                        <span class="content-name">Shippinng Address</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="shipping_place" autocomplete="off" id="shipping_place" value="{{ $bill->shipping_place }}">
                                    <label for="shipping_place" class="label-name">
                                        <span class="content-name">Shippinng Place</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="challan_no" autocomplete="off" id="challan_no" required value="{{ $bill->challan }}">
                                    <label for="challan_no" class="label-name">
                                        <span class="content-name">Party Challan No.</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="date" name="challan_date" autocomplete="off" id="challan_date" value="{{ $bill->challan_date ? $bill->challan_date : '' }}">
                                    <label for="challan_date" class="label-name">
                                        <span class="content-name">Challan Date</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form method="post" id="form-product">
                        <hr>
                        <h5>Product Details</h5>
                        @foreach($bill->products as $product)
                        <div class="row p-data">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="p-name" name="p_name[]" autocomplete="off" id="p_name" value="{{$product['name']}}" required>
                                    <label for="p_naem" class="label-name">
                                        <span class="content-name">Product Name</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="p-hsn" name="hsn[]" autocomplete="off" id="hsn" value="{{$product['hsn']}}" required>
                                    <label for="hsn" class="label-name">
                                        <span class="content-name">HSN Code</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="number" name="qty[]" class="p-qty" step="any" autocomplete="off" value="{{$product['qty']}}" id="qty" required>
                                    <label for="qty" class="label-name">
                                        <span class="content-name">Qty.</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="number" name="rate[]" class="p-rate" step="any" autocomplete="off" value="{{$product['rate']}}" id="rate" required>
                                    <label for="rate" class="label-name">
                                        <span class="content-name">Rate</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                    </form>
                    <hr>
                    <form method="POST" id="form-summary">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" class="input-fixed" name="total_amount" step="any" autocomplete="off" id="total_amount" required readonly value="{{$bill->total_amount}}">
                                    <label for="total_amount" class="label-name">
                                        <span class="content-name">Total Amount</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="discount" step="any" autocomplete="off" id="discount" required value="{{$bill->discount}}">
                                    <label for="discount" class="label-name">
                                        <span class="content-name">Discount (%)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="cgst" step="any" autocomplete="off" id="cgst" required value="{{$bill->cgst }}">
                                    <label for="cgst" class="label-name">
                                        <span class="content-name">CGST (%)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="sgst" step="any" autocomplete="off" id="sgst" required value="{{$bill->sgst}}">
                                    <label for="sgst" class="label-name">
                                        <span class="content-name">SGST (%)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="igst" step="any" autocomplete="off" id="igst" required value="{{$bill->igst}}">
                                    <label for="igst" class="label-name">
                                        <span class="content-name">IGST (%)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="tax" step="any" autocomplete="off" id="tax" required value="{{$bill->tax}}">
                                    <label for="tax" class="label-name">
                                        <span class="content-name">TAX</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2 ml-auto">
                                <div class="form-group">
                                    <input type="number" class="input-fixed" name="final" step="any" autocomplete="off" id="final" required value="{{$bill->final_amount}}" readonly>
                                    <label for="final" class="label-name">
                                        <span class="content-name">Total Payable Amount</span>
                                    </label>
                                </div>
                            </div>
                            
                        </div>
                        <hr>
                        <h5>Bank Details</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="bank" id="bank" value="{{$bill->bank}}">
                                    <label for="bank" class="label-name">
                                        <span class="content-name">Bank Name</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="account_no" id="account_no" value={{$bill->account_no}}>
                                    <label for="account_no" class="label-name">
                                        <span class="content-name">Account no.</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="ifsc" id="ifsc" value={{$bill->ifsc}}>
                                    <label for="ifsc" class="label-name">
                                        <span class="content-name">IFSC Code</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <button class="btn btn-danger" type="button" onclick="location.reload()">Cancel</button>
                                <button class="btn btn-success" type="submit">SAVE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
    <script>
        let amount = 0, discount = 0, cgst = 0, sgst = 0, igst = 0, total = 0, tax = 0, firm_flag = 0;
        $(function(){
            get_firm_data({{$bill->party_id}});
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#firm-id').select2({
                placeholder: "Select Firm",
                theme: "material"
            });

            $(".select2-selection__arrow").html("<i class='fa fa-chevron-down'></i>");

            $("#firm-id").change(function(){
                get_firm_data($(this).val());
                
            });

            $("#form-product").submit(function(e){
                e.preventDefault();
            });
        });

        function countTotal(){
            amount = 0;

            $(".p-data").each(function(){
                amount = amount + ($(this).find(".p-qty").val() * $(this).find('.p-rate').val());
            })

            discount = ($("#discount").val() / 100) * amount;

            let temp = amount - discount;
            cgst = ($("#cgst").val() / 100) * temp;
            sgst = ($("#sgst").val() / 100) * temp;
            igst = ($("#igst").val() / 100) * temp;
            tax = cgst + sgst + igst;
            total = temp + tax;
            $("#tax").val(tax);
            $("#final").val(total);
            $("#total_amount").val(amount);
        }

        $("#discount, #igst, #sgst, #cgst, #tax, .p-rate, .p-qty").change(function(){
            countTotal();
        });

        $("#form-summary").submit(function(e){
            e.preventDefault();            

            let frmData = new FormData(this);
            let firmData = $("#form-add-bill").serializeArray();
            for (var i=0; i<firmData.length; i++)
                frmData.append(firmData[i].name, firmData[i].value); 

            let products = [];
            $(".p-data").each(function(){
                let product = new Object();
                product.name = $(this).find(".p-name").val();
                product.hsn = $(this).find(".p-hsn").val();;
                product.qty = $(this).find(".p-qty").val();;
                product.rate = $(this).find(".p-rate").val();;    
                products.push(product);
            })
            
            let finalProducts = [];
            products.forEach(function(item, i){                
                finalProducts.push(JSON.stringify(item));
            })
            frmData.append('products', finalProducts);

            frmData.append('tax', tax);
            frmData.append('id', "{{ $bill->id }}")
            $.ajax({
                url:"{{route('bills.update')}}",
                method:'post',
                data: frmData,
                processData: false,
                contentType: false,
                success:function(data){
                    if(data.success == true){
                        window.open(data.data.link);
                        location.reload();
                    }
                    else{
                        Swal.fire('Error!',  data.message, 'error');
                    }
                },
                error:function(data){
                    Swal.fire('Error!',  data.message, 'error');
                }
            })
        });

        function get_firm_data(id){
            let url = '{{route("firm.edit", ["id" => ":id"])}}';
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                method:'get',
                success:function(data){
                    $("#address").val(data.address);
                    $("#gst").val(data.gst);
                    $("#state").val(data.state);
                    $("#due_date").focus();
                },
                error:function(data){
                    Swal.fire('Error!', data.message, 'error');
                }
            })
        }
    </script>
@endsection