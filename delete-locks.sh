
TARGET_DIR="content"

# Check if the target directory exists
if [ ! -d "$TARGET_DIR" ]; then
    echo "Error: Directory $TARGET_DIR does not exist."
    exit 1
fi

echo "Searching for .lock files in $TARGET_DIR and subdirectories..."

# Find and count .lock files before deletion
LOCK_COUNT=$(find "$TARGET_DIR" -type f -name ".lock" | wc -l)

if [ "$LOCK_COUNT" -eq 0 ]; then
    echo "No .lock files found."
    exit 0
fi

echo "Found $LOCK_COUNT .lock file(s). Removing them..."

# Find and remove all .lock files, showing what's being deleted
find "$TARGET_DIR" -type f -name ".lock" -print -delete

echo "Removal complete. $LOCK_COUNT .lock file(s) have been removed."