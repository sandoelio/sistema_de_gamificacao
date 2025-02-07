@extends('layouts.app')

@section('title', 'Jogar')

@section('content')
<div class="container mt-4 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Painel de Informações -->
            <div class="alert alert-info">
                <h4>Pontuação Atual: <strong>{{ $currentScore }}</strong></h4>
            </div>

            <!-- Timer -->
            <div class="alert alert-warning">
                <h5>Tempo restante: <span id="timer">30</span> segundos</h5>
            </div>

            <!-- Exibição da Pergunta -->
            <div class="card shadow-lg p-3 mb-4 bg-white rounded">
                <div class="card-body">
                    <h3 class="card-title">{{ $question->question_text }}</h3>
                    @if ($question->image)
                        <div class="text-center my-3">
                            <img src="data:image/png;base64,{{ $question->image }}" alt="Imagem da pergunta" class="img-fluid" style="max-width:300px;">
                        </div>
                    @endif
                    <p class="text-success"><strong>Pontos por acerto: {{ $question->points }}</strong></p>
                    <p class="text-danger"><strong>Pontos perdidos se errar: {{ round($question->points * 0.5) }} pontos</strong></p>
                </div>
            </div>

            <!-- Formulário para enviar a resposta -->
            <form action="{{ route('game.submitAnswer') }}" method="POST">
                @csrf
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <div class="input-group mb-3">
                    <input type="text" name="user_answer" id="user_answer" class="form-control" placeholder="Sua resposta..." required>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Enviar Resposta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Timer de 30 segundos
    let timeLeft = 30;
    let timerElement = document.getElementById("timer");
    let answerInput = document.getElementById("user_answer");
    let submitButton = document.getElementById("submitBtn");

    let countdown = setInterval(function() {
        if (timeLeft <= 0) {
            clearInterval(countdown);
            // Redireciona para a página de Game Over com os pontos atualizados
            window.location.href = "{{ route('game.over') }}";
        } else {
            timerElement.innerHTML = timeLeft;
        }
        timeLeft--;
    }, 1000);
</script>
@endsection
