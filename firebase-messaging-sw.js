/* firebase-messaging-sw.js */

importScripts(
  "https://www.gstatic.com/firebasejs/10.0.0/firebase-app-compat.js"
);
importScripts(
  "https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging-compat.js"
);

firebase.initializeApp({
  apiKey: "AIzaSyCgzObEL9yvnlTEQOj7Dw62NkOB11QpX0U",
  authDomain: "shopercity-ea0ae.firebaseapp.com",
  projectId: "shopercity-ea0ae",
  storageBucket: "shopercity-ea0ae.appspot.com",
  messagingSenderId: "54041175730",
  appId: "1:54041175730:web:75b62e47e74bf469efcbab",
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
  self.registration.showNotification(payload.notification.title, {
    body: payload.notification.body,
    icon: payload.notification.icon || "/icon.png",
  });
});
