# Easytrans

!ALPHA RELEASE!

Easy to use Translationsupport for your multilanguale Laravel App.

Export Excel files, translate it and import it again.

It's as easy as it sounds...

Test it now!


# Installation
add service provider: 

    Fr3ddy\Easytrans\EasytransServiceProvider::class,

Check that excel is working.

and publish config and set "force_sheets_collection" = true (line 466)

and add alias:
    
    'Excel' => Maatwebsite\Excel\Facades\Excel::class,
