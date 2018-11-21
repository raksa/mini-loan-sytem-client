<div>
    @if(session()->has('success'))
    <div>
        {{ session('success') }}</div>
    @endif
    @if(session()->has('info'))
    <div>
        {{ session('info') }}</div>
    @endif
    @if(session()->has('warning'))
    <div>
        {{ session('warning') }}</div>
    @endif
    @if(session()->has('error'))
    <div>
        {{ session('error') }}</div>
    @endif
    {{-- Validator error --}}
    @if (isset($errors) && $errors->any())
    @foreach ($errors->all() as $error)
        <div>
            {{ $error }}
        </div>
    @endforeach
    @endif
</div>
