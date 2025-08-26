<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'success 🎉',
        text: '{{ session('success') }}',
        confirmButtonText: 'okay',
        confirmButtonColor: '#3085d6',
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif

@if(session('failed'))
<script>
    Swal.fire({
        title: ' error  😓',
        text: '{{ session('failed') }}',
        icon: 'error',
        confirmButtonText: 'okay',
        confirmButtonColor: '#e3342f',
        background: '#1f1f1f',
        color: '#fff',
        iconColor: '#ff4d4f',
        timer: 5000,
        timerProgressBar: true,
        backdrop: `
            rgba(0,0,0,0.7)
            url("https://media.giphy.com/media/NTur7XlVDUdqM/giphy.gif")
            left top
            no-repeat
        `
    });
</script>
@endif
