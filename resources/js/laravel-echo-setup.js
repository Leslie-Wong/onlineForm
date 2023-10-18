
import { io } from "socket.io-client";
import Echo from 'laravel-echo';

window.io = io;

if (typeof window.io !== "undefined") {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ":6001",
        transports: ['websocket', 'polling', 'flashsocket'],
        withCredentials: true
        /* csrfToken: $('meta[name="csrf-token"]').attr("content"),
        auth: {headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content"),
        }}, */
    });
    console.log('Connected to socket.io');
}else{
    console.log('Not connected to socket.io');
}
