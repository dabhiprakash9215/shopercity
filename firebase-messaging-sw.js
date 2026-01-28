// import { initializeApp } from "firebase/app";
// import { getAnalytics } from "firebase/analytics";
// const firebaseConfig = {
//   apiKey: "AIzaSyCgzObEL9yvnlTEQOj7Dw62NkOB11QpX0U",
//   authDomain: "shopercity-ea0ae.firebaseapp.com",
//   projectId: "shopercity-ea0ae",
//   storageBucket: "shopercity-ea0ae.firebasestorage.app",
//   messagingSenderId: "54041175730",
//   appId: "1:54041175730:web:75b62e47e74bf469efcbab",
//   measurementId: "G-XF7XSX1E32",
// };

// const app = initializeApp(firebaseConfig);
// const analytics = getAnalytics(app);

// firebase-messaging-sw.js (for background notifications)
// import { initializeApp } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
// import {
//   getMessaging,
//   onBackgroundMessage,
// } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging.js";

// const firebaseConfig = {
//   apiKey: "AIzaSyCgzObEL9yvnlTEQOj7Dw62NkOB11QpX0U",
//   authDomain: "shopercity-ea0ae.firebaseapp.com",
//   projectId: "shopercity-ea0ae",
//   storageBucket: "shopercity-ea0ae.firebasestorage.app",
//   messagingSenderId: "54041175730",
//   appId: "1:54041175730:web:75b62e47e74bf469efcbab",
//   measurementId: "G-LMVHPVLLR7",
// };

// initializeApp(firebaseConfig);

// const messaging = getMessaging();

// onBackgroundMessage(messaging, (payload) => {
//   console.log("Received background message ", payload);
//   const notificationTitle = payload.notification.title;
//   const notificationOptions = {
//     body: payload.notification.body,
//     icon: payload.notification.icon,
//   };

//   self.registration.showNotification(notificationTitle, notificationOptions);
// });

/* firebase-messaging-sw.js */

importScripts(
  "https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"
);
importScripts(
  "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging-compat.js"
);

firebase.initializeApp({
  apiKey: "AIzaSyCgzObEL9yvnlTEQOj7Dw62NkOB11QpX0U",
  authDomain: "shopercity-ea0ae.firebaseapp.com",
  projectId: "shopercity-ea0ae",
  storageBucket: "shopercity-ea0ae.firebasestorage.app",
  messagingSenderId: "54041175730",
  appId: "1:54041175730:web:75b62e47e74bf469efcbab",
  measurementId: "G-LMVHPVLLR7",
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
  self.registration.showNotification(payload.notification.title, {
    body: payload.notification.body,
    icon: "/icon.png",
  });
});
