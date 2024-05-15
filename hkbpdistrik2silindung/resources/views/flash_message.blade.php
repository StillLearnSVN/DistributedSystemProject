@if ($message = Session::get('success'))
    <script>
        $.toast({
            heading: 'Success',
            text: '{{ session('success') }}',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'success',
            hideAfter: 1500,
            stack: 6
        });
    </script>
@endif

@if ($message = Session::get('error'))
<script>
        $.toast({
            heading: 'Error',
            text: err_value,
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 1500,
            stack: 6
        });
    </script>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>{{ $message }}</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <strong>{{ $message }}</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Please check the form below for errors</strong>
  <strong>{{ $errors }}</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
