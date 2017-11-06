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
    if (origin !== 'http://ucendu-v2.dev') {
        console.log('origin not allowed: ' + origin);
        // io.close(); // Close current server
        return callback('origin not allowed', false);
    }
    callback(null , true);
});

io.use((socket, next) => {
    if (socket.request.headers.cookie) {
        console.log('---------- Auth True -----------');
        return next();
    }
    next(new Error('Authentication error'));
});
io.on('connection', function (socket){
    console.log('Co nguoi vua ket noi ' + socket.id);
    var room_id = socket.handshake.query.user_id;
    var redis = new Redis();
    var time_code = 0;
    redis.psubscribe("private-room-" + room_id, function (error, count) {
        console.log('User subscribe room ' + room_id);
    });
    redis.on('pmessage', function (partner, channel, data) {
        data = JSON.parse(data);
        if (last_time_noti['user-' + data.data.room] !== data.data.time_code) {
            io.in('room ' + data.data.room).clients((error, clients) => {
                if (error) throw error;
                io.to(clients[0]).emit('comment-notication', data.data);
                io.to('room ' + data.data.room).emit('insert-new-comment', data.data);
            });
            last_time_noti['user-' + data.data.room] = data.data.time_code;
            console.log('---------- Sent private notification success! -----------');
            console.log('                                    ');
        }
        else {
            console.log('---------- FAILED! Was Send Notification -----------');
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
            });
        });
    });

    socket.on('disconnect', function() {
        var key = null;
        for (i = 0; i < current_sockets.length; ++i) {
            var socket_id_tmp = current_sockets[i].substr(current_sockets[i].indexOf('###') +3);
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