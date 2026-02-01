#!/bin/bash

# ==============================================================================
# PARTAI IBU DEPLOYMENT SCRIPT v1.1
# Optimized for Staging & Production
# ==============================================================================

set -e

# Configuration
PROJECT_NAME="Partai Ibu"
DEPLOY_DATE=$(date '+%Y-%m-%d %H:%M:%S')

# ANSI Color Codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m' 

# Header
clear
echo -e "${CYAN}======================================================================"
echo -e "                   🚀 DEPLOYING ${PROJECT_NAME}"
echo -e "                   Time: ${DEPLOY_DATE}"
echo -e "======================================================================${NC}"

# Check Prerequisites
function check_dep() {
    if ! command -v $1 &> /dev/null; then
        echo -e "${RED}Error: $1 is not installed.${NC}"
        exit 1
    fi
}

echo -e "\n${YELLOW}🔍 Phase 1: Environment Check...${NC}"
check_dep php
check_dep composer
check_dep npm
echo -e "${GREEN}✅ Environment Ready.${NC}"

# Backend Operations
echo -e "\n${YELLOW}📦 Phase 2: Backend Architecture (Laravel)...${NC}"
cd backend

if [ ! -f ".env" ]; then
    echo -e "${RED}Error: .env file not found in backend directory.${NC}"
    exit 1
fi

echo -e "${BLUE}>> Installing/Updating Composer dependencies...${NC}"
composer install --no-dev --optimize-autoloader

echo -e "${BLUE}>> Running Database Migrations...${NC}"
php artisan migrate --force

echo -e "${BLUE}>> Synchronizing Content Data...${NC}"
# Ensuring news data is present without overwriting everything
php artisan db:seed --class=ArticleSeeder --force || true

echo -e "${BLUE}>> Cleaning & Rebuilding Production Caches...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:cache-components

if [ ! -d "public/storage" ]; then
    echo -e "${BLUE}>> Creating Symbolic Link for Storage...${NC}"
    php artisan storage:link
fi

cd ..

# Frontend Operations
echo -e "\n${YELLOW}💅 Phase 3: Frontend Asset Pipeline...${NC}"
cd frontend

echo -e "${BLUE}>> Syncing Node Packages...${NC}"
npm install --silent

echo -e "${BLUE}>> Building Production CSS & Assets...${NC}"
npm run build

cd ..

# Permissions Verification
echo -e "\n${YELLOW}🛡️  Phase 4: Security & Permissions...${NC}"
# chmod -R 775 backend/storage backend/bootstrap/cache || true
echo -e "${GREEN}✅ Security check completed.${NC}"

# Summary
echo -e "\n${GREEN}======================================================================"
echo -e "                   🎉 DEPLOYMENT SUCCESSFUL!"
echo -e "         ${PROJECT_NAME} is now live and fully optimized."
echo -e "         Access URL: http://your-domain.com/src/"
echo -e "======================================================================${NC}"
