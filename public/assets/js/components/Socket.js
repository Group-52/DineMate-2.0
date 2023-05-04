/**
 * Socket class
 * @param url - the url to connect to including the port
 * @event event_type - the event type to listen to eg. CompletedOrder, NewOrder
 * @data - the data to send to the websocket
 * @callback callback - the callback function to call when the event is received
 */

class Socket {
    constructor(url=`ws://${SOCKET_HOST}:8080`) {
        this.url = url;
    }

    send_data(event_type, data) {
        let socket = new WebSocket(this.url);
        socket.onopen = function (event) {
            socket.send(JSON.stringify({
                event_type: event_type,
                data: data
            }));
        }
    }

    receive_data(event_type, callback) {
        let socket = new WebSocket(this.url);
        socket.onmessage = function (event) {
            let message = JSON.parse(event.data);
            if (message.event_type === event_type) {
                callback(message.data);
            }
        }
    }
}
