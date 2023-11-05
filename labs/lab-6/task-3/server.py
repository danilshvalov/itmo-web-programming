import socket
import math

HOST = ""
PORT = 3000
EMPTY_LINE = b""


def read_file(path):
    with open(path, "rb") as f:
        return f.read()


with socket.socket() as sock:
    sock.bind((HOST, PORT))
    sock.listen()

    conn, addr = sock.accept()
    with conn:
        http_code = b"HTTP/1.1 200 OK"
        content = read_file("index.html")

        headers = {
            "Content-Type": "text/html",
            "Content-Length": str(len(content)),
            "Connection": "close",
        }
        headers = [f"{key}: {value}" for key, value in headers.items()]
        headers = b"\n".join(map(str.encode, headers))

        data = [http_code, headers, EMPTY_LINE, content]
        data = b"\n".join(data)

        conn.send(data)
