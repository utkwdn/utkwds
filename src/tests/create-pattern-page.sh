#!/bin/bash

# Check if WP-CLI is installed
if ! command -v wp &> /dev/null; then
    echo "WP-CLI is not installed. Please install it and make sure it's in your PATH."
    exit 1
fi

# Check if the pattern parameter is provided
if [ $# -lt 1 ]; then
    echo "Usage: $0 <pattern>"
    exit 1
fi

# Get pattern name from command line
PATTERN="$1"

# Set the path to the HTML file
CONTENT_FILE="/content/$PATTERN.html"
TITLE="Test Page $PATTERN patterns"

wp post create "$CONTENT_FILE" --post_type=page --post_title="$TITLE"

# Check if the page was created successfully
if [ $? -eq 0 ]; then
    echo "Page '$PATTERN' created successfully."
else
    echo "Failed to create '$PATTERN' page."
fi