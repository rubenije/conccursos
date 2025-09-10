#!/bin/bash

# Cambiar al directorio donde están los archivos
cd /home/conccursos/public_html/

sudo /opt/google-cloud-sdk/bin/gcloud auth activate-service-account load-file-ccuchile-catun@gcp-ccu.iam.gserviceaccount.com --key-file=gcp-ccu-6612e867c4df.json

sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/RETORNABLE_DETALLE.csv /home/conccursos/public_html/RETORNABLE_DETALLE_$(date +%Y%m%d).csv
sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/RETORNABLES.csv /home/conccursos/public_html/RETORNABLE_$(date +%Y%m%d).csv
sudo /usr/local/bin/ea-php81 /home/conccursos/public_html/reader.php
sudo /usr/local/bin/ea-php81 /home/conccursos/public_html/reader-detalle.php

sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/RED_BULL_DETALLE_202509.csv /home/conccursos/public_html/RED_BULL_DETALLE.csv
sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/RED_BULL_202509.csv /home/conccursos/public_html/RED_BULL.csv
sudo /usr/local/bin/ea-php81 /home/conccursos/public_html/reader-redbull.php
sudo /usr/local/bin/ea-php81 /home/conccursos/public_html/reader-redbull-detalle.php

# Autenticar cuenta de servicio de Google Cloud
#/root/google-cloud-sdk/bin/gcloud auth activate-service-account load-file-ccuchile-catun@gcp-ccu.iam.gserviceaccount.com --key-file=gcp-ccu-6612e867c4df.json

# Copiar el archivo desde Google Cloud Storage
#/root/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/CONCURSO_CHAMPIONS.csv CONCURSO_CHAMPIONS_$(date +%Y%m%d).CSV

# Ejecutar el script PHP
#/usr/local/bin/ea-php81 /home/concursosveranoc/public_html/reader.php