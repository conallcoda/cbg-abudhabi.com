#!/bin/bash

# Define the file path
FILE_PATH="assets/dist/main.css"

# Check if the file exists
if [[ -f "$FILE_PATH" ]]; then
  # Use sed to find and replace the pattern
  sed -i 's/ (width>=/ (min-width:/g' "$FILE_PATH"
  echo "Replacement complete."
else
  echo "File not found: $FILE_PATH"
fi
