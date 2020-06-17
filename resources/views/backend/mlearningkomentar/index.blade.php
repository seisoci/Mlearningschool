@extends('layouts/fulllayoutmaster')

@section('content')
<div class="container-fluid">
    <h4 class="c-grey-900 mT-10 mB-30">Kelas M-Learning  / {{ $data['kelas']['kelas']->user->name }} / {{ $data['kelas']['kelas']->matapelajaran->nama_matapelajaran }}</h4>
    <div class="row bgc-white bd bdrs-3 p-20 mB-20">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-3">
                <h4 class="c-grey-900">Komentar materi {{ $data['materi']->judul }}</h4>
                <button title="Add" data-toggle="modal" data-target="#modalAdd" class="btn btn-primary ml-auto">Add</button>
            </div>
        </div>
        @foreach ($data['komentar'] as $item)
        <div class="col-md-12">
            <div class="c-grey-900" style="background: #f7f7f7cf; padding: 10px 20px; margin:5px 0">
                <span>
                  <img src="{{ $item->user->image != NULL ? asset("storage/images/original/") .$item->user->image  : asset('images/noimage.svg') }}" width="50" height="50">
                </span>
                <span>
                  <a href="#">{{ $item->user->name }}</a> 
                <span class="d-block">{{ $item->created_at }}</span>
                </span>
                <p>{{ $item->komentar }}</p>
                <div class="d-flex justify-content-end">
                    <a href="#" class="btn btn-outline-danger" title="Delete" data-toggle="modal" data-target="#modalDelete" data-id="{{ $item->id }}"><i class="c-deep-blue-500 ti-trash"></i> Delete</a>
                </div>
            </div>
        </div>  
        @endforeach
        <div class="col-md-12 mt-3 d-flex justify-content-center">
            {{ $data['komentar']->links() }}
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
        <form id="formStore" action="{{ route('mlearningkomentar.store') }}">
        <div class="modal-body">
            @csrf
            <input type="hidden" name="users_id" value="{{ Auth::id() }}">
            <input type="hidden" name="materi_mlearning_id" value="{{ $data['kelas_mlearning_id']  }}">
            <div class="form-group">
                <label for="exampleInput">Komentar</label>
                <textarea rows="8" class="form-control" name="komentar" placeholder="Tulis Komentar"></textarea>
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
        $('#modalAdd').on('show.bs.modal', function (event) {
        });

        $('#modalAdd').on('show.bs.modal', function (event) {
        });

        $('#modalDelete').on('show.bs.modal', function (event) {
            var id      = $(event.relatedTarget).data('id');
            $(this).find('.modal-body').find('a[name="id"]').attr('href', '{{ route("mlearningkomentar.index") }}/'+ id);
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
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }else{
                    $("[role='alertform']").css('display','block').html('');
                    $.each( response.error, function( key, value ) {
                        $("[role='alertform']").append('<span style="display: block">'+value+'</span>');
                    });
                    toastr.error(response.message,'Failed !');
                }
            },
            error: function(response){
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                $('#modalAdd').modal('hide');
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
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                    $('#modalDelete').modal('hide');
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