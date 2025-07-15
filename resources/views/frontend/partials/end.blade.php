{{-- <script src="{{ asset('adminBumbu/sidebar.js') }}"> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Dropdown JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userMenuButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');
    
    if (userMenuButton && userDropdown) {
        // Toggle dropdown when button is clicked
        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        });
        
        // Close dropdown when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                userDropdown.classList.add('hidden');
            }
        });
    }
});
</script>

@stack('scripts')
</body>

</html>
