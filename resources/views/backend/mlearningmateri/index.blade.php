@extends('layouts/fulllayoutmaster')

@section('content')
    <div class="container-fluid">
        <h4 class="c-grey-900 mT-10 mB-30">Kelas M-Learning  / {{ $data['kelas']->user->name }} / {{ $data['kelas']->matapelajaran->nama_matapelajaran }}</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="c-grey-900">Materi M-Learning Data Table</h4>
                        <a href="{{ route('mlearningmateri.index') }}/materi/{{$id}}/create" title="Add" class="btn btn-primary ml-auto">Add</a>
                    </div>
                    <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Judul</th>
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
                url: "{{ route('mlearningmateri.index')  }}/datatable/ {{ $id }}",
                type: 'GET',
                data: function (d) {
                }
            },
            order: [[1, 'desc']],
            columns: [
                { data: 'judul', name: 'judul' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable:false },
            ],
        });
     
        $('#modalDelete').on('show.bs.modal', function (event) {
            var id = $(event.relatedTarget).data('id');
            $(this).find('.modal-body').find('a[name="id"]').attr('href', '{{ route("mlearningmateri.index") }}/'+ id);
        });

        $('#modalDelete').on('hidden.bs.modal', function (event) {
            $(this).find('.modal-body').find('a[name="id"]').attr('href', '');
        });

        $('#modalReset').on('show.bs.modal', function (event) {
            var id = $(event.relatedTarget).data('id');
            $(this).find('.modal-body').find('input[name="id"]').val(id);
        });

        $('#modalReset').on('hidden.bs.modal', function (event) {
            $(this).find('.modal-body').find('input[name="id"]').val('');
        });

        $("#formReset").submit(function(e){
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
              cache: false,
              processData: false,
              contentType: false,
              type: "POST",
              url : url,
              data : data,
              success: function(response) {
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                toastr.success(response.message,'Success !');
              },error: function(response){
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                toastr.error("Please complete your form",'Failed !');
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
                    toastr.success(response.message,'Success !');
                    form.text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm").html(btnHtml);
                    $('#modalDelete').modal('hide');
                    datatable.draw();
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