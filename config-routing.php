<?php

use Project\RoutingInterface;

return [
    'route' => [
        RoutingInterface::ROUTE_INDEX => RoutingInterface::CONTROLLER_INDEX,
        RoutingInterface::ROUTE_LOGIN => RoutingInterface::CONTROLLER_INDEX,
        RoutingInterface::ROUTE_LOGIN_REDIRECT => RoutingInterface::CONTROLLER_INDEX,

        RoutingInterface::ROUTE_SEND_MAIL => RoutingInterface::CONTROLLER_MAILER,

        RoutingInterface::ROUTE_BACKEND_DASHBOARD => RoutingInterface::CONTROLLER_BACKEND,
        RoutingInterface::ROUTE_BACKEND_NEWS => RoutingInterface::CONTROLLER_BACKEND,
        RoutingInterface::ROUTE_BACKEND_GALLERY => RoutingInterface::CONTROLLER_BACKEND,
        RoutingInterface::ROUTE_BACKEND_SETTINGS => RoutingInterface::CONTROLLER_BACKEND,
        RoutingInterface::ROUTE_BACKEND_NEWS_CREATE => RoutingInterface::CONTROLLER_BACKEND,
        RoutingInterface::ROUTE_LOGOUT => RoutingInterface::CONTROLLER_BACKEND,
    ]
];