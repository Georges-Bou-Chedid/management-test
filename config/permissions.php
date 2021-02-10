<?php

return [
    /*
     * Define the name of the table that should hold the user permissions.
     */
    'model' => \Fleetrunnr\Permissions\Models\Permission::class,

    /*
     * Define the name of the table that should hold the user permissions.
     */
    'table_name' => 'users',

    /*
     * Define the name of the permissions column
     */
    'column_name' => 'permissions',

    /*
     * When set to true, the permissions of a user are defined per account.
     * Each user might have a different set of permissions on multiple
     * accounts. Otherwise, it defaults to one set of permissions.
     */
    'supports-multiple-accounts' => false,

    /*
     * When defining permissions per account, this will specify the
     * account-user relationship.
     * set to `null` in default mode.
     */
    'multiple-accounts-relation' => 'accounts',

    /*
     * Define the permissions field of the authenticatable model.
     * This column will be used as a fallback to the cache.
     */
    'permissions_column' => 'permissions',

    'cache' => [
        /*
         * The cache key used to store user permissions.
         */
        'key_prefix' => 'fleetrunnr.permissions:',
    ],

    /*
     * Define the list of available permissions that can be assigned.
     */
    'list' => [
        [
            'name' => 'create-user',
            'description' => 'Allow user to create another user'
        ],
        [
            'name' => 'update-user',
            'description' => 'Allow user to update another user'
        ]
    ]
];
