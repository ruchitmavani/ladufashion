@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="h4">Add New Bill</h4>
                </div>
                <div class="card-body">
                    <form method="post" id="form-add-bill">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">                        
                                    <select name="firm" id="firm-id"  required>
                                        <option></option>
                                        @foreach ($firms as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
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
                                    <input type="date" name="bill_date" autocomplete="off" id="bill_date" required value="{{ date('Y-m-d')}}"/>
                                    <label for="bill_date" class="label-name">
                                        <span class="content-name">Date</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="date" name="due_date" autocomplete="off" id="due_date" required value="{{ date('Y-m-d')}}"/>
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
                                    <input type="text" name="shipping_name" autocomplete="off" id="shipping_name">
                                    <label for="shipping_name" class="label-name">
                                        <span class="content-name">Shippinng Name</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="shipping_address" autocomplete="off" id="shipping_address">
                                    <label for="shipping_address" class="label-name">
                                        <span class="content-name">Shippinng Address</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="shipping_place" autocomplete="off" id="shipping_place">
                                    <label for="shipping_place" class="label-name">
                                        <span class="content-name">Shippinng Place</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="challan_no" autocomplete="off" id="challan_no" required>
                                    <label for="challan_no" class="label-name">
                                        <span class="content-name">Party Challan No.</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="date" name="challan_date" autocomplete="off" id="challan_date">
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="p_name" autocomplete="off" id="p_name" required>
                                    <label for="p_naem" class="label-name">
                                        <span class="content-name">Product Name</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" name="hsn" autocomplete="off" id="hsn" required>
                                    <label for="hsn" class="label-name">
                                        <span class="content-name">HSN Code</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="qty" step="any" autocomplete="off" id="qty" required>
                                    <label for="qty" class="label-name">
                                        <span class="content-name">Qty.</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="rate" step="any" autocomplete="off" id="rate" required>
                                    <label for="rate" class="label-name">
                                        <span class="content-name">Rate</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" type="submit">Add Product</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>Sr. No.</th>
                                <th>Product Name</th>
                                <th>HSN Code</th>
                                <th>Qty.</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th></th>
                            </thead>
                            <tbody id="product-list"></tbody>
                        </table>
                    </div>
                    <form method="POST" id="form-summary">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" class="input-fixed" name="total_amount" step="any" autocomplete="off" id="total_amount" required readonly value="0">
                                    <label for="total_amount" class="label-name">
                                        <span class="content-name">Total Amount</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="discount" step="any" autocomplete="off" id="discount" required value="0">
                                    <label for="discount" class="label-name">
                                        <span class="content-name">Discount (%)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="cgst" step="any" autocomplete="off" id="cgst" required value="0">
                                    <label for="cgst" class="label-name">
                                        <span class="content-name">CGST (%)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="sgst" step="any" autocomplete="off" id="sgst" required value="0">
                                    <label for="sgst" class="label-name">
                                        <span class="content-name">SGST (%)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="igst" step="any" autocomplete="off" id="igst" required value="0">
                                    <label for="igst" class="label-name">
                                        <span class="content-name">IGST (%)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="tax" step="any" autocomplete="off" id="tax" required value="0">
                                    <label for="tax" class="label-name">
                                        <span class="content-name">TAX</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2 ml-auto">
                                <div class="form-group">
                                    <input type="number" class="input-fixed" name="final" step="any" autocomplete="off" id="final" required value="0" readonly>
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
                                    <input type="text" name="bank" id="bank">
                                    <label for="bank" class="label-name">
                                        <span class="content-name">Bank Name</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="account_no" id="account_no">
                                    <label for="account_no" class="label-name">
                                        <span class="content-name">Account no.</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="ifsc" id="ifsc">
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
        let products = [], deleted = [];
        let amount = 0, discount = 0, cgst = 0, sgst = 0, igst = 0, total = 0, tax = 0, firm_flag = 0;
        $(function(){
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
                firm_flag = 1;
                let url = '{{route("firm.edit", ["id" => ":id"])}}';
                url = url.replace(':id', $(this).val());
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
            });

            $("#form-product").submit(function(e){
                e.preventDefault();
                addProduct($("#p_name").val(), $("#hsn").val(), $("#qty").val(), $("#rate").val());
                $(this).trigger('reset');
                $("#p_name").focus();
            });
        });

        function addProduct(name, hsn, qty, rate){
            let product = new Object();
            product.name = name;
            product.hsn = hsn;
            product.qty = qty;
            product.rate = rate;    
            let index = products.push(product) - 1;
            $("#product-list").append("<tr><td>"+($("#product-list").children().length + 1 )+"</td><td>"+name+"</td><td>"+hsn+"</td><td>"+qty+"</td><td>"+rate+"</td><td>"+(rate * qty)+"</td><td><button class='btn btn-danger btn-icon' onclick='deleteProduct(this, "+index+")'><i class='far fa-trash-alt'></i></td></tr>"); 
            countTotal();
        }

        function deleteProduct(el, index){
            let count = 0;
            $(el).parentsUntil('tbody').remove();
            $("#product-list").children().each(function(){
                $(this).find('td').first().html(++count);
            });
            deleted.push(index);
            countTotal();
        }

        function countTotal(){
            amount = 0;
            products.forEach(function(item, i){
                if(!deleted.includes(i)){
                    amount = amount + item.rate * item.qty;
                }
            });
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

        $("#discount, #igst, #sgst, #cgst, #tax").change(function(){
            countTotal();
        });

        $("#form-summary").submit(function(e){
            e.preventDefault();
            if(firm_flag == 0){
                Swal.fire('Please select firm', '', 'warning').then(function(){
                    $("#firm-id").select2('open');
                });
                return;
            }
            if(products.length == 0 || deleted.length == products.length){
                Swal.fire('Please add product', '', 'warning').then(function(){
                    $("#p_name").focus();
                });
                return;
            }

            let frmData = new FormData(this);
            let firmData = $("#form-add-bill").serializeArray();
            for (var i=0; i<firmData.length; i++)
                frmData.append(firmData[i].name, firmData[i].value); 
            
            let finalProducts = [];
            products.forEach(function(item, i){
                if(!deleted.includes(i)){
                    finalProducts.push(JSON.stringify(item));
                }
            })
            frmData.append('products', finalProducts);
            frmData.append('tax', tax);
            $.ajax({
                url:"{{route('save')}}",
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
    </script>
@endsection