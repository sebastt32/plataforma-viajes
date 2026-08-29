@if (session('status'))
    <x-alert type="success">{{ session('status') }}</x-alert>
@endif

@if ($errors->any())
    <x-alert type="error">
        <ul class="list-disc ps-4 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif
