/**
 * Created by BiPham on 11/2/2017.
 */
var app = require('express')();
var server = require('http').createServer(app);
var io = require('socket.io')(server);
var Redis = require('ioredis');
server.listen(8890);
console.log('Server running port: 8890 ...');
current_sockets = [];
last_time_noti = {};
io.origins((origin, callback) => {
    if (origin !== 'http://ucendu.dev') {
        console.log('origin not allowed: ' + origin);
        // io.close(); // Close current server
        return callback('origin not allowed', false);
    }
    callback(null , true);
});

// var chat = io
//     .of('/private-room-1')
//     .on('connection', function (socket) {
//         var redis = new Redis();
//         socket.join('room 237', () => {
//             let rooms = socket.rooms;
//
//         });
//         redis.psubscribe("private-room-1", function (error, count) {
//
//         });
//         redis.on('pmessage', function (partner, channel, data) {
//             console.log('channel 1 ' + channel);
//             console.log('message 1 : ' + data);
//             console.log('partner 1 : ' + partner);
//             data = JSON.parse(data);
//             chat.emit(channel + ":" + data.event, data.data);
//             console.log('---------- Sent private -----------');
//             console.log('                                    ');
//         });
//         socket.on('disconnect', function() {
//             redis.quit();
//         });
//     });
//
io.use((socket, next) => {
    if (socket.request.headers.cookie) {
        console.log('---------- Auth True -----------');
        return next();
    }
    next(new Error('Authentication error'));
});
io.on('connection', function (socket){
    console.log('Co nguoi vua ket noi ' + socket.id);
    console.log('Co ' + socket.handshake.query.user_id);
    var room_id = socket.handshake.query.user_id;
    var redis = new Redis();
    var time_code = 0;
    redis.psubscribe("private-room-" + room_id, function (error, count) {
        console.log('User subscribe room ' + room_id);
    });
    redis.on('pmessage', function (partner, channel, data) {
        console.log('channel ' + socket.id + '' + channel);
        console.log('message ' + socket.id + '' + data);
        console.log('partner ' + socket.id + '' + partner);
        data = JSON.parse(data);
        console.log('---------- Time: ' + last_time_noti["user-" + data.data.user_id] + ' -----------');
        console.log('wasSendNoti ' + data.data.time_code);
        if (last_time_noti['user-' + data.data.user_id] !== data.data.time_code) {
            io.in('room ' + data.data.user_id).clients((error, clients) => {
                if (error) throw error;
                console.log('Send noti to client in room ' + data.data.user_id + ': ' + clients[0]); // => [Anw2LatarvGVVXEIAAAD]
                io.to(clients[0]).emit('test-noti', data.data);
                io.to('room ' + data.data.user_id).emit('test', data.data);
            });
            last_time_noti['user-' + data.data.user_id] = data.data.time_code;
            console.log('---------- Sent private ' + time_code + ' -----------');
            console.log('                                    ');
        }
        else {
            console.log('---------- Was Send Notification -----------');
            console.log('                                    ');
        }
    });
    socket.on('updateSocket', function (data) {
        var new_socket = data + '###' + socket.id;
        current_sockets.push(new_socket);
        last_time_noti['user-' + data] = 0;
        console.log('----------------- socket all: ' + current_sockets + '-------------------');
        console.log('                                    ');
        socket.join('room ' + data, (clients) => {
            io.in('room ' + data).clients((error, clients) => {
                if (error) throw error;
                console.log('clients in room ' + data + ': ' + clients); // => [Anw2LatarvGVVXEIAAAD]
                console.log('First client in room ' + data + ': ' + clients[0]); // => [Anw2LatarvGVVXEIAAAD]
            });
        });
    });

    socket.on('disconnect', function() {
        var key = null;
        for (i = 0; i < current_sockets.length; ++i) {
            var socket_id_tmp = current_sockets[i].substr(current_sockets[i].indexOf('###') +3);
            console.log('socket_id_tmp ' + i + ': ' + socket_id_tmp);
            if (socket_id_tmp === socket.id) {
                key = i;
                break;
            }
        }
        if (key != null) {
            current_sockets.splice(key,1);
            console.log('---------------- socket dis: ' + JSON.stringify(current_sockets) + '-------------------');
            console.log('                                    ');
        }
        redis.quit();
    });
});