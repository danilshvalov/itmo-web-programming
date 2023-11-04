import socket

HOST = ""
PORT = 3000

with socket.socket() as sock:
    sock.bind((HOST, PORT))
    sock.listen()

    conn, addr = sock.accept()
    with conn:
        recieved = conn.recv(1024)
        print(recieved.decode("utf-8"))
        conn.send(b"Hello, client")
        conn.close()
