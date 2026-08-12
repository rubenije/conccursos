#!/bin/bash

# Definir el directorio base
BASE_DIR="/home/conccursos/public_html"

# Cambiar al directorio donde están los archivos
cd "$BASE_DIR" || exit 1

# Autenticación en Google Cloud
sudo /opt/google-cloud-sdk/bin/gcloud auth activate-service-account load-file-ccuchile-catun@gcp-ccu.iam.gserviceaccount.com --key-file="$BASE_DIR/gcp-ccu-6612e867c4df.json"

# gaseosas
#sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/GASEOSAS_DETALLE.csv "$BASE_DIR/GASEOSAS_DETALLE.csv"
#sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/GASEOSAS.csv "$BASE_DIR/GASEOSAS.csv"
#sudo /usr/local/bin/ea-php81 "$BASE_DIR/gaseosas-reader.php"
#sudo /usr/local/bin/ea-php81 "$BASE_DIR/gaseosas-reader-detalle.php"

# heineken
#sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/HEINEKEN_DETALLE.csv "$BASE_DIR/HEINEKEN_DETALLE.csv"
#sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/HEINEKEN.csv "$BASE_DIR/HEINEKEN.csv"
#sudo /usr/local/bin/ea-php81 "$BASE_DIR/heineken-reader.php"
#sudo /usr/local/bin/ea-php81 "$BASE_DIR/heineken-reader-detalle.php"

# aguas
#sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/AGUAS_DETALLE.csv "$BASE_DIR/AGUAS_DETALLE.csv"
#sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/AGUAS.csv "$BASE_DIR/AGUAS.csv"
#sudo /usr/local/bin/ea-php81 "$BASE_DIR/aguas-reader.php"
#sudo /usr/local/bin/ea-php81 "$BASE_DIR/aguas-reader-detalle.php"

# gatorade
#sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/GATORADE_DETALLE.csv "$BASE_DIR/GATORADE_DETALLE.csv"
#sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/GATORADE.csv "$BASE_DIR/GATORADE.csv"
#sudo /usr/local/bin/ea-php81 "$BASE_DIR/gatorade-reader.php"
#sudo /usr/local/bin/ea-php81 "$BASE_DIR/gatorade-reader-detalle.php"

# royalweekend
# sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/ROYAL_WEEKEND_DETALLE.csv "$BASE_DIR/ROYALWEEKEND_DETALLE.csv"
# sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/ROYAL_WEEKEND.csv "$BASE_DIR/ROYALWEEKEND.csv"
# sudo /usr/local/bin/ea-php81 "$BASE_DIR/royalweekend-reader.php"
# sudo /usr/local/bin/ea-php81 "$BASE_DIR/royalweekend-reader-detalle.php"

# energia
# sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/ENERGIA_DETALLE.csv "$BASE_DIR/ENERGIA_DETALLE.csv"
# sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/ENERGIA.csv "$BASE_DIR/ENERGIA.csv"
# sudo /usr/local/bin/ea-php81 "$BASE_DIR/energia-reader.php"
# sudo /usr/local/bin/ea-php81 "$BASE_DIR/energia-reader-detalle.php"

# cpch
# sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/CPCH_DETALLE.csv "$BASE_DIR/CPCH_DETALLE.csv"
# sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/CPCH.csv "$BASE_DIR/CPCH.csv"
# sudo /usr/local/bin/ea-php81 "$BASE_DIR/cpch-reader.php"
# sudo /usr/local/bin/ea-php81 "$BASE_DIR/cpch-reader-detalle.php"

# bep2026
sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/BEP_DETALLE.csv "$BASE_DIR/BEP2026_DETALLE.csv"
sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/BEP.csv "$BASE_DIR/BEP2026.csv"
sudo /usr/local/bin/ea-php81 "$BASE_DIR/bep2026-reader.php"
sudo /usr/local/bin/ea-php81 "$BASE_DIR/bep2026-reader-detalle.php"

# gatorade2026
sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/GATORADE_DETALLE.csv "$BASE_DIR/GATORADE2026_DETALLE.csv"
sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/GATORADE.csv "$BASE_DIR/GATORADE2026.csv"
sudo /usr/local/bin/ea-php81 "$BASE_DIR/gatorade2026-reader.php"
sudo /usr/local/bin/ea-php81 "$BASE_DIR/gatorade2026-reader-detalle.php"

# watts
sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/WATTS_DETALLE.csv "$BASE_DIR/WATTS_DETALLE.csv"
sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/WATTS.csv "$BASE_DIR/WATTS.csv"
sudo /usr/local/bin/ea-php81 "$BASE_DIR/watts-reader.php"
sudo /usr/local/bin/ea-php81 "$BASE_DIR/watts-reader-detalle.php"


# kunstmann
sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/KUNSTMANN_DETALLE.csv "$BASE_DIR/KUNSTMANN_DETALLE.csv"
sudo /opt/google-cloud-sdk/bin/gsutil cp gs://ccu-idr-ccuchile-catun/KUNSTMANN.csv "$BASE_DIR/KUNSTMANN.csv"
sudo /usr/local/bin/ea-php81 "$BASE_DIR/kunstmann-reader.php"
sudo /usr/local/bin/ea-php81 "$BASE_DIR/kunstmann-reader-detalle.php"




