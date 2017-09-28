@if (session('success') || session('error'))
    @if(session('success'))
        <div class="notification is-success">
            <button class="delete"></button>
            {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="notification is-warning">
            <button class="delete"></button>
            {{ session('warning') }}
        </div>
    @endif
@endif