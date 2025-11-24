document.addEventListener('DOMContentLoaded', function() {
    // Show a prompt or UI element for the user to allow notifications
    showNotificationPermissionPrompt();
});

function showNotificationPermissionPrompt() {
    if (Notification.permission === 'default' || Notification.permission === 'denied') {
        // Delay prompt by small timeout to allow UI to load
        setTimeout(() => {
            if (confirm('Allow this site to send you notifications?')) {
                requestNotificationPermission();
            } else {
                console.log('User declined notification permission prompt');
            }
        }, 1000);
    } else if (Notification.permission === 'granted') {
        initializeFirebaseMessaging();
    }
}

function requestNotificationPermission() {
    Notification.requestPermission().then(function(permission) {
        if (permission === 'granted') {
            initializeFirebaseMessaging();
        } else {
            console.log('Notification permission was denied');
        }
    });
}

function initializeFirebaseMessaging() {
    if (!firebase.messaging.isSupported()) {
        console.log('Firebase messaging not supported');
        return;
    }

    const messaging = firebase.messaging();
    messaging
        .getToken({ vapidKey: '<YOUR_VAPID_KEY_HERE>' })
        .then((currentToken) => {
            if (currentToken) {
                console.log("FCM Token:", currentToken);
                saveFcmToken(currentToken);
            } else {
                console.log('No registration token available. Request permission to generate one.');
            }
        })
        .catch((err) => {
            console.log('An error occurred while retrieving token. ', err);
        });

    messaging.onTokenRefresh(() => {
        messaging
            .getToken({ vapidKey: '<YOUR_VAPID_KEY_HERE>' })
            .then((refreshedToken) => {
                console.log('FCM Token refreshed:', refreshedToken);
                saveFcmToken(refreshedToken);
            })
            .catch((err) => {
                console.log('Unable to retrieve refreshed token ', err);
            });
    });

    messaging.onMessage((payload) => {
        console.log('Message received. ', payload);
    });
}

function saveFcmToken(token) {
    console.log('Saving FCM token to server:', token);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        url: '/save-fcm-token',
        type: 'POST',
        data: { token: token },
        success: function(response) {
            console.log('FCM token saved successfully');
        },
        error: function(err) {
            console.log('Error saving FCM token', err);
        }
    });
}
