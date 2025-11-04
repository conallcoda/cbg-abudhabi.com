#!/bin/bash

# Loop through all directories in the current folder
for dir in */; do
    # Remove the trailing slash
    dir=${dir%/}
    
    # Use parameter expansion to remove leading digits and underscores
    new_name=$(echo "$dir" | sed 's/^[0-9_]*//g')
    
    # Check if the name has changed
    if [ "$dir" != "$new_name" ]; then
        # Rename the directory
        mv "$dir" "$new_name"
        echo "Renamed: $dir -> $new_name"
    fi
done