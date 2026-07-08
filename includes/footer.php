<?php
/**
 * Componente modular: Pie de Página (Footer)
 * Proyecto Integrador - 3° BTI CRECE
 */
?>
    <!-- Pie de Página Institucional -->
    <footer class="footer-institutional">
        <div class="footer-container">

            
            <div class="footer-credits" id="footer-copyright" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
                <div>
                    <p>&copy; <?php echo date('Y'); ?> 3° BTI - Centro Regional de Educación de Ciudad del Este (CRECE).</p>
                </div>
                <div style="font-size: 0.8rem; font-weight: 600; color: var(--color-primary);">
                    Desarrollado por Joseph Fretez, Arnaldo Romero, Mathias Galeano
                </div>
            </div>
        </div>
    </footer>

    <!-- ============================================================
         Script del Menú Móvil — Hamburguesa interactiva mejorada
         ============================================================ -->
    <script>
    (function () {
        const toggle  = document.getElementById('mobileMenuToggle');
        const overlay = document.getElementById('navMobileOverlay');
        if (!toggle || !overlay) return;

        let isOpen = false;

        function openMenu() {
            isOpen = true;
            toggle.classList.add('is-open');
            overlay.classList.add('is-open');
            toggle.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = '';
        }

        function closeMenu() {
            isOpen = false;
            toggle.classList.remove('is-open');
            overlay.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
        }

        toggle.addEventListener('click', () => {
            isOpen ? closeMenu() : openMenu();
        });

        // Cerrar al hacer clic en un enlace del menú móvil
        overlay.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        // Cerrar al hacer clic fuera del menú
        document.addEventListener('click', (e) => {
            if (isOpen && !overlay.contains(e.target) && !toggle.contains(e.target)) {
                closeMenu();
            }
        });

        // Cerrar al cambiar a pantalla grande
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768 && isOpen) {
                closeMenu();
            }
        });

        // Cerrar con tecla Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isOpen) closeMenu();
        });
    })();
    </script>
</body>
</html>
