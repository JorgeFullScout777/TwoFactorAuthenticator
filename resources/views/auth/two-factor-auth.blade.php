<x-guest-layout>
    @vite(['resources/css/app.css', 'resources/css/custom-styles.css'])
    <form action="{{ route('two-factor.verify') }}" method="POST">
        @csrf
        <label for="code">Two-Factor Code</label>
        <input type="number" class="text-field" name="code" id="code" required>
        <button class="save-button" type="submit">Verify</button>
    </form>
    <button id="resend-code" class="edit-button" type="button">Reenviar Codigo</button>
    <span id="countdown"></span>


    @if ($errors->any())
        <div>
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
        </div>
    @endif

    <script>
        function enableButton() {
            const button = document.getElementById('resend-code');
            button.disabled = false;
            button.classList.remove('desactivated-button');
            document.getElementById('countdown').textContent = ''; // Clear countdown text
        }

        function disableButton() {
            const button = document.getElementById('resend-code');
            button.disabled = true;
            button.classList.add('desactivated-button');
            let countdown = 30;
            const countdownElement = document.getElementById('countdown');
            countdownElement.textContent = ` (${countdown}s)`;

            const interval = setInterval(() => {
                countdown -= 1;
                countdownElement.textContent = ` (${countdown}s)`;
                if (countdown <= 0) {
                    clearInterval(interval);
                    enableButton();
                }
            }, 1000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            disableButton(); // Deshabilitar el botón al cargar la página
        });

        document.getElementById('resend-code').addEventListener('click', function() {
            fetch('{{ route('two-factor.resend') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Manejar la respuesta aquí
                //console.log(data);
            })
            .catch(error => {
                //console.error('Error:', error);
            });

            disableButton(); // Deshabilitar el botón al hacer clic
        });
    </script>
</x-guest-layout>