<?php

namespace MtzJaime\RobotsSitemap;

use Route;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{

    protected $robots;
    protected $config;

    public function __construct(Robots $robots)
    {
        $this->robots = $robots;
        $this->config = config('robotsAgents');
    }

    /**
     * Create the response for robots.txt
     *
     * @return mixed
     */
    public function robots()
    {
        if ($this->config[ 'blockSite' ] != true) {

            if (!empty($this->config[ 'disallowURL' ])) {
                $this->robots->addUserAgent('*');
                foreach ($this->config[ 'disallowURL' ] as $disallowURL) {
                    $this->robots->addDisallow($disallowURL);
                }
            }

            if (!empty($this->config[ 'userAgent' ])) {
                foreach ($this->config[ 'userAgent' ] as $userAgentName => $urlBlock) {
                    $this->robots->addSpacer();
                    $this->robots->addUserAgent($userAgentName);
                    $this->robots->addDisallow($urlBlock);
                }
            }

            if (empty($this->config[ 'disallowURL' ]) && empty($this->config[ 'userAgent' ])) {
                $this->robots->addUserAgent('*');
                $this->robots->addAllow('/');
            }

            $this->robots->addSpacer();
            $this->robots->addSitemap(url('sitemap.xml'));

            return response($this->robots->generate(), 200)->header('Content-Type', 'text/plain');
        }

        $this->robots->addUserAgent('*');
        $this->robots->addDisallow('/');
        $this->robots->addSpacer();

        return response($this->robots->generate(), 200)->header('Content-Type', 'text/plain');

    }

    /**
     * Create the response for a sitemap.xml
     *
     * @return $this
     */
    public function siteMap()
    {
        $sitemap = [];
        $allRoutes = Route::getRoutes()->get('GET');
        $exclude = $this->config[ 'excludeSiteMap' ];
        $date = Carbon::now()->format('Y-m-d');

        foreach ($allRoutes as $routeKey => $routeValue) {
            if (!in_array($routeKey, $exclude)) {

                $explodeBracket = explode('{', $routeKey);

                $priority = explode('://', url($routeKey));
                $priority = 1 - (substr_count($priority[1], '/') / 10);

                $sitemap[] = [
                    'locate'   => $explodeBracket[ 0 ],
                    'lastMod'  => $date,
                    'priority' => $priority,
                ];
            }
        }

        return response()->view('sitemap::show', compact('sitemap'))->header('Content-Type', 'text/xml');
    }
}