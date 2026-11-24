document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.password-toggle').forEach(function (button) {

        button.addEventListener('click', function () {

            const input = document.getElementById(
                this.dataset.target
            );

            if (!input) return;

            const isPassword = input.type === 'password';

            input.type = isPassword ? 'text' : 'password';

            this.textContent = isPassword ? 'Hide' : 'Show';
        });

    });

});

// login

const portalButtons = document.querySelectorAll('.portal-btn');
const loginRole = document.getElementById('loginRole');

portalButtons.forEach(function (button) {

    button.addEventListener('click', function () {

        portalButtons.forEach(function (item) {
            item.classList.remove('active');
        });

        this.classList.add('active');

        if (loginRole) {
            loginRole.value = this.dataset.role;
        }

    });

});