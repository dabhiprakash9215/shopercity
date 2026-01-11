import { initializeApp } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
import {
  getMessaging,
  onBackgroundMessage,
} from "https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging.js";

const firebaseConfig = {
  apiKey: "AIzaSyCgzObEL9yvnlTEQOj7Dw62NkOB11QpX0U",
  authDomain: "shopercity-ea0ae.firebaseapp.com",
  projectId: "shopercity-ea0ae",
  storageBucket: "shopercity-ea0ae.firebasestorage.app",
  messagingSenderId: "54041175730",
  appId: "1:54041175730:web:75b62e47e74bf469efcbab",
  measurementId: "G-XF7XSX1E32",
};

initializeApp(firebaseConfig);

const messaging = getMessaging();

onBackgroundMessage(messaging, (payload) => {
  console.log("Received background message ", payload);
  // Customize notification here
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: payload.notification.icon,
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});
