
const menuToggle = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');

if (menuToggle && sidebar) {
    menuToggle.addEventListener('click', function () {
        sidebar.classList.toggle('open');
    });
}

document.addEventListener('click', function (event) {
    if (
        window.innerWidth <= 768 &&
        sidebar &&
        menuToggle &&
        !sidebar.contains(event.target) &&
        !menuToggle.contains(event.target)
    ) {
        sidebar.classList.remove('open');
    }
});

function confirmDelete(button) {
    const confirmed = confirm(
        'Are you sure you want to move this employee to trash?'
    );

    if (confirmed) {
        button.closest('form').submit();
    }
}
// photo

document.addEventListener('DOMContentLoaded', function () {

    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photoPreview');

    if (photoInput && photoPreview) {

        photoInput.addEventListener('change', function (event) {

            const file = event.target.files[0];

            if (!file) return;

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/jpg',
                'image/webp'
            ];

            const maxSize = 2 * 1024 * 1024;

            if (!allowedTypes.includes(file.type)) {
                alert('Only JPG, JPEG, PNG and WEBP images are allowed.');
                photoInput.value = '';
                return;
            }

            if (file.size > maxSize) {
                alert('Image size must be less than 2 MB.');
                photoInput.value = '';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                photoPreview.src = e.target.result;
                photoPreview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        });
    }

});

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('employeeSearch');
    const employeeRows = document.querySelectorAll('.employee-row');

    if (!searchInput) return;

    searchInput.addEventListener('input', function () {

        const searchValue = this.value.toLowerCase().trim();

        employeeRows.forEach(function (row) {

            const rowText = row.textContent.toLowerCase();

            if (rowText.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }

        });

    });

});

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('employeeSearch');
    const employeeRows = document.querySelectorAll('.employee-row');
    const noResults = document.getElementById('noSearchResults');

    if (!searchInput) return;

    searchInput.addEventListener('input', function () {

        const searchValue = this.value.toLowerCase().trim();
        let visibleCount = 0;

        employeeRows.forEach(function (row) {

            const rowText = row.textContent.toLowerCase();

            if (rowText.includes(searchValue)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }

        });

        if (noResults) {
            noResults.style.display =
                visibleCount === 0 ? '' : 'none';
        }

    });

});