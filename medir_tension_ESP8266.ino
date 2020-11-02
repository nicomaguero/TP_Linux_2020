#include <ESP8266WiFi.h>
#include <WiFiClient.h> 
#include <ESP8266HTTPClient.h>

//-------------------VARIABLES GLOBALES--------------------------
int contconexion = 0;

const char *ssid = "WiFi-Arnet-b5";
const char *password = "nico1234";

unsigned long previousMillis = 0;

String host2 = "192.168.1.18";

char host[48];
String strhost = "192.168.1.18";
String strurl = "/enviardatos.php";
String chipid = "";



//
////-------Función para Enviar Datos a la Base de Datos SQL--------
//
String enviardatos(String datos) {
  String linea = "error";
  WiFiClient client;
  strhost.toCharArray(host, 49);
  if (!client.connect(host, 22)) {
    Serial.println("Fallo de conexion");
    return linea;
  }




//  client.print(String("POST ") + strurl + " HTTP/1.1" + "\r\n" + 
//               "Host: " + host2 + "\r\n" +
//               "Accept: */*" + "*\r\n" +
//               "Content-Length: " + datos.length() + "\r\n" +
//               "Content-Type: application/x-www-form-urlencoded" + "\r\n" +
//               "\r\n" + datos);     


  delay(10);             
  
  Serial.print("Enviando datos a SQL...");
  
  unsigned long timeout = millis();
  while (client.available() == 0) {
    if (millis() - timeout > 5000) {
      Serial.println("Cliente fuera de tiempo!");
      client.stop();
      return linea;
    }
  }
  // Lee todas las lineas que recibe del servidro y las imprime por la terminal serial
  while(client.available()){
    linea = client.readStringUntil('\r');
  }  
  Serial.println(linea);
  return linea;
}





//-------------------------------------------------------------------------

void setup() {

  // Inicia Serial
  Serial.begin(115200);
  Serial.println("");

  Serial.print("chipId: "); 
  chipid = String(ESP.getChipId());
  Serial.println(chipid); 

  // Conexión WIFI
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED and contconexion <50) { //Cuenta hasta 50 si no se puede conectar lo cancela
    ++contconexion;
    delay(500);
    Serial.print(".");
  }
  if (contconexion <50) {
      //para usar con ip fija
      IPAddress ip(192,168,1,156); 
      IPAddress gateway(192,168,1,1); 
      IPAddress subnet(255,255,255,0); 
      WiFi.config(ip, gateway, subnet); 
      
      Serial.println("");
      Serial.println("WiFi conectado");
      Serial.println(WiFi.localIP());
  }
  else { 
      Serial.println("");
      Serial.println("Error de conexion");
  }
}

//--------------------------LOOP--------------------------------

void loop() {
//
  unsigned long currentMillis = millis();

  if (currentMillis - previousMillis >= 10000) { //envia la temperatura cada 10 segundos
    previousMillis = currentMillis;
    int analog = analogRead(17);
    float temp = analog*0.00322265625;
    Serial.println(temp);
    enviardatos("chipid=" + chipid + "&temperatura=" + String(temp, 2));
  }
//
//






int analog = analogRead(17);
float temp = analog*0.00322265625;

if (WiFi.status() == WL_CONNECTED) { //Check WiFi connection status

String url = "http://192.168.1.18:8000/enviardatos.php?temp=";
url += temp;

HTTPClient http;  //Declare an object of class HTTPClient
http.begin(url);  //Specify request destination
int httpCode = http.GET();                                                                  //Send the request

if (httpCode > 0) { //Check the returning code
  String payload = http.getString();   //Get the request response payload
  Serial.println(payload);                     //Print the response payload
}

http.end();   //Close connection
}

delay(10000); //Send a request every 10 seconds

}
