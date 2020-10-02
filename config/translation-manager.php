<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Routes group config
    |--------------------------------------------------------------------------
    |
    | The default group settings for the elFinder routes.
    |
    */
    'route'             => [
        'prefix'     => 'translations',
        'middleware' => 'auth',
    ],

    /**
     * Enable deletion of translations
     *
     * @type boolean|callable
     */
    'delete_enabled'    => true,

    /**
     * Enable creating of translations
     *
     * @type boolean|callable
     */
    'creating_enabled'  => true,

    /**
     * Enable import of translations
     *
     * @type boolean|callable
     */
    'import_enabled'    => true,

    /**
     * Enable find of translations
     *
     * @type boolean|callable
     */
    'find_enabled'      => true,

    /**
     * Enable publish of translations
     *
     * @type boolean|callable
     */
    'publish_enabled'    => true,

    /**
     * Exclude specific groups from Laravel Translation Manager.
     * This is useful if, for example, you want to avoid editing the official Laravel language files.
     *
     * @type array|callable
     *
     *    array(
     *        'pagination',
     *        'reminders',
     *        'validation',
     *    )
     */
    'exclude_groups'    => [],

    /**
     * Export translations with keys output alphabetically.
     */
    'sort_keys '        => false,

    /**
     * The database connection to use.
     *
     * @type string|null
     */
    'db_connection'     => null,

    /**
     * Set the position of the menu in a translations group
     *
     * @type string    top|bottom
     */
    'menu_position'     => 'top',

    /**
     * Support Grammarly (maks
     *
     * @type bool
     */
    'support_grammarly' => false,

    /**
     * Enable services of translations
     *
     * @type array
     */
    'services'          => [
        'deepl' => [
            'enabled'        => false,
            'default_locale' => null, // The local to be preselected to use as base translation
        ],
    ],

];
