function showSmallNotification(message, type = 'info') {

    const oldNotifs = document.querySelectorAll('.evidence-notification');

    oldNotifs.forEach(function (notif) {
        notif.remove();
    });

    const notif = document.createElement('div');

    notif.className = 'evidence-notification ' + type;
    notif.innerHTML = message;

    document.body.appendChild(notif);

    setTimeout(function () {
        notif.classList.add('show');
    }, 10);

    setTimeout(function () {

        notif.classList.remove('show');

        setTimeout(function () {
            notif.remove();
        }, 300);

    }, 2000);
}