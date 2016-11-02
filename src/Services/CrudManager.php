<?php

namespace Akibatech\Crud\Services;

use Akibatech\Crud\Exceptions\InvalidRouteIdentifierException;
use Illuminate\Support\Facades\Route;

/**
 * Class CrudManager
 *
 * @package Akibatech\Crud\Services
 */
class CrudManager
{
    /**
     * @var string
     */
    protected $name = 'Entry';

    /**
     * @var string
     */
    protected $pluralized_name = 'Entries';

    /**
     * @var null|CrudEntry
     */
    protected $entry;

    /**
     * @var string
     */
    protected $route_uri_prefix = 'crud/';

    /**
     * @var string
     */
    protected $route_name_prefix = 'crud.';

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var array
     */
    protected $routes = [
        'index'  => [
            'method' => 'GET',
            'uri'    => 'index',
            'as'     => 'index',
            'action' => 'index'
        ],
        'create' => [
            'method' => 'GET',
            'uri'    => 'create',
            'as'     => 'create',
            'action' => 'create'
        ],
        'store'   => [
            'method' => 'POST',
            'uri'    => 'store',
            'as'     => 'store',
            'action' => 'store'
        ],
        'edit' => [
            'method' => 'GET',
            'uri'    => 'edit/{id}',
            'as'     => 'edit',
            'action' => 'edit'
        ],
        'update'  => [
            'method' => 'PUT',
            'uri'    => 'update',
            'as'     => 'update',
            'action' => 'update'
        ],
        'destroy' => [
            'method' => 'GET',
            'uri'    => 'destroy/{id}/{csrf}',
            'as'     => 'destroy',
            'action' => 'destroy'
        ],
    ];

    //-------------------------------------------------------------------------

    /**
     * @param   string $name
     * @param   null|string $pluralized_name
     * @return  self
     */
    public function setName($name, $pluralized_name = null)
    {
        $this->name = $name;
        $this->pluralized_name = is_null($pluralized_name) ? str_plural($name) : $pluralized_name;

        return $this;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  string
     */
    public function getPluralizedName()
    {
        return $this->pluralized_name;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   string $prefix
     * @return  self
     */
    public function setUriPrefix($prefix)
    {
        $this->route_uri_prefix = rtrim($prefix, "\r\n\r\0\x0B\\/") . '/';

        return $this;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  string
     */
    public function getUriPrefix()
    {
        return $this->route_uri_prefix;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   string $prefix
     * @return  self
     */
    public function setNamePrefix($prefix)
    {
        $this->route_name_prefix = rtrim($prefix, "\r\n\r\0\x0B\\/.") . '.';

        return $this;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   string $prefix
     * @return  string
     */
    public function getNamePrefix($prefix)
    {
        return $this->route_name_prefix;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  string
     */
    public function getController()
    {
        return $this->controller;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   string $prefix
     * @return  self
     */
    public function setController($prefix)
    {
        $this->controller = $prefix;

        return $this;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   string $identifier
     * @return  string
     * @throws  InvalidRouteIdentifierException
     */
    public function getActionRoute($identifier)
    {
        if (array_key_exists($identifier, $this->routes))
        {
            $route = $this->routes[$identifier];
            $name = $this->route_name_prefix . $route['as'];
            $params = [];

            if ($identifier == 'destroy')
            {
                $params = [$this->entry->getId(), csrf_token()];
            }

            if ($identifier == 'update' || $identifier == 'edit')
            {
                $params = [$this->entry->getId()];
            }

            return route($name, $params);
        }

        throw new InvalidRouteIdentifierException("$identifier route identifier not found.");
    }

    //-------------------------------------------------------------------------

    /**
     * @param   string $identifier
     * @return  string
     * @throws  InvalidRouteIdentifierException
     */
    public function getActionMethod($identifier)
    {
        if (array_key_exists($identifier, $this->routes))
        {
            $route = $this->routes[$identifier];
            return $route['method'];
        }

        throw new InvalidRouteIdentifierException("$identifier route identifier not found.");
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  self
     */
    public function registerRoutes()
    {
        $routes = $this->routes;
        $controller = $this->controller;

        Route::group([
            'prefix' => $this->route_uri_prefix,
            'as'     => $this->route_name_prefix
        ], function ($router) use ($routes, $controller)
        {
            foreach ($routes as $route)
            {
                $action = $controller . '@' . $route['action'];

                $router->{$route['method']}($route['uri'], [
                    'as'   => $route['as'],
                    'uses' => $action
                ]);
            }
        });

        return $this;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   void
     * @return  CrudEntry|null
     */
    public function getEntry()
    {
        return $this->entry;
    }

    //-------------------------------------------------------------------------

    /**
     * @param   CrudEntry $entry
     * @return  self
     */
    public function setEntry(CrudEntry $entry)
    {
        $this->entry = $entry;

        return $this;
    }
}