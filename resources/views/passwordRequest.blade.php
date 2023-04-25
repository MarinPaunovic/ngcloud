<div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div>Password Reset</div>
    <form action="{{ route('password.email') }}" method="post">
        @csrf
        <input type="text" id="email" name="email" placeholder="Email" required />
        <button>pw reset</button>
    </form>
</div>
