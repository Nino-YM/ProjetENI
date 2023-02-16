document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.btn-inscrire, .btn-desister');

    buttons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            var url = this.href;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', url);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    location.reload();
                } else {
                    console.log('Error:', xhr.status);
                }
            };
            xhr.send();
        });
    });
});
