import Notification from "./DefaultNotification";

/**
 * Plugins compatibles avec ce systeme d'event de notification:
 * - Contact
 * - Espace Restreint
 * - Newsletter
 * - RGPD
 * - Vote
 */

$(document).on('notification', (e, showOpts) => {
    let notif = new Notification();
    notif.show(showOpts);
});
