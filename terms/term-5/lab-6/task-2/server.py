import socket
import math

HOST = ""
PORT = 3000


def find_hypotenuse(first_cathet, second_cathet):
    return math.sqrt(first_cathet**2 + second_cathet**2)


with socket.socket() as sock:
    sock.bind((HOST, PORT))
    sock.listen()

    conn, addr = sock.accept()
    with conn:
        recieved = conn.recv(1024)

        recieved = recieved.decode("utf-8")
        first_cathet, second_cathet = list(map(float, recieved.split()))

        data = find_hypotenuse(first_cathet, second_cathet)
        data = str.encode(str(data))

        conn.send(data)
