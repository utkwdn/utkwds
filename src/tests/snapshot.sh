#!/bin/bash

# Check if WP-CLI is installed
if ! command -v wp &> /dev/null; then
    echo "WP-CLI is not installed. Please install it and make sure it's in your PATH."
    exit 1
fi

echo "Hello from the snapshot script!"