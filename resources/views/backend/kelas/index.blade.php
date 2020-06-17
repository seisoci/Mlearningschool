@extends('layouts/fulllayoutmaster')

@section('content')
    <div class="container-fluid">
        <h4 class="c-grey-900 mT-10 mB-30">Kelas Tables</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="c-grey-900">Kelas Data Table</h4>
                        <button title="Add" data-toggle="modal" data-target="#modalAdd" class="btn btn-primary ml-auto">Add</button>
                    </div>
                    <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nama Kelas</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama Kelas</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formStore" action="{{ route('kelas.store') }}">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="exampleInput">Nama Kelas</label>
                    <input type="text" class="form-control" name="nama_kelas" placeholder="Nama Kelas">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
    </div>
    <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formUpdate" action="">
            <div class="modal-body">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="exampleInput">Nama Kelas</label>
                    <input type="text" class="form-control" name="nama_kelas" placeholder="Nama Kelas">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
    </div>
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                @method('DELETE')
                <div class="modal-body">
                    <a href="" type="hidden" name="id" disabled></a>
                    <p>Are you sure you want to delete this item?</p>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button id="formDelete" type="button" class="btn btn-danger">Save</button>
            </div>
          </div>
        </div>
    </div>
@endsection
@section('javascript')
<script>
   $(document).ready(function(){
        var datatable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            scrollX: true,
            ajax: {
                url: "{{ route('kelas.datatable')}}",
                type: 'GET',
                data: function (d) {
                    d.guru = $('#guru').val();
                    d.user = $('#user').val();
                    d.kelas = $('#kelas').val();
                }
            },
            order: [[0, 'asc']],
            columns: [
                { data: 'nama_kelas', name: 'nama_kelas' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false },
            ],
        });

        $('#modalAdd').on('show.bs.modal', function (event) {
        });

        $('#modalAdd').on('show.bs.modal', function (event) {
            $(this).find('.modal-body').find('input[name="nama_kelas"]').val('');
        });

        $('#modalUpdate').on('show.bs.modal', function (event) {
            var id = $(event.relatedTarget).data('id');
            var nama_kelas = $(event.relatedTarget).data('name');
            $(this).find('#formUpdate').attr('action', '{{ route("kelas.index") }}/'+ id);
            $(this).find('.modal-body').find('input[name="nama_kelas"]').val(nama_kelas);
        });

        $('#modalUpdate').on('hidden.bs.modal', function (event) {
            $(this).find('#formUpdate').attr('action', '');
            $(this).find('.modal-body').find('a[name="id"]').attr('href', '');
        });

        $('#modalDelete').on('show.bs.modal', function (event) {
            var id = $(event.relatedTarget).data('id');
            $(this).find('.modal-body').find('a[name="id"]').attr('href', '{{ route("kelas.index") }}/'+ id);
        });

        $('#modalDelete').on('hidden.bs.modal', function (event) {
            $(this).find('.modal-body').find('a[name="id"]').attr('href', '');
        });

        $("#formStore").submit(function(e){
            e.preventDefault();
            var form 	= $(this);
            var btnHtml = form.find("[type='submit']").html();
            var spinner = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
            var url 	= form.attr("action");
            var data 	= new FormData(this);
            $.ajax({
            beforeSend:function() {
                form.find("[type='submit']").prop('disabled', true).text(' Loading. . .').prepend(spinner);
            },
            cache: false,
            processData: false,
            contentType: false,
            type: "POST",
            url : url,
            data : data,
            success: function(response) {
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                if ( response.status == "success" ){
                    toastr.success(response.message,'Success !');
                    $('#modalAdd').modal('hide');
                    datatable.draw();
                }else{
                    $("[role='alertform']").css('display','block').html('');
                    $.each( response.error, function( key, value ) {
                        $("[role='alertform']").append('<span style="display: block">'+value+'</span>');
                        datatable.draw();
                    });
                    toastr.error("Please complete your form",'Failed !');
                }
            },
            error: function(response){
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                $('#modalAdd').modal('hide');
                toastr.error("Please complete your form",'Failed !');
                datatable.draw();
            }
            });
        });

        $("#formUpdate").submit(function(e){
            e.preventDefault();
            var form 	  = $(this);
            var btnHtml = form.find("[type='submit']").html();
            var spinner = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
            var url 	  = form.attr("action");
            var data 	  = new FormData(this);
            $.ajax({
            beforeSend:function() {
                form.find("[type='submit']").prop('disabled', true).text(' Loading. . .').prepend(spinner);
            },
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            processData: false,
            contentType: false,
            type: "POST",
            url : url,
            data : data,
            success: function(response) {
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                if ( response.status == "success" ){
                    toastr.success(response.message,'Success !');
                    $('#modalUpdate').modal('hide');
                        datatable.draw();
                }else{
                    $("[role='alertform']").css('display','block').html('');
                    $.each( response.error, function( key, value ) {
                        $("[role='alertform']").append('<span style="display: block">'+value+'</span>');
                                datatable.draw();
                    });
                    toastr.error("Please complete your form",'Failed !');
                }
            },
            error: function(response){
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                toastr.error("Please complete your form",'Failed !');
                datatable.draw();
            }
            });
        });

        $("#formDelete").click(function(e){
            e.preventDefault();
            var form 	    = $(this);
            var url 	    = $('#modalDelete').find('a[name="id"]').attr('href');
            var btnHtml   = form.html();
            var _token    = "{{ csrf_token() }}";
            var spinner   = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
            $.ajax({
                beforeSend:function() {
                form.text(' Loading. . .').prepend(spinner);
                },
                type: 'DELETE',
                url: url,
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data   : {
                '_token':_token
                },
                success: function (response) {
                    form.text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
                    if ( response.status == "success" ){
                        toastr.success(response.message,'Success !');
                        $('#modalDelete').modal('hide');
                        datatable.draw();
                    }else{
                        $("[role='alertform']").css('display','block').html('');
                        $.each( response.error, function( key, value ) {
                            $("[role='alertform']").append('<span style="display: block">'+value+'</span>');
                            datatable.draw();
                        });
                        toastr.error("Please complete your form",'Failed !');
                    }
                },
                error: function (response) {
                    toastr.error(response.responseJSON.message ,'Failed !');
                    form.text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
                        $('#modalDelete').find('a[name="id"]').attr('href', '');
                }
            });
        });
    });
</script>
@endsection