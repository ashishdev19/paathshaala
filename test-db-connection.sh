#!/bin/bash
# Quick Database Connection Test Script

echo "================================"
echo "Database Connection Test"
echo "================================"
echo ""

# Read .env file
if [ ! -f ".env" ]; then
    echo "❌ .env file not found!"
    exit 1
fi

source .env

echo "Testing connection with:"
echo "Host: $DB_HOST"
echo "Database: $DB_DATABASE"
echo "Username: $DB_USERNAME"
echo ""

# Test MySQL connection
mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "SELECT 1;" "$DB_DATABASE" 2>/dev/null

if [ $? -eq 0 ]; then
    echo "✅ Database connection successful!"
    echo ""
    echo "Testing Laravel connection..."
    php artisan tinker --execute="echo DB::connection()->getPdo() ? '✅ Laravel can connect to database' : '❌ Laravel cannot connect';"
else
    echo "❌ Database connection failed!"
    echo ""
    echo "Please check:"
    echo "1. Database exists: $DB_DATABASE"
    echo "2. User exists: $DB_USERNAME"
    echo "3. Password is correct"
    echo "4. User has privileges on database"
    echo "5. DB_HOST is 'localhost' not '127.0.0.1'"
fi
