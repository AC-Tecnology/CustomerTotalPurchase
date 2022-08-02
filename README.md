# Actecnology CustomerTotalPurchase for Magento 2

## How to install & upgrade Actecnology_Core

### 1. Install
#### 1 Install

```
copiar a  Actecnology/CustomerTotalPurchase
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

### 2. Copy and paste

If you want you can use this way. 

- Extract `master.zip` file to `app/code/Actecnology/CustomerTotalPurchase` ; You should create a folder path `app/code/Actecnology/CustomerTotalPurchase` if not exist.
- Go to Magento root folder and run upgrade command line to install `Actecnology_CustomerTotalPurchase`:

```
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```
