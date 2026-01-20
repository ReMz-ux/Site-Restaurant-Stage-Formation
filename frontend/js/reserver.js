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
        const phone = data.get('telephone');
        const email = data.get('email');
        const date = data.get('date_reservation');
        const midi = data.get('midi');
        const soir = data.get('soir');

        // Validation de la date
        if (!date) {
            showMessage('<span class="msg-icon">✖</span> Veuillez rentrer une date valide.', 'error');
            return;
        }

        // Validation de la date (pas dans le passé)
        const selectedDate = new Date(date);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        if (selectedDate < today) {
            showMessage('<span class="msg-icon">✖</span> Veuillez sélectionner une date future.', 'error');
            return;
        }

        // Validation du numéro de téléphone
        if (phone.length !== 10) {
            showMessage('<span class="msg-icon">✖</span> Veuillez rentrer un numéro de téléphone valide.', 'error');
            return;
        }

        // Validation de l'email
        if (!email.includes('@') || !email.includes('.')) {
            showMessage('<span class="msg-icon">✖</span> L\'adresse e-mail n\'est pas valide. Elle doit contenir un "@" et un ".".', 'error');
            return;
        }

        // Validation d'une heure de réservation
        if (!midi && !soir) {
            showMessage('<span class="msg-icon">✖</span> Veuillez sélectionner une heure de réservation (midi ou soir).', 'error');
            return;
        }

        //Validation du nombre de personnes
        const nombrePersonnes = data.get('nb_personnes');
        if (!nombrePersonnes || nombrePersonnes < 1) {
            showMessage('<span class="msg-icon">✖</span> Veuillez entrer un nombre valide de personnes.', 'error');
            return;
        }

        try {
            const res = await fetch('/backend/php/api/reservation.php', {
                method: 'POST',
                body: data
            });

            if (!res.ok) throw new Error('Erreur réseau');

            const json = await res.json();

            if (json.success) {
                const id = json.reservation_id ? ` ${json.reservation_id}` : '';
                showMessage(`<span class="msg-icon">✔︎</span> Réservation confirmée. Vous allez recevoir un e-mail de confirmation.`, 'success');
                form.reset();
            } else {
                showMessage(`<span class="msg-icon">✖</span> ${json.message || 'Erreur lors de la réservation.'}`, 'error');
            }
        } catch (err) {
            showMessage(`<span class="msg-icon">✖</span> Erreur réseau ou serveur.`, 'error');
        }
    });
});