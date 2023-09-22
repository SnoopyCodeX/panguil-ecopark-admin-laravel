<?php

function panguil_asset($path, $secure = null) {
    if(app()->isProduction()) {
        return 'https://raw.githubusercontent.com/SnoopyCodeX/panguil-ecopark-admin-laravel/main/public/' . $path;
    }

    return app('url')->asset($path, $secure);
}

?>
