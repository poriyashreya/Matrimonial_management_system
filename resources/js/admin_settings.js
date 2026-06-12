document.getElementById('faviconTrigger')?.addEventListener('click', function () {
    document.getElementById('faviconInput').click();
});

document.getElementById('faviconInput')?.addEventListener('change', function () {
    if (this.files.length) {
        document.getElementById('faviconForm').submit();
    }
});