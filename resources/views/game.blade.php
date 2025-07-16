<x-app-layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4 w-100" style="max-width: 400px;">
            <h2 class="text-center mb-4">Guess the Number Game</h2>

            @if(session('message'))
                <div class="alert alert-success text-center">
                    {{ session('message') }}
                </div>
                <a class="btn btn-primary" href="{{ route('game.index') }}">Play Again</a>
            @else
                <form method="POST" action="{{ route('game.guess') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="number" name="guess" min="1" max="10" required class="form-control" placeholder="Enter your guess (1–10)">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Guess</button>
                    </div>
                </form>

                @if(session('hint'))
                    <div class="alert alert-warning mt-3 text-center">
                        Hint: Try {{ session('hint') }}
                    </div>
                @endif
            @endif

            @if($bestScore)
                <p class="text-center mt-4 mb-0">Your best score: <strong>{{ $bestScore }}</strong> guesses</p>
            @endif
        </div>
    </div>
</x-app-layout>
