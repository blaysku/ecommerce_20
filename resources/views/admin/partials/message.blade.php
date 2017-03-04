@if (session('message'))
    <div class="alert alert-{{ (session('level')) ? session('level') : 'success' }}">
        {{ session('message') }}
    </div>
@endif
