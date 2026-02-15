# Sylius DDEV + Windows Frontend Workflow

Doel: Veilige baseline voor cache, vendor, assets en Webpack Encore in Sylius.

---

## 1. Cache en vendor reset

```bash
# Stop DDEV container
ddev stop

# (optioneel) verwijder oude cache
rm -rf var/cache/*

# Controleer en herstel vendor packages
composer install

# Als corrupte bestanden aanwezig zijn:
rm -rf vendor/
composer install
```

## 2. Symfony clear cache

```bash
ddev ssh
bin/console cache:clear
```

## 3. Assets instaleren

```bash
# Symlink (Linux-host, sneller)
bin/console assets:install --symlink

# Kopie (Windows / PhpStorm, voorkomt broken symlinks)
bin/console assets:install --symlink=false
```

## 4. Node Models & Webpack Encore

```bash
# In DDEV container
rm -rf node_modules/   # optioneel, clean rebuild
yarn install           # of npm install

# Frontend build
npx encore dev         # development build
npx encore dev --watch # live rebuild tijdens ontwikkeling
npx encore production  # productie build
```
