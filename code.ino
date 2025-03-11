#include "DHT.h"

const int pino_dht = 9;
const int pino_bomba = 7;
float temperatura;
float umidade;
int umidade_solo;

DHT dht(pino_dht, DHT11);

unsigned long tempo_bomba_ativa = 0;
unsigned long tempo_ultimo_registro = 0;
bool bomba_ativa = false;

void setup() {
  Serial.begin(9600);
  dht.begin();
  pinMode(pino_bomba, OUTPUT);
}

void loop() {
  unsigned long tempo_atual = millis();

  if (tempo_atual - tempo_ultimo_registro >= 300000) { // 5 minutos
    temperatura = dht.readTemperature();
    umidade = dht.readHumidity();
    umidade_solo = random(300, 800);

    if (isnan(umidade) || isnan(temperatura)) {
      Serial.println("ERRO: Falha na leitura do Sensor DHT!");
    } else {
      String bomba_estado = (umidade_solo < 500) ? "LIGADA" : "DESLIGADA";

      Serial.print(temperatura);
      Serial.print(",");
      Serial.print(umidade);
      Serial.print(",");
      Serial.print(umidade_solo);
      Serial.print(",");
      Serial.println(bomba_estado);
    }

    tempo_ultimo_registro = tempo_atual;
  }

  if (umidade_solo < 500 && !bomba_ativa) {
    digitalWrite(pino_bomba, HIGH);
    bomba_ativa = true;
    tempo_bomba_ativa = tempo_atual;
  }

  if (bomba_ativa && tempo_atual - tempo_bomba_ativa >= 10000) {
    digitalWrite(pino_bomba, LOW);
    bomba_ativa = false;
  }
}
