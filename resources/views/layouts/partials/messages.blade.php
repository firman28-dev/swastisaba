@if (isset($errors) && count($errors) > 0)
    <div class="notification is-danger is-light" id="errorAlert">
        @foreach ($errors->all() as $error)
            <strong>{{$error}}</strong> 
        @endforeach
    </div>
    {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
        <ul class="list-unstyled mb-0">
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div> --}}
@endif

{{-- @if (Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data)) 
        @foreach ($data as $msg)
            <div class="alert alert-warning" role="alert">
                <i class="fa fa-check"></i>
                {{ $msg }}
            </div>
        @endforeach 
    @else
    <div class="alert alert-warning" role="alert">
        <i class="fa fa-check"></i>
        {{ $data }}
    </div>
    @endif 
@endif --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function() {
            var alertElement = document.getElementById('errorAlert');
            if (alertElement) {
                alertElement.classList.remove('show');
                alertElement.classList.add('fade');
                alertElement.style.display = 'none';
            }
        }, 3000);
    });
</script>