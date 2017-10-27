# Simple blockchain indexer written as a laravel command

This is a very simple blockchain indexer, for those who want to build a blockexplorer. 



# Install


You will need a RPC client set up, with the following information in the bitcoin.conf file:

    regtest=1 // you can remove this if you want to create your own blockchain, but the rest is MANDATORY
    txindex=1
    addrindex=1 
    server=1
    rpcuser=REPLACE_ME
    rpcpassword=REPLACE_ME

Download this package: https://github.com/denpamusic/laravel-bitcoinrpc
or use the install instructions:

 
Run ```php composer.phar require denpa/laravel-bitcoinrpc``` in your project directory or add following lines to composer.json
```json
"require": {
    "denpa/laravel-bitcoinrpc": "^1.1"
}
```
and run ```php composer.phar update```.

Add `Denpa\Bitcoin\Providers\ServiceProvider::class,` line to the providers list somewhere near the bottom of your /config/app.php file.
```php
'providers' => [
    ...
    Denpa\Bitcoin\Providers\ServiceProvider::class,
];
```

Publish config file by running
`php artisan vendor:publish --provider="Denpa\Bitcoin\ServiceProvider"` in your project directory.

You might also want to add facade to $aliases array in /config/app.php.
```php
'aliases' => [
    ...
    'Bitcoind' => Denpa\Bitcoin\Facades\Bitcoind::class,
];
```

I recommend you to use .env file to configure client.
To connect to Bitcoin Core you'll need to add at least following parameters
```
BITCOIND_USER=(rpcuser from bitcoin.conf)
BITCOIND_PASSWORD=(rpcpassword from bitcoin.conf)
```

## Requirements
* PHP 7.0 or higher (should also work on 5.6, but this is unsupported)
* Laravel 5.1 or higher


Now copy the models folder in to your `app` directory, and the `console/commands` folder in to the `app`directory. Copy the migration files to the correct location


You should now be able to run the artisan command 

    php artisan crypto:store-blockchain


This will take a long time. You will need a large Db (100gb+)