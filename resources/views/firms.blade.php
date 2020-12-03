@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="h4">Manage Firms</span>
                    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-firm">Add new</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover w-100" id="table-firms">
                            <thead>
                                <th>No.</th>
                                <th>Name</th>
                                <th>GST No.</th>
                                <th>State Code</th>
                                <th>Address</th>
                                <th>Action</th>    
                            </thead>  
                            <tbody>
                            </tbody>  
                        </table>    
                    </div>        
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-firm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form  method="post" id="form-firm">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Add Firm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="id" id="firm-id">
                    <div class="form-group">
                        <input type="text" name="name" autocomplete="off" id="name" required />
                        <label for="name" class="label-name">
                            <span class="content-name">Firm name</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="gst" autocomplete="off" id="gst" required />
                        <label for="gst" class="label-name">
                            <span class="content-name">GST No.</span>
                        </label>
                    </div>                
                    <div class="form-group">
                        <input type="text" name="state" autocomplete="off" id="state" required />
                        <label for="state" class="label-name">
                            <span class="content-name">State Code</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="address" autocomplete="off" id="address" required />
                        <label for="address" class="label-name">
                            <span class="content-name">Address</span>
                        </label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
  </div>
@endsection
@section('page-script')
    <script>
        let table;
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            table = $('#table-firms').DataTable( {
                ajax: {
                    url: '{{ route("firms") }}',
                },
                serverSide: true,
                processing: true,
                columns: [
                    { data: 'DT_RowIndex', width:"5%"},
                    { data: 'name' },
                    { data: 'gst' },
                    { data: 'state' },
                    { data: 'address'},
                    { data: 'action', searchable:false, orderable:false,  width:"7%"}
                ]
            });

            $("#modal-firm").on('hidden.bs.modal',  function(){
                $("#form-firm").trigger('reset');
                $("#firm-id").val('');
                $("#modal-title").html('Add Firm');
            })

            $("#form-firm").submit(function(e){
                e.preventDefault();
                $.ajax({
                    url : '{{ route("firm.store") }}',
                    method:'post',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success:function(data){
                        if(data.success == true){
                            Swal.fire('Success!',  data.message, 'success');
                            $("#modal-firm").modal('hide');
                            table.draw();
                        }
                        else{
                            Swal.fire('Error!',  data.message, 'error');
                        }
                    },
                    error:function(data){
                        Swal.fire('Error!',  data.message, 'error');
                    }
                })
            })
        })

        function edit_firm(id){
            let url = '{{route("firm.edit", ["id" => ":id"])}}';
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                method:'get',
                success:function(data){
                    $("#firm-id").val(data.id);
                    $("#name").val(data.name);
                    $("#address").val(data.address);
                    $("#gst").val(data.gst);
                    $("#state").val(data.state);
                    $("#modal-title").html('Edit Firm');
                    $("#modal-firm").modal('show');
                },
                error:function(data){
                    Swal.fire('Error!', data.message, 'error');
                }
            })
        }

        function delete_firm(id){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = '{{ route("firm.delete", ["id" => ":id"])}}';
                    url = url.replace(':id', id);
                    $.ajax({
                        url:url,
                        method:'get',
                        success:function(data){
                            if(data.success == true){
                                Swal.fire('Success!',  data.message, 'success');
                                table.draw();
                            }
                            else{
                                Swal.fire('Error!',  data.message, 'error');
                            }
                        },
                        error:function(data){
                            Swal.fire('Error!',  data.message, 'error');
                        }
                    })
                }
            })
        }
    </script>
@endsection