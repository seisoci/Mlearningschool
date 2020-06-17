<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
	<title>Dashboard</title>
	<style>
        tfoot{display: none;}
		#loader{transition:all .3s ease-in-out;opacity:1;visibility:visible;position:fixed;height:100vh;width:100%;background:#fff;z-index:90000}#loader.fadeOut{opacity:0;visibility:hidden}.spinner{width:40px;height:40px;position:absolute;top:calc(50% - 20px);left:calc(50% - 20px);background-color:#333;border-radius:100%;-webkit-animation:sk-scaleout 1s infinite ease-in-out;animation:sk-scaleout 1s infinite ease-in-out}@-webkit-keyframes sk-scaleout{0%{-webkit-transform:scale(0)}100%{-webkit-transform:scale(1);opacity:0}}@keyframes sk-scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}100%{-webkit-transform:scale(1);transform:scale(1);opacity:0}}
        .toast {
        background-color: #030303 !important;
        }
        .toast-success {
        background-color: #51A351 !important;
        }
        .toast-error {
        background-color: #BD362F !important;
        }
        .toast-info {
        background-color: #2F96B4 !important;
        }
        .toast-warning {
        background-color: #F89406 !important;
        }
    </style>
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themify/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
</head>

<body class="app">
	<div id="loader">
		<div class="spinner"></div>
	</div>
	<script>
		window.addEventListener('load', function load() {
		        const loader = document.getElementById('loader');
		        setTimeout(function() {
		          loader.classList.add('fadeOut');
		        }, 300);
		      });
	</script>
	<div>
        @include('layouts.sidebar')
		<div class="page-container">
            @include('layouts.header')
			<main class="main-content bgc-grey-100">
				<div id="mainContent">
					@yield('content')
				</div>
			</main>
			@include('layouts.footer')
		</div>
    </div>
    <div class="modal fade" id="modalChange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formChange" method="POST" action="{{route('user.index')}}/changepassword/{{ Auth::id() }}">
            <div class="modal-body">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label for="exampleInput">Old Password</label>
                    <input type="password" class="form-control" name="old_password" placeholder="Old Password">
                </div>
                <div class="form-group">
                    <label for="exampleInput">New Password</label>
                    <input type="password" class="form-control" name="password" placeholder="New Password">
                </div>
                <div class="form-group">
                    <label for="exampleInput">Retype New Password</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Retype New Password">
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

    <script type="text/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vendor.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/bundle.js') }}"></script>
    @yield('javascript')
    <script>
        $(function() {
            $('#modalChange').on('show.bs.modal', function (event) {
            });

            $('#modalChange').on('show.bs.modal', function (event) {
                $(this).find('.modal-body').find('input[name="old_password"]').val('');
                $(this).find('.modal-body').find('input[name="password"]').val('');
                $(this).find('.modal-body').find('input[name="password_confirmation"]').val('');
            });
            $("#formChange").submit(function(e){
                e.preventDefault();
                var form 	  = $(this);
                var btnHtml = form.find("[type='submit']").html();
                var spinner = $('<span role="status" class="spinner-border spinner-border-sm" aria-hidden="true"></span>');
                var url 	  = form.attr("action");
                var data 	  = new FormData(this);
                $.ajax({
                beforeSend:function() {
                    form.find(".loading").prop('disabled', true).text(' Loading. . .').prepend(spinner);
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
                        $('#modalChange').modal('hide');
                        $('.modal-backdrop').remove();
                    }else{
                    $("[role='alertspan']").css('','block').html('');
                        $.each( response.error, function( key, value ) {
                            $("[role='alertspan']").append('<span style="display: block">'+value+'</span>');
                        });
                        toastr.error("Password not match",'Failed !');
                        
                    }
                },error: function(response){
                    form.find("[type='submit']").prop('disabled', false).text('Submit').find("[role='status']").removeClass("spinner-border spinner-border-sm");
                    toastr.error("Please complete your form",'Failed !');
                }
                });
            });
        });
    </script>
</body>

</html>