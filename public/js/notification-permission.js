document.addEventListener('DOMContentLoaded', async function () {

    if (!firebase.messaging.isSupported()) {
        console.log("Firebase messaging is NOT supported on this browser");
        return;
    }

    // 1. Register Service Worker
    const registration = await navigator.serviceWorker.register('work-order/public/firebase-messaging-sw.js');
    console.log('Service Worker registered:', registration);

    // 2. Initialize Firebase Messaging
    const messaging = firebase.messaging();

    showNotificationPermissionPrompt(messaging);
});


function showNotificationPermissionPrompt(messaging) {

    if (Notification.permission === 'default' || Notification.permission === 'denied') {
        requestNotificationPermission(messaging);
    } else if (Notification.permission === 'granted') {
        initializeFirebaseMessaging(messaging);
    }
}


function requestNotificationPermission(messaging) {
    Notification.requestPermission().then(function(permission) {
        if (permission === 'granted') {
            initializeFirebaseMessaging(messaging);
        } else {
            console.log('Notification permission denied');
        }
    });
}


function initializeFirebaseMessaging(messaging) {

    messaging.getToken({
        vapidKey: "ISI VAPID KEY DI SINI",
        serviceWorkerRegistration: navigator.serviceWorker.ready
    })
    .then((currentToken) => {
        if (currentToken) {
            console.log("FCM Token:", currentToken);
            saveFcmToken(currentToken);
        }
    })
    .catch((err) => {
        console.log('Error retrieving token:', err);
    });

    messaging.onMessage((payload) => {
        console.log('Message Received:', payload);

        new Notification(payload.notification.title, {
            body: payload.notification.body,
            icon: payload.notification.icon || '/logo.png'
        });
    });
}


function saveFcmToken(token) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        url: '/save-fcm-token',
        type: 'POST',
        data: { token: token },
        success: function() {
            console.log('Token saved');
        },
        error: function(err) {
            console.log('Save token error:', err);
        }
    });
}
