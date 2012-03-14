# Fuel-MediaTemple

Fuel-MediaTemple is a package for use with the [FuelPHP Framework](http://fuelphp.com/) to interact with the [(mt) ProDev API](http://mediatemple.net/api/).

## Installation

If you're using `oil` simply add the following entry to your `/fuel/app/config/package.php` file..

    return array (

    	'sources' => array (
    		'github.com/tarnfeld',
    	)
    );

Once you've added that, then run `php oil install mediatemple` from your application root to install the package. Alternatvely you can just download the source and pop it in your `/fuel/app/packages/` directory.

You'll need to create a new `mediatemple.php` config file in your app's config directory, and add your API key, like this...

    return array(
   		'apikey' => 'YOUR_APIKEY_HERE'
    );


## Usage

TODO: Write this.

## Contributing

1. Fork Snowey
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Added some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request in Github
