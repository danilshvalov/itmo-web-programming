import socket

HOST = "localhost"
PORT = 3000

with socket.socket() as sock:
    sock.connect((HOST, PORT))
    sock.send(b"Hello, server")
    recieved = sock.recv(1024)
    print(recieved.decode("utf-8"))
