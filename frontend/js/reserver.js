document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('reservation-form');
    const msgEl = document.getElementById('reservation-message');
    let hideTimer;

    if (!form || !msgEl) return;

    function showMessage(html, type = 'success') {
        clearTimeout(hideTimer);
        msgEl.classList.remove('success', 'error', 'show', 'reservation-auto-hide');
        msgEl.classList.add(type);
        msgEl.innerHTML = html;
        // trigger transition
        void msgEl.offsetWidth;
        msgEl.classList.add('show');

        hideTimer = setTimeout(() => {
            msgEl.classList.remove('show');
        }, 6000);
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        msgEl.textContent = '';

        const data = new FormData(form);

        try {
            const res = await fetch('/backend/php/api/reservation.php', {
                method: 'POST',
                body: data
            });

            if (!res.ok) throw new Error('Erreur réseau');

            const json = await res.json();

            if (json.success) {
                const id = json.reservation_id ? ` ${json.reservation_id}` : '';
                showMessage(`<span class="msg-icon">✔︎</span> Réservation confirmée.`, 'success');
                form.reset();
            } else {
                showMessage(`<span class="msg-icon">✖</span> ${json.message || 'Erreur lors de la réservation.'}`, 'error');
            }
        } catch (err) {
            showMessage(`<span class="msg-icon">✖</span> Erreur réseau ou serveur.`, 'error');
        }
    });
});