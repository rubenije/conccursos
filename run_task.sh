#!/bin/bash

# Cambiar al directorio donde están los archivos
cd /home/conccursos/public_html/

sudo /opt/google-cloud-sdk/bin/gcloud auth activate-service-account load-file-ccuchile-catun@gcp-ccu.iam.gserviceaccount.com --key-file=gcp-ccu-6612e867c4df.json
sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/MINIONS_ENERGIA.csv /home/conccursos/public_html/MINIONS_ENERGIA_$(date +%Y%m%d).csv
sudo /usr/local/bin/ea-php81 /home/conccursos/public_html/reader.php
sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/MINIONS_ENERGIA_DETALLE.csv /home/conccursos/public_html/MINIONS_ENERGIA_DETALLE_$(date +%Y%m%d).csv
sudo /usr/local/bin/ea-php81 /home/conccursos/public_html/reader-detalle.php


# Autenticar cuenta de servicio de Google Cloud
#/root/google-cloud-sdk/bin/gcloud auth activate-service-account load-file-ccuchile-catun@gcp-ccu.iam.gserviceaccount.com --key-file=gcp-ccu-6612e867c4df.json

# Copiar el archivo desde Google Cloud Storage
#/root/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/CONCURSO_CHAMPIONS.csv CONCURSO_CHAMPIONS_$(date +%Y%m%d).CSV

# Ejecutar el script PHP
#/usr/local/bin/ea-php81 /home/concursosveranoc/public_html/reader.php