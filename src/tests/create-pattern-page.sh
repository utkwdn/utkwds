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

# Get the directory of the script
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

echo "The script is located in the directory: $SCRIPT_DIR"

# Get pattern name from command line
PATTERN="$1"

# Set the path to the HTML file using the script's directory
CONTENT_FILE="$SCRIPT_DIR/$PATTERN.html"
TITLE="Test Page $PATTERN patterns"

# Check if the content file exists
if [ ! -f "$CONTENT_FILE" ]; then
    echo "Content file not found: $CONTENT_FILE"
    exit 1
fi

wp post create "$CONTENT_FILE" --post_type=page --post_title="$TITLE"

# Check if the page was created successfully
if [ $? -eq 0 ]; then
    echo "Page '$PATTERN' created successfully."
else
    echo "Failed to create '$PATTERN' page."
fi