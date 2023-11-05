import socket
from threading import Thread


HOST = ""
PORT = 3000


def listen_for_client(sock):
    while True:
        try:
            data = sock.recv(1024).decode()
        except Exception as e:
            client_sockets.remove(sock)

        for client_socket in client_sockets:
            if client_socket != sock:
                client_socket.send(data.encode())


with socket.socket() as sock:
    sock.bind((HOST, PORT))
    sock.listen()
    client_sockets = set()

    while True:
        client_socket, client_address = sock.accept()
        client_sockets.add(client_socket)
        thread = Thread(target=listen_for_client, args=(client_socket,))
        thread.daemon = True
        thread.start()

    for client_sock in client_sockets:
        client_sock.close()
