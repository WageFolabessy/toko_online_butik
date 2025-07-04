<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.datatable').DataTable({
            language: {
                url: '{{ asset('assets/admin/vendor/id.json') }}',
            },
            responsive: true
        });
    });
</script>