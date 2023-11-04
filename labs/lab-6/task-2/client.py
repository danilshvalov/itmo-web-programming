import socket

HOST = "localhost"
PORT = 3000

first_cathet = input("Введите длину первого катета: ")
second_cathet = input("Введите длину второго катета: ")

data = [first_cathet, second_cathet]
data = list(map(str, data))
data = b" ".join(map(str.encode, data))

with socket.socket() as sock:
    sock.connect((HOST, PORT))

    sock.send(data)
    recieved = sock.recv(1024)
    print("Длина гипотенузы:", recieved.decode("utf-8"))
