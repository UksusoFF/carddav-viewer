#!/bin/bash

SCRIPT_DIR=$(cd "$(dirname "$0")" && pwd)
UPDATE_URL=https://codeload.github.com/UksusoFF/carddav-viewer/tar.gz/master

wget -qO- "${UPDATE_URL}" | tar --transform 's/^dbt2-0.37.50.3/dbt2/' -xvz -C "${SCRIPT_DIR}" --strip 1 --exclude=update.sh
