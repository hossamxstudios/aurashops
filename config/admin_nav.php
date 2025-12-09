<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Navigation Items
    |--------------------------------------------------------------------------
    |
    | This configuration defines the sidebar navigation items for the admin panel.
    | Each managed model should have an entry here.
    |
    */

    'items' => [
        // Dashboard
        [
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'layout-dashboard',
            'active' => ['admin.dashboard'],
            'type' => 'link',
        ],

        // Sales & POS
        [
            'label' => 'Sales & POS',
            'type' => 'divider',
        ],
        [
            'label' => 'POS',
            'route' => 'admin.pos.index',
            'icon' => 'calculator',
            'active' => ['admin.pos.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Orders',
            'route' => 'admin.orders.index',
            'icon' => 'shopping-cart',
            'active' => ['admin.orders.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Return Orders',
            'route' => 'admin.return-orders.index',
            'icon' => 'package-x',
            'active' => ['admin.return-orders.*'],
            'type' => 'link',
        ],

        // Products
        [
            'label' => 'Products',
            'type' => 'divider',
        ],
        [
            'label' => 'All Products',
            'route' => 'admin.products.index',
            'icon' => 'package',
            'active' => ['admin.products.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Categories',
            'route' => 'admin.categories.index',
            'icon' => 'folder-tree',
            'active' => ['admin.categories.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Brands',
            'route' => 'admin.brands.index',
            'icon' => 'award',
            'active' => ['admin.brands.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Genders',
            'route' => 'admin.genders.index',
            'icon' => 'user-round',
            'active' => ['admin.genders.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Attributes',
            'route' => 'admin.attributes.index',
            'icon' => 'sliders-horizontal',
            'active' => ['admin.attributes.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Tags',
            'route' => 'admin.tags.index',
            'icon' => 'tags',
            'active' => ['admin.tags.*'],
            'type' => 'link',
        ],

        // Inventory
        [
            'label' => 'Inventory',
            'type' => 'divider',
        ],
        [
            'label' => 'Stocks',
            'route' => 'admin.stocks.index',
            'icon' => 'box',
            'active' => ['admin.stocks.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Warehouses',
            'route' => 'admin.warehouses.index',
            'icon' => 'warehouse',
            'active' => ['admin.warehouses.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Suppliers',
            'route' => 'admin.suppliers.index',
            'icon' => 'truck',
            'active' => ['admin.suppliers.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Supplies',
            'route' => 'admin.supplies.index',
            'icon' => 'package-plus',
            'active' => ['admin.supplies.*'],
            'type' => 'link',
        ],

        // Shipping & Delivery
        [
            'label' => 'Shipping & Delivery',
            'type' => 'divider',
        ],
        [
            'label' => 'Shipments',
            'route' => 'admin.shipments.index',
            'icon' => 'truck',
            'active' => ['admin.shipments.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Shippers',
            'route' => 'admin.shippers.index',
            'icon' => 'package-open',
            'active' => ['admin.shippers.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Shipping Rates',
            'route' => 'admin.shipping-rates.index',
            'icon' => 'badge-dollar-sign',
            'active' => ['admin.shipping-rates.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Locations',
            'route' => 'admin.locations.index',
            'icon' => 'map-pin',
            'active' => ['admin.locations.*', 'admin.cities.*', 'admin.zones.*', 'admin.districts.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Pickup Locations',
            'route' => 'admin.pickup-locations.index',
            'icon' => 'map-pinned',
            'active' => ['admin.pickup-locations.*'],
            'type' => 'link',
        ],

        // Customers
        [
            'label' => 'Customers',
            'type' => 'divider',
        ],
        [
            'label' => 'All Clients',
            'route' => 'admin.clients.index',
            'icon' => 'users',
            'active' => ['admin.clients.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Skin Tones',
            'route' => 'admin.skin-tones.index',
            'icon' => 'palette',
            'active' => ['admin.skin-tones.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Skin Types',
            'route' => 'admin.skin-types.index',
            'icon' => 'droplet',
            'active' => ['admin.skin-types.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Concerns',
            'route' => 'admin.concerns.index',
            'icon' => 'alert-circle',
            'active' => ['admin.concerns.*'],
            'type' => 'link',
        ],

        // Marketing & Promotions
        [
            'label' => 'Marketing',
            'type' => 'divider',
        ],
        [
            'label' => 'Coupons',
            'route' => 'admin.coupons.index',
            'icon' => 'ticket',
            'active' => ['admin.coupons.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Newsletter',
            'route' => 'admin.newsletters.index',
            'icon' => 'mail',
            'active' => ['admin.newsletters.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Contact Forms',
            'route' => 'admin.contact-forms.index',
            'icon' => 'message-square',
            'active' => ['admin.contact-forms.*'],
            'type' => 'link',
        ],

        // Content
        [
            'label' => 'Content',
            'type' => 'divider',
        ],
        [
            'label' => 'Blogs',
            'route' => 'admin.blogs.index',
            'icon' => 'file-text',
            'active' => ['admin.blogs.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Topics',
            'route' => 'admin.topics.index',
            'icon' => 'folder',
            'active' => ['admin.topics.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Videos',
            'route' => 'admin.videos.index',
            'icon' => 'video',
            'active' => ['admin.videos.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Playlists',
            'route' => 'admin.playlists.index',
            'icon' => 'list-video',
            'active' => ['admin.playlists.*'],
            'type' => 'link',
        ],

        // Settings & Configuration
        [
            'label' => 'Configuration',
            'type' => 'divider',
        ],
        [
            'label' => 'Order Statuses',
            'route' => 'admin.order-statuses.index',
            'icon' => 'list-checks',
            'active' => ['admin.order-statuses.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Payment Methods',
            'route' => 'admin.payment-methods.index',
            'icon' => 'credit-card',
            'active' => ['admin.payment-methods.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Bank Accounts',
            'route' => 'admin.bank-accounts.index',
            'icon' => 'landmark',
            'active' => ['admin.bank-accounts.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Return Reasons',
            'route' => 'admin.return-reasons.index',
            'icon' => 'list',
            'active' => ['admin.return-reasons.*'],
            'type' => 'link',
        ],
        [
            'label' => 'Settings',
            'route' => 'admin.settings.index',
            'icon' => 'settings',
            'active' => ['admin.settings.*'],
            'type' => 'link',
        ],
    ],
];
