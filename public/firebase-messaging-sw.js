importScripts(
    "https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"
);
importScripts(
    "https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js"
);

const firebaseConfig = {
    apiKey: "AIzaSyAInaX82tL4DA8-60ZM8JxrfB464Jy2duc",
    authDomain: "toko-butik-c4700.firebaseapp.com",
    projectId: "toko-butik-c4700",
    storageBucket: "toko-butik-c4700.firebasestorage.app",
    messagingSenderId: "813377615528",
    appId: "1:813377615528:web:a4893f787f92f1edae749d",
};

firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload
    );

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: "/assets/images/logo.png",
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
