#!/bin/bash

# Ensure we have three arguments: target-dir-wildcard, app-code, and domain name
if [ "$#" -ne 3 ]; then
    echo "Usage: $0 <target-dir-wildcard> <app-code> <domain-name>"
    exit 1
fi

TARGET_DIR_PATTERN=$1
NEW_APP_CODE=$2
DOMAIN_NAME=$3

# Find the actual directory based on the wildcard pattern
TARGET_DIR=$(eval echo $TARGET_DIR_PATTERN)

# Validate that the directory exists
if [ ! -d "$TARGET_DIR" ]; then
    echo "Error: Target directory '$TARGET_DIR' does not exist."
    exit 1
fi

echo "Working in directory: $TARGET_DIR"

# Navigate to the target directory
cd "$TARGET_DIR" || exit 1

# Remove all existing files in the directory
echo "Deleting existing files in $TARGET_DIR..."
rm -rf *

# Clone the Git repository
git clone https://github.com/admk-team/tv-app.git .

# Set Git safe directory
git config --global --add safe.directory "$TARGET_DIR"

# Copy vendor and .env files from the main source
cp -r /home/octv.online/public_html/vendor "$TARGET_DIR"
cp /home/octv.online/public_html/.env "$TARGET_DIR"

# Replace the APP_CODE value in the .env file
sed -i "s/^APP_CODE=.*/APP_CODE=\"$NEW_APP_CODE\"/" "$TARGET_DIR/.env"

# Update the docRoot in the vHost configuration file for the domain
VHOST_FILE="/usr/local/lsws/conf/vhosts/$DOMAIN_NAME/vhost.conf"

if [ ! -f "$VHOST_FILE" ]; then
    echo "Error: vHost configuration file for $DOMAIN_NAME not found."
    exit 1
fi

echo "Modifying the docRoot in vHost configuration file..."

# Use sed to change the docRoot path
sed -i 's|docRoot                   \$VH_ROOT/public_html|docRoot                   \$VH_ROOT/public_html/public|' "$VHOST_FILE"

# Modify extProcessor to use lsphp82 instead of lsphp74
echo "Updating extProcessor PHP version..."
sed -i 's|/usr/local/lsws/lsphp74/bin/lsphp|/usr/local/lsws/lsphp82/bin/lsphp|' "$VHOST_FILE"

# Restart the web server to apply the changes
systemctl restart lscpd

# Fix ownership and permissions
WEB_ROOT="/home/$DOMAIN_NAME/public_html"

if [ ! -d "$WEB_ROOT" ]; then
    echo "Error: Web root directory does not exist: $WEB_ROOT"
    exit 1
fi

echo "Fixing ownership and permissions for $DOMAIN_NAME..."

OWNER_GROUP=$(stat -c "%U:%G" "$WEB_ROOT")
OWNER=$(echo $OWNER_GROUP | cut -d ':' -f 1)
GROUP=$(echo $OWNER_GROUP | cut -d ':' -f 2)

echo "Changing ownership to $OWNER:$GROUP"
find "$WEB_ROOT" -type f -exec chown $OWNER:$OWNER {} \;
chown -R $OWNER:$OWNER "$WEB_ROOT"

find "$WEB_ROOT" -type d -exec chmod 755 {} \;
find "$WEB_ROOT" -type f -exec chmod 644 {} \;

echo "Permissions fixed successfully for $DOMAIN_NAME!"

echo "Script execution completed successfully."
