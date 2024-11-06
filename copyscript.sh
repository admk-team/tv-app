#!/bin/bash

# Define the Laravel source directory
SOURCE_DIR="/home/u763586918/domains/octv.online/public_html"

# Array of subdomain directories
SUBDOMAIN_DIRS=("agape" "cinebites" "classic" "echotv" "fitness" "Incrediscope" "kids" "legind" "licensing" "movee" "rdtv" "sports")

# Files and directories to exclude
EXCLUDE=("vendor" ".env" ".htaccess")

# Exclude each subdomain folder from the copy
for SUBDOMAIN in "${SUBDOMAIN_DIRS[@]}"; do
    EXCLUDE+=("$SUBDOMAIN")
done

# Construct the rsync exclude parameters
EXCLUDE_PARAMS=""
for ITEM in "${EXCLUDE[@]}"; do
    EXCLUDE_PARAMS+="--exclude=$ITEM "
done

# Loop through each subdomain to copy Laravel files
for SUBDOMAIN in "${SUBDOMAIN_DIRS[@]}"; do
    echo "Updating $SUBDOMAIN..."

    # Full path to the subdomain directory
    TARGET_DIR="$SOURCE_DIR/$SUBDOMAIN"

    # Sync all files except the excluded ones
    rsync -a --delete $EXCLUDE_PARAMS "$SOURCE_DIR/" "$TARGET_DIR/"

    echo "Update completed for $SUBDOMAIN."
done

echo "All subdomains have been updated."
