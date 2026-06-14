(function () {
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', function (event) {
            const message = form.getAttribute('data-confirm');

            if (!message || !window.confirm(message)) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    });
})();
