  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Theme toggle script -->
  <script>
      (function() {
          const root = document.documentElement;
          const btn = document.getElementById('themeToggle');

          function render() {
              const t = root.getAttribute('data-theme') || 'dark';
              btn.innerHTML = t === 'dark' ?
                  '<i class="bi bi-brightness-high"></i>' // sun = go light
                  :
                  '<i class="bi bi-moon-stars"></i>'; // moon = go dark
              btn.title = t === 'dark' ? 'Switch to light' : 'Switch to dark';
          }

          function setTheme(t) {
              root.setAttribute('data-theme', t);
              localStorage.setItem('theme', t);
              render();
          }
          render();
          btn.addEventListener('click', () => {
              setTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
          });
      })();
  </script>

  <!-- Start Walkthrough (Intro.js) -->
  <script>
      function startTour() {
          const steps = [{
                  element: document.querySelector('#sidebar'),
                  intro: "👋 Welcome! This is your sidebar. Navigate to all features from here."
              },
              {
                  element: document.querySelector('#searchInput'),
                  intro: "Search hustles, tools, or messages from here."
              },
              {
                  element: document.querySelector('#aiLaunchBtn'),
                  intro: "Launch the AI Copilot to generate plans and flows."
              },
              {
                  element: document.querySelector('#userMenuBtn'),
                  intro: "Open your account menu for Profile, Settings, and Sign out."
              },
              {
                  element: document.querySelector('#cardsGrid'),
                  intro: "Your top hustles and earnings overview live here."
              }
          ].filter(s => !!s.element); // ignore missing nodes safely

          introJs().setOptions({
              steps,
              showProgress: true,
              nextLabel: 'Next',
              prevLabel: 'Back',
              skipLabel: 'Skip',
              doneLabel: 'Done',
              exitOnOverlayClick: true,
              scrollToElement: true
          }).start();
      }
      document.getElementById('startTourBtn')?.addEventListener('click', startTour);
  </script>
  </body>

  </html>
