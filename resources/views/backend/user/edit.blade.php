@extends('layouts/fulllayoutmaster')

@section('content')
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item col-md-6">
            <div class="bgc-white p-20 bd">
                <h6 class="c-grey-900">Edit User</h6>
                <div class="mT-30">
                    <form id="formUpdate" action="{{ route('user.update', Request::segment(3)) }}">
                        @csrf
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        @method('PUT')
                        <img id="avatar" src="{{ $data->image != NULL ? asset("storage/images/original/$data->image")  : asset('images/noimage.svg') }}" class=" mb-3" height="200" width="200">
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="customFile" name="image">
                            <label class="custom-file-label" for="customFile"  accept=".jpg, .jpeg, .png">Choose image</label>
                        </div>
                        <div class="form-group">
                            <label for="InputName">Nama Lengkap</label> 
                            <input name="name" type="text" class="form-control" id="InputName" placeholder="Enter Name" value="{{ $data->name ?? NULL}}" />
                        </div>
                        <div class="form-group">
                            <label for="InputName">NIS/NIK</label> 
                            <input name="nis" type="text" class="form-control" id="InputName" placeholder="Enter NIS/NIK" value="{{ $data->nis ?? NULL}}" />
                        </div>
                        <div class="form-group">
                            <label for="InputEmail">Email</label> 
                            <input name="email" type="email" class="form-control" id="InputEmail1" placeholder="Enter Email" value="{{ $data->email ?? NULL}}" />
                        </div>
                        <div class="form-group">
                            <label for="Selectkelas">Kelas</label>
                            <select name="kelas" class="form-control" id="Selectkelas">
                                @if ($data->kelas == NULL & empty($data->kelas))
                                    <option selected value="">None</option>
                                @endif
                                @foreach ($kelas as $item)
                                    @if ($item->nama_kelas == $data->kelas)
                                    <option selected value="{{ $item->nama_kelas }}">{{ $item->nama_kelas }}</option>
                                    @endif
                                    <option value="{{ $item->nama_kelas }}">{{ $item->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(Auth::user()->role == 'admin')
                        <div class="form-group">
                            <label for="Select2">Role</label>
                            <select name="role" class="form-control" id="Select2">
                                <option value="admin" {{ $data->role == 'admin' ? 'selected' : NULL }}>Admin</option>
                                <option value="guru" {{ $data->role == 'guru' ? 'selected' : NULL }}>Guru</option>
                                <option value="siswa" {{ $data->role == 'siswa' ? 'selected' : NULL }}>Siswa</option>
                            </select>
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="masonry-item col-md-6">
            <div class="bgc-white p-20 bd">
                <div class="alert alert-danger" role="alertform" style="display:none">
            </div>
        </div>
    </div>
@endsection
@section('javascript')
<script>
   $(document).ready(function(){
        function readURL(input) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
            }
        }

        $(":file").change(function() {
            readURL(this);
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
                setTimeout(function() {
                    window.location.href = "{{route('user.index')}}"
                }, 3000);
                }else{
                $("[role='alertform']").css('display','block').html('');
                $.each( response.error, function( key, value ) {
                    $("[role='alertform']").append('<span style="display: block">'+value+'</span>');
                });
                toastr.error("Please complete your form",'Failed !');
                }
            },error: function(response){
                form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                toastr.error("Please complete your form",'Failed !');
            }
            });
        });
    });
</script>
@endsection