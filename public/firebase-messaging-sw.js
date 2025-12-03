// Import Firebase v8 (compatible with service worker)
importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js");

// Firebase config
// Firebase Config (sama seperti yang di SW)
const firebaseConfig = {
    apiKey: "AIzaSyB-4O7-Uf5IN8894mPdk2y7gNOWrpbi7Es",
    authDomain: "work-order-f77f4.firebaseapp.com",
    projectId: "work-order-f77f4",
    storageBucket: "work-order-f77f4.firebasestorage.app",
    messagingSenderId: "16206272663",
    appId: "1:16206272663:web:04827df12edd59979c71d2",
};

// Initialize Firebase (WAJIB)
firebase.initializeApp(firebaseConfig);


// Init messaging
const messaging = firebase.messaging();

// Background notification handler
messaging.onBackgroundMessage(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message:', payload);

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon || '/logo.png'
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
