#!/usr/bin/env bash

sudo chmod +x ./install-docker.sh
sudo ./install-docker.sh

newgrp docker << END
  docker compose up -d --build
END

sleep 10

xdg-open http://localhost:8080/ &