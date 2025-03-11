import serial
import mysql.connector

porta_serial = serial.Serial('COM3', 9600)

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="senha.",
    database="bd"
)
cursor = conn.cursor()

print("Aguardando dados do Arduino...")

try:
    while True:
        if porta_serial.in_waiting > 0:
            linha = porta_serial.readline().decode('utf-8').strip()
            print("Recebido:", linha)
            
            try:
                partes = linha.split(",")
                temperatura = float(partes[0])
                umidade = float(partes[1])
                umidade_solo = int(partes[2])
                bomba_estado = partes[3]

                cursor.execute('''
                    INSERT INTO leituras (temperatura, umidade, umidade_solo, bomba_estado)
                    VALUES (%s, %s, %s, %s)
                ''', (temperatura, umidade, umidade_solo, bomba_estado))
                conn.commit()

                print("Dados salvos no banco de dados MySQL.")
            except Exception as e:
                print("Erro ao processar os dados:", e)

except KeyboardInterrupt:
    print("\nEncerrando conexão...")
    porta_serial.close()
    conn.close()