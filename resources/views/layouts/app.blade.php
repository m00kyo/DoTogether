<!doctype html>
<html lang="pl">

<head>
    <script>
        function zapytajOPowod(event) {
            event.preventDefault();
            let powod = prompt("Wpisz powód rezygnacji (opcjonalnie):");

            if (powod === null) {
                return false;
            }

            document.getElementById('cancel-reason-input').value = powod;

            document.getElementById('leave-form').submit();
        }
    </script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SpotkajmySię - Wydarzenia Grupowe</title>
    @stack('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
</head>

<body>
    @yield('content')
</body>

</html>
