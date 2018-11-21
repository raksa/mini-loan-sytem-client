<div>
    @if(session()->has('success'))
    <div style="color: green">{{ session('success') }}</div>
    @endif
    @if(session()->has('info'))
    <div style="color: blue">{{ session('info') }}</div>
    @endif
    @if(session()->has('warning'))
    <div style="color: yellow">{{ session('warning') }}</div>
    @endif
    @if(session()->has('error'))
    <div style="color: red">{{ session('error') }}</div>
    @endif
    {{-- Validator error --}}
    @if (isset($errors) && $errors->any())
    @foreach ($errors->all() as $error)
        <div style="color: red">
            {{ $error }}
        </div>
    @endforeach
    @endif
</div>
