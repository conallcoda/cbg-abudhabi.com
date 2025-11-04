#!/bin/bash

# Starting directory (can be modified to any path)
START_DIR="."

# Find all files named "speaker.txt" and rename them to "profile.txt"
find "$START_DIR" -type f -name "blog_article.txt" -execdir mv {} article.txt \;

echo "All files have been renamed."