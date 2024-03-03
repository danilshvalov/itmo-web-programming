import socket
from threading import Thread


HOST = "localhost"
PORT = 3000


def listen_for_messages():
    while True:
        data = sock.recv(1024).decode()
        print(data)


with socket.socket() as sock:
    sock.connect((HOST, PORT))
    username = input("Enter your name: ")

    thread = Thread(target=listen_for_messages)
    thread.daemon = True
    thread.start()

    while True:
        user_input = input()
        if user_input.lower() == "q":
            break
        user_input = f"{username}: {user_input}"
        sock.send(user_input.encode())

    sock.close()
