window.addEventListener('notify', event => {
    const headerHeight = document.getElementById('header')?.offsetHeight || 0;

    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000",
        "showDuration": "300",
        "hideDuration": "300",
        "extendedTimeOut": "1000",
        "preventDuplicates": true,
        "newestOnTop": true,
        "onShown": function() {
            const toasts = document.querySelectorAll('.toast-top-right');
            toasts.forEach(toast => {
                toast.style.top = (headerHeight + 10) + 'px'; // 10px de folga abaixo do header
            });
        }
    };

    toastr.success(event.detail);
});

$(document).ready(function() {
    $('.select2').select2({
       // tags: true
    });
});

