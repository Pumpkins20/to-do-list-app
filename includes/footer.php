<!-- includes/footer.php -->
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2025 TaskMaster - Aplikasi To-Do List Sederhana</p>
        </div>
    </footer>
    <script>
        // Script untuk menghilangkan pesan alert setelah beberapa detik
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 3000);
            });
        });
    </script>
</body>
</html>