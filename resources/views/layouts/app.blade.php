<!doctype html>
<html lang="pl">

<head>
    <script>
        (function () {
            const theme = localStorage.getItem('theme') || 
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
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

    <div class="theme-toggle-container">
        <button id="theme-toggle" class="theme-toggle-btn" aria-label="Przełącz motyw">
            <i class="fa-solid fa-moon"></i>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('theme-toggle');
            const icon = toggleBtn.querySelector('i');
            
            function updateIcon(theme) {
                if (theme === 'dark') {
                    icon.className = 'fa-solid fa-sun';
                } else {
                    icon.className = 'fa-solid fa-moon';
                }
            }

            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            updateIcon(currentTheme);

            toggleBtn.addEventListener('click', () => {
                const current = document.documentElement.getAttribute('data-theme');
                const target = current === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-theme', target);
                localStorage.setItem('theme', target);
                updateIcon(target);
            });
        });
    </script>
</body>

</html>
