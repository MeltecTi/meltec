import "./requires/bootstrap";
import * as bootstrap from "bootstrap";
import $ from "jquery";
import * as PusherPushNotifications from "@pusher/push-notifications-web";

const beamsClient = new PusherPushNotifications.Client({
    instanceId: "603bd71a-452b-4fcb-9a76-4204b1127c15",
});

beamsClient
    .start()
    .then(() => {
        console.log("Instancia Creada, Hola a todos");
    })
    .catch((error) => {
        console.error(error);
    });
