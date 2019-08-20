import Notification from "./DefaultNotification";

/**
 * Plugins compatibles avec ce systeme d'event de notification:
 * - Contact
 * - Espace Restreint
 * - Newsletter
 * - RGPD
 * - Vote
 */
let EventManager = window.EventManager || $(document);
EventManager.on('notification', (e, showOpts) => {
  //console.log('notification',showOpts);
  let notif = new Notification();
  notif.show(showOpts);
});
